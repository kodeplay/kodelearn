<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Post extends Controller_Base {

    protected $_errors = array();
	
    /**
     * Action to display the form for adding posts
     */
    public function action_form() {
        $view = View::factory('post/form')
            ->bind('visibility_options', $visibility_options)
            ->bind('roles', $roles)
            ->bind('courses', $courses)
            ->bind('batches', $batches);            
        $visibility_options = array(
            'everyone' => __('Everyone'),
            'batch' => __('Only a specific Batch'),
            'course' => __('Only a specific Course'),
            'role'  => __('Only some roles'),
        );
        $roles = ORM::factory('role')->find_all()->as_array('id', 'name');
        $batches = ORM::factory('batch')->find_all()->as_array('id', 'name');
        $courses = ORM::factory('course')->find_all()->as_array('id', 'name');
        $this->content = $view;
    }

    /**
     * Action for adding the post to database
     */
    public function action_add() {
    	
    	
    	if($this->validate()){
	    	$post = ORM::factory('post');
	    	
	    	$post->message = $this->request->post('post');
	    	$post->link = $this->request->post('link');
	    	$post->user_id = Auth::instance()->get_user()->id;
	    	$post->save();
	    	
	    	$data = array(
	            'course_id'     => $this->request->post('course'),
	            'batch_id'      => $this->request->post('batch'),
	            'role_id'       => $this->request->post('role_id'),
	    	    'post_id'       => $post->id,
	    	    'selected_roles'=> $this->request->post('selected_roles'),
	    	    'post_setting'  => $this->request->post('post_setting')
	    	);
	    	
	    	$this->add_feed($data);
	    	
	    	$html = Request::factory('feed/index')
            ->method(Request::GET)
            ->execute()
            ->body();
	    	
	    	$json = array(
	    	  'success'   => 1,
	    	  'html'      => $html
	    	);
    		
    	} else {
    		$json = array(
    		  'success' => 0,
    		  'errors'  => $this->_errors
    		);
    	}
    	
    	echo  json_encode($json);
    	exit;
    }
    
    private function add_feed($data){
    	
        $feed = new Feed_Post();
        

        $feed->set_action('add');
        $feed->set_respective_id($data['post_id']);
        $feed->set_actor_id(Auth::instance()->get_user()->id); 
        $feed->save();
    	
        switch ($data['post_setting']){
        	
        	case 'role':
        		if(!$data['selected_roles']){
        			$this->_errors[] = 'Please select atleast one role';
        		} else {
        			foreach($data['selected_roles'] as $role_id){
        				$users = Model_Role::get_users(ORM::factory('role', $data['role_id'])->name);
        				$feed->subscribe_users($users);
        			}
        		}
        		break;
        		
        	case 'batch':
                if(!$data['selected_roles']){
                    $users = ORM::factory('batch',$data['batch'])->users;
                    $feed->subscribe_users($users);
                } else {
                    foreach($data['selected_roles'] as $role_id){
                        $users = Model_Batch::get_users($data['batch'], ORM::factory('role', $role_id)->name);
                        $feed->subscribe_users($users);
                    }
                }
        		break;
        		
        	case 'course':
                if(!$data['selected_roles']){
                    $users = ORM::factory('course',$data['course'])->users;
                    $feed->subscribe_users($users);
                } else {
                    foreach($data['selected_roles'] as $role_id){
                        $users = Model_Course::get_users($data['course'], ORM::factory('role', $role_id)->name);
                        $feed->subscribe_users($users);
                    }
                }
        		break;
        		
        	default:
        		$users = ORM::factory('user')->find_all();
        		$feed->subscribe_users($users);
        }
        
        $users = array(Auth::instance()->get_user());
        
        $feed->subscribe_users($users);
    }
    
    private function validate() {
    	
    	if(($this->request->post('post_setting') == 'role') AND (!$this->request->post('selected_roles'))){
    		$this->_errors[] = 'Please select atleast one role';
    	}
    	
    	if($this->request->post('post') == ''){
    		$this->_errors[] = 'Please enter some message';
    	}
    	
    	if(!$this->_errors){
    		return true;
    	} else {
    		return false;
    	}
    }
}