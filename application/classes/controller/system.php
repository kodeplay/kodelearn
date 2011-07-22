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

        // get all roles
        $roles = ORM::factory('role')->find_all()->as_array('id', 'name');
        

        $this->content = $view;
    }
    
    protected function form($data, $errors) {
        $action = 'system';
        $form = new Stickyform($action, array(), $errors);
        $fields = array('name', 'type_id', 'logo', 'website', 'address', 'allow_registration', 'default_role', 'user_approval');
        $form->default_data = array_fill_keys($fields, '');
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $form->posted_data = $this->request->post();
        } else {
            $form->posted_data = array();
        }
        //        $form->append('Institution Name', 'name', 

                               

    }
}
