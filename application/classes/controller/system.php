<?php defined('SYSPATH') or die('No direct script access.');

class Controller_System extends Controller_Base {

    public function action_index() {
        $view = View::factory('system/form')
            ->bind('form', $form)
            ->bind('image', $image)
            ->bind('upload_url', $upload_url);
        $institution = ORM::factory('institution', $id=1);
        $config = Config::instance();
        $config_settings = $config->load('config')->as_array();    
               
        // if post, validate, save and redirect
        if ($this->request->method() === 'POST' && $this->request->post()) {
            
            $config_post = $this->request->post('config');
            if(isset($config_post['membership'])){
                $config_post['membership'];
            } else {
                $config_post['membership'] = 0;
            }
            if(isset($config_post['user_approval'])){
                $config_post['user_approval'];
            } else {
                $config_post['user_approval'] = 0;
            }
            //echo $config_post['membership'];
            //exit;
            $institution->name = $this->request->post('name');
            $institution->institution_type_id = $this->request->post('institutiontype_id');
            $institution->logo = $this->request->post('logo');
            $institution->website = $this->request->post('website');
            $institution->address = $this->request->post('address');
            $institution->save();
            $config->load('config')->setMany($config_post);
            Request::current()->redirect('system');
            exit;
            
        }
        
        $upload_url = URL::site('system/uploadinst');
        $images = CacheImage::factory();
        $image = $images->resize($institution->logo, 100, 100);
        
        $form = $this->form(array(
            'name' => $institution->name, 
            'institutiontype_id' => $institution->institution_type_id, 
            'logo' => $institution->logo, 
            'website' => $institution->website, 
            'address' => $institution->address, 
            'config' => $config_settings), array());        

        $this->content = $view;
    }
    
    protected function form($saved_data, $errors) {
        $action = 'system';
        // get all roles
        $roles = ORM::factory('role')->find_all()->as_array('id', 'name');
        // get all institution types
        $institution_types = ORM::factory('institutiontype')->find_all()->as_array('id', 'name');
        // get languages 
        $language = array(
            '1' => 'English',
            '2' => 'French',
            '3' => 'Deutsch',
            '4' => 'Español',
        );
               
        $form = new Stickyform($action, array(), $errors);
        $fields = array(
            'name', 
            'institutiontype_id', 
            'logo', 'website', 
            'address',
            'config_language_id', 
            'config_membership', 
            'config_default_role', 
            'config_user_approval'
        );
        $form->default_data = array_fill_keys($fields, '');
        if ($saved_data) {
            $saved_config = $saved_data['config'];
            unset($saved_data['config']);
            foreach ($saved_config as $key=>$value) {
                $saved_data['config_' . $key] = $value;
            }
            $form->saved_data = $saved_data;
        }
        //$form->saved_data = $saved_data; 
        if ($this->request->method() === 'POST' && $this->request->post()) {
             $form->posted_data = $this->request->post();
         } else {
             $form->posted_data = array();
         }
         
         $form->append('Institution Name', 'name', 'text')
             ->append('Institution Type', 'institutiontype_id', 'select', array('options' => $institution_types))
             ->append('Logo', 'logo', 'hidden')
             ->append('Website', 'website', 'text')
             ->append('Address', 'address', 'textarea')
             ->append('Language', 'config_language_id', 'select', array('options' => $language,
                 'attributes' => array(
                     'name' => 'config[language_id]',
                 ),   
             ))
             ->append('Membership', 'config_membership', 'checkbox', array(
                 'attributes' => array(
                    'name' => 'config[membership]', 
                    'value' => 1,
                 )
             ))
             ->append('Default Role', 'config_default_role', 'select', array(
                 'attributes' => array(
                     'name' => 'config[default_role]',
                 ),
                 'options' => $roles,
             ))
             ->append('User Approval', 'config_user_approval', 'checkbox', array(
                 'attributes' => array(
                     'value' => 1,
                     'name' => 'config[user_approval]',
                 )
             ))
             ->append('Save Changes', 'save', 'submit', array('attributes' => array('class' => 'button')))
             ->process();
         // var_dump($form);
         return $form;
    }
    
    public function action_uploadinst(){
        
        $filename = 'inst_'.time() . '_' . $_FILES['image']['name'];
                
        $file_validation = new Validation($_FILES);
        $file_validation->rule('image','upload::valid');
        $file_validation->rule('image', 'upload::type', array(':value', array('jpg', 'png', 'gif', 'jpeg')));
        
        if ($file_validation->check()){
            
            if($path = Upload::save($_FILES['image'], $filename, DIR_IMAGE)){
                
                $images = CacheImage::factory();;
                $src = $images->resize($filename, 100, 100);

                
                
                $json = array(
                   'success'   => 1,
                   'image'     => $src,
                   'filename'  => $filename 
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
}