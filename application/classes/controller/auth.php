<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller {

    public function action_login() {
        $form = $this->form_login();
        var_dump($form);
        exit;
    }

    private function form_login() {
        $action = 'auth/login';
        $form = new Stickyform($action);
        $form->default_data = array(
            'email' => '',
            'password' => '',
        );
        $form->posted_data = $this->request->post();
        $form->append('Email', 'email', 'text');
        $form->append('Password', 'password', 'password');
        $form->process();
        return $form;
    }

    public function action_register() {
        
    }

    private function form_register() {
        
    }

    public function action_logout() {

    }

    public function action_recoverpass() {

    }
}