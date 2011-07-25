<?php defined('SYSPATH') or die('No direct script access.');

class Controller_System extends Controller_Base {

    public function action_index() {
        $view = View::factory('system/form')
            ->bind('form', $form);

        // if post, validate, save and redirect
        if ($this->request->method() === 'POST' && $this->request->post()) {
            // save 

            // redirect
        }

        // get data from the table,
        // for now we assume that there is only one institution in the db
        // and find a single row.

        // get all institution types

        $this->form(array(), array());
        

        $this->content = $view;
    }
    
    protected function form($saved_data, $errors) {
        $action = 'system';
        // get all roles
        $roles = ORM::factory('role')->find_all()->as_array('id', 'name');
        // get all institution types
        $institution_types = ORM::factory('institutiontype')->find_all()->as_array('id', 'name');
        // get settings
        $config = Config::instance();
        $config_settings = $config->load('config')->as_array();        
        $form = new Stickyform($action, array(), $errors);
        $fields = array(
            'name', 
            'institutiontype_id', 
            'logo', 'website', 
            'address', 
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
            $this->saved_data = $saved_data;
         }
         if ($this->request->method() === 'POST' && $this->request->post()) {
             $form->posted_data = $this->request->post();
         } else {
             $form->posted_data = array();
         }
         $form->append('Institution Name', 'name', 'text')
             ->append('Institution Type', 'institutiontype_id', 'select', array('options' => $institution_types))
             ->append('Logo', 'logo', 'text')
             ->append('Website', 'website', 'text')
             ->append('Address', 'address', 'textarea')
             ->append('Membership', 'config_membership', 'checkbox', array(
                 'attributes' => array(
                     'value' => 1,
                     'name' => 'config[membership]',
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
             ->process();
         // var_dump($form);
         return $form;
    }
}
