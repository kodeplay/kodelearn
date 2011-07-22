<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller_Base {

    protected $_errors = array();

    public function action_index() {
        $posted_login = array();
        $posted_register = array();
        $posted_forgot_password = array();
        $submitted_form = '';
        $display = "none";
        
        if ($this->request->method() === 'POST' && $this->request->post()) {
            
            if (Arr::get($this->request->post(), 'login') !== null) {
                $submitted_form = 'login';
                $this->login();
            } elseif (Arr::get($this->request->post(), 'register') !== null) {
                $submitted_form = 'register';
                $this->register();
            } elseif (Arr::get($this->request->post(), 'forgot_password') !== null) {
                
                $display = "block";
                $submitted_form = 'forgot_password';
                $display_success = $this->forgot_password();
            }
        }
        $view = View::factory('auth/signupLogin')
            ->bind('form_login', $form_login)
            ->bind('form_register', $form_register)
            ->bind('form_forgot_password', $form_forgot_password)
            ->bind('links', $links)
            ->bind('display', $display)
            ->bind('display_success', $display_success);          
        $form_login = $this->form_login(($submitted_form === 'login'));
        $form_register = $this->form_register(($submitted_form === 'register'));
        $form_forgot_password = $this->form_forgot_password(($submitted_form === 'forgot_password'));
        $links = array(
            'forgot_password_link' => Html::anchor('#', 'Forgot Password', array('class' => 'tdblue bold', 'onclick' => 'forgotPassword();'))
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

   /* public function action_forgot_password() {
       
    }
    */
    
    private function form_forgot_password($submitted = false) {
        $action = 'auth/index';
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'email' => '',
            
        );
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Email', 'email', 'text');
        $form->append('Submit', 'forgot_password', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        return $form;
    }
    
    private function forgot_password() {
        
        $user = ORM::factory('user');
        $validator = $user->validator_forgot_password($this->request->post());
         
        if ($validator->check()) {
            
            $user->where('email', ' = ', $this->request->post('email'));
        
            $user->find();
            $forgot_password_string = md5($user->email.time());
            $user->forgot_password_string = $forgot_password_string;
            $user->save();
            //$user->email;
            
            Email::connect($config = NULL);
            $to = $user->email;
            $from = 'eric@kodelearn.com';
            $subject = 'Change password';
            $message = 'Link to change your password: http://kodelearn.kp/index.php/auth/changepassword/u/'.$forgot_password_string;
            $html = false;

            Email::send($to, $from, $subject, $message, $html = false);
            
            return '<div class="formMessages" style="width:300px; height:50px"><span class="fmIcon good"></span> <span class="fmText">A link to reset your password has been sent at '. $user->email.'</span><span class="clear">&nbsp;</span></div>';
            
        } else {
           
            $this->_errors = $validator->errors('register');
            
            
        }
    }
    
    public function action_changepassword(){
        $u = $this->request->param('u');
        if(!$u){
            echo "Not a valid link. Clik here to go <a href='http://kodelearn.kp/index.php/auth/index'>home</a>";
            exit;
        }
        $user = ORM::factory('user');
        $user->where('forgot_password_string', ' = ', $u);
        $user->find();
        if($user->id){
            $submitted_form = '';
            $display_msg = '';
            if ($this->request->method() === 'POST' && $this->request->post()) {
                $submitted_form = 'changepassword';
                $validator = $user->validator_changepassword($this->request->post());
                
                if ($validator->check()) {
                    //echo "password will be changes";
                    $values = $validator->as_array();
                    $values['password'] =  Auth::instance()->hash($values['password']);
                    $user->password = $values['password'];
                    $user->forgot_password_string = "";
                    $user->save();
                    $display_msg = '<div class="formMessages" style="width:380px; height:30px"><span class="fmIcon good"></span> <span class="fmText">Your password has been changed successfully. Please click here to <a href="http://kodelearn.kp/index.php/auth/index">login</a></span><span class="clear">&nbsp;</span></div>';
                    
                } else {
                    
                    $this->_errors = $validator->errors('register');
                }    
            }
            
            $name = $user->firstname.' '.$user->lastname;
            $view = View::factory('auth/changepassword')
                ->bind('form_changepassword', $form_changepassword)
                ->bind('display_msg', $display_msg)
                ->bind('name', $name);
                 
            $form_changepassword = $this->form_changepassword($submitted_form === 'changepassword',$u);
            
            $this->content = $view;
            
        } else {
            echo "Not a valid link. Clik here to go <a href='http://kodelearn.kp/index.php/auth/index'>home</a>";
            exit;     
        }
       
        
    }
    
    private function form_changepassword($submitted = false, $u) {
        
        $action = 'auth/changepassword/u/'.$u;
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'password' => '',
            'confirm_password' => '',
            
        );
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Password', 'password', 'password');
        $form->append('Confirm Password', 'confirm_password', 'password');
        $form->append('Submit', 'change_password', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        
        return $form;
    }
    
}