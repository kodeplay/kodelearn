<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller_Base {

    protected $_errors = array();

    /**
     * Override the parent's auth_filter method
     * this is to ensure that only a non-logged in user can access 
     * this page. other wise redirected to /home
     */
    protected function auth_filter() {
        $user = Auth::instance()->get_user();
        if ($user !== null) {
            Request::current()->redirect('home');
        }
        return parent::auth_filter();
    }

    public function action_index() {
        $posted_login = array();
        $posted_register = array();
        $submitted_form = '';
        if ($this->request->method() === 'POST' && $this->request->post()) {
            if (Arr::get($this->request->post(), 'login') !== null) {
                $submitted_form = 'login';
                $this->login();
            } elseif (Arr::get($this->request->post(), 'register') !== null) {
                $submitted_form = 'register';
                $this->register();
            }
        }
        $view = View::factory('auth/signupLogin')
            ->bind('form_login', $form_login)
            ->bind('form_register', $form_register)
            ->bind('links', $links);        
        $form_login = $this->form_login(($submitted_form === 'login'));
        $form_register = $this->form_register(($submitted_form === 'register'));
        $links = array(
            'forgot_password' => Html::anchor('/auth/forgot_password/', 'Forgot Password', array('class' => 'tdblue bold'))
        );
        $this->content = $view;
    }

    private function form_login($submitted = false) {
        $action = 'auth/index';
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'email' => '',
            'password' => '',
            'remember' => '',
        );
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Email', 'email', 'text');
        $form->append('Password', 'password', 'password');
        $form->append('Login', 'login', 'submit', array('attributes' => array('class' => 'button')));
        $form->append('Remember me on this computer', 'remember', 'checkbox');
        $form->process();
        return $form;
    }

    private function login() {
        $user = ORM::factory('user');
        $validator = $user->validator_login($this->request->post());
        if ($validator->check()
            && Auth::instance()->login($validator['email'], $validator['password'])) {
            Request::current()->redirect('home');
            exit;
        } else {
            $this->_errors = $validator->errors('login');
        }
    }

    private function register() {
        $user = ORM::factory('user');
        $validator = $user->validator_register($this->request->post());
        if ($validator->check()) {
        	$values = $validator->as_array();
        	$values['password'] =  Auth::instance()->hash($values['password']);
            $user->values($values);
            $user->save();
            Auth::instance()->login($validator['email'], $validator['password']);
            Request::current()->redirect('home');
            exit;
        } else {
            $this->_errors = $validator->errors('register');
        }
    }

    private function form_register($submitted = false) {    	
        $action = 'auth/index';
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $fields = array('email', 'email_parent', 'firstname', 'lastname', 'password', 'batch_id', 'course_id', 'agree');
        $form->default_data = array_fill_keys($fields, '');
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Your Email', 'email', 'text')
            ->append('Parent\'s Email', 'email_parent', 'text')
            ->append('First Name', 'firstname', 'text')
            ->append('Last Name', 'lastname', 'text')
            ->append('Password', 'password', 'password')
            ->append('Confirm Password', 'confirm_password', 'password')
            ->append(
                'I have read and agree the privacy policy',
                'agree', 
                'checkbox', 
                array('attributes' => array('value' => 1))
            )->append('Signup Now', 'register', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        return $form;
    }

    /*public function action_logout() {
         Auth::instance()->logout();
         Request::current()->redirect('welcome');
        
    }*/

    public function action_forgot_password() {
        echo 'to be implemented'; exit;
    }
}