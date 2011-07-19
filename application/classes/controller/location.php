<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Location extends Controller_Base {

    protected $_errors = array();

    
    public function action_index() {
        $submitted_form = '';
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $submitted_form = 'location';
            $this->add();
            
        }
                
        $view = View::factory('location/location')
            ->bind('form_location', $form_location)
            ->bind('table_locations', $table_location);        
        $form_location = $this->form_location(($submitted_form === 'location'));
        $table_location = $this->table_location();
        
        $this->content = $view;
    }
    
    private function form_location($submitted = false) {
        $action = 'location/index';
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'name' => '',
            'image' => '',
            
        );
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Name', 'name', 'text');
        $form->append('Image', 'image', 'text');
        $form->append('Add', 'submit', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        return $form;
    }
    
    private function add() {
        $location = ORM::factory('location');
        $validator = $location->validator_location($this->request->post());
        if ($validator->check()) {
            
            $location->values($validator->as_array());
            $location->save();
            Request::current()->redirect('location');
            exit;
        } else {
            
            $this->_errors = $validator->errors('location');
        }
    }
    
    private function table_location() {
        $locations = ORM::factory('location')->find_all()->as_array();
                       
        return $locations;
    }
    
    
    
}
