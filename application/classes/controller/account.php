<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller_Base {
	
    public function action_index(){
		
    	$user = Auth::instance()->get_user();
    	$submitted = FALSE;
    	
         if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $validator = $user->validator_profile($this->request->post());
                $validator->bind(':user', $user);
                if ($validator->check()) {
                	$user->firstname = $this->request->post('firstname');
                    $user->lastname = $this->request->post('lastname');
                    $user->email = $this->request->post('email');
                    if($this->request->post('password')){
                    	$user->password = Auth::instance()->hash($this->request->post('password'));
                    }
                    $user->save();
                    Request::current()->redirect('account');
                } else {
                    $this->_errors = $validator->errors('register');
                }
            }
         }
       
        $form = new Stickyform('account/index', array(), ($submitted ? $this->_errors : array()));
    	
        $form->default_data = array(
            'firstname' => '',
            'lastname'  => '',
            'email'     => '',
        );
    	
        $form->saved_data = array(
            'firstname' => $user->firstname,
            'lastname'  => $user->lastname,
            'email'     => $user->email,
        );
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('First Name', 'firstname', 'text');
        $form->append('Last Name', 'lastname', 'text');
        $form->append('Email', 'email', 'text');
        $form->append('Password', 'password', 'password');
        $form->append('Confirm Password', 'confirm_password', 'password');
        $form->append('Save Changes', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        
        $upload_url = URL::site('account/uploadavatar');

        $image = CacheImage::factory();
        $avatar = $image->resize($user->avatar, 100, 100);
         
        $view = View::factory('account/profile')
                    ->bind('form', $form)
                    ->bind('upload_url', $upload_url)
                    ->bind('user', $user)
                    ->bind('avatar', $avatar);
                    
		$this->content = $view;
	}
	
	public function action_uploadavatar(){
		
        $filename = time() . '_' . $_FILES['image']['name'];
                
        $file_validation = new Validation($_FILES);
        $file_validation->rule('image','upload::valid');
        $file_validation->rule('image', 'upload::type', array(':value', array('jpg', 'png', 'gif', 'jpeg')));
		
		if ($file_validation->check()){
			
			if($path = Upload::save($_FILES['image'], $filename, DIR_IMAGE)){
				
				$image = CacheImage::factory();
				$src = $image->resize($filename, 100, 100);

				$user = Auth::instance()->get_user();
				$user->avatar = $filename;
				$user->save();
				
				$json = array(
	               'success'   => 1,
				   'image'     => $src
	            );
	        } else {
	        	$json = array(
	        	   'success'  => 0,
	        	   'errors'   => array('image' => 'The file is not a valid Image')
	        	);
	        }
		} else {
			$json = array(
			     'success'   => 0,
			     'errors'    => (array) $file_validation->errors('profile')
			);
		}
		
		 
		echo json_encode($json);
		exit;
		
	}
	
	public function action_test(){
		
		$path = 'F:\wamp\www\projects\kodelearn\media\image\data\jimit.jpeg';
		$filename = 'jimit.jpeg';
		
              $user = Auth::instance()->get_user();
              $user->avatar = $filename;
              $user->save;
				
		$image = Image::factory($path);
		$image->background('red');
		$image->resize(100, 100, Image::AUTO)->save(DIR_IMAGE.'cache/'.$filename);
		var_dump($image->render());
		echo 'hi'; exit;
	}
	
}