<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Notice extends Controller_Base {

    protected $_errors = array();    

    public function action_settings() {
        $view = View::factory('notice/settings')
            ->bind('form', $form)
            ->bind('success', $success);
        $institution = ORM::factory('institution', 1); // harmless hardcoding
        $noticesetting = ORM::factory('noticesetting')
            ->where('institution_id', ' = ', 1)
            ->find();
        $submitted = false;
        if ($this->request->method() === 'POST' && $this->request->post()) {
            if ($this->validate_settings()) {                
                $posted_data = $this->request->post();
                $noticesetting->values(array(
                    'status' => $this->request->post('status'),
                    'sender_email' => $this->request->post('sender_email'),
                ));
                $noticesetting->save();
                Session::instance()->set('success', 'Notice settings modified successfully');
                Request::current()->redirect('notice/settings');
            }
            $submitted = true;
        }
        $form = $this->form($noticesetting->as_array(), $submitted);
        $success = Session::instance()->get_once('success');
        $this->content = $view;
    }

    protected function form($saved_data, $submitted = false) {
        $form = new Stickyform('notice/settings', array(),  $this->_errors);
        $fields = array('status', 'sender_email');        
        $form->default_data = array_fill_keys($fields, '');
        $form->saved_data = $saved_data;
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $form->posted_data = $this->request->post();
        } else {
            $form->posted_data = array();
        }
        $form->append('Send Notices', 'status', 'select', array('options' => array(0 => 'disabled', 1 => 'enabled')));
        $form->append('Email Sender Address', 'sender_email', 'text')
            ->append('Save Changes', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        return $form;
    }

    protected function validate_settings() {
        if (!$this->request->post('status')) {
            return true;
        }
        if (!$this->request->post('sender_email')) {
            $this->_errors['sender_email'] = 'The sender email address cannot be empty';
        }
        return !$this->_errors;
    }

    public function action_preferences() {        
        $view = View::factory('notice/preferences')
            ->bind('notices', $notices)
            ->bind('pref_email', $pref_email)
            ->bind('pref_sms', $pref_sms)
            ->bind('success', $success);
        if ($this->request->method() === 'POST' && $this->request->post()) {
            if ($this->request->post('pref')) {
                $noticesetting = ORM::factory('noticesetting')
                    ->where('institution_id' , ' = ', 1)
                    ->find();
                $noticesetting->preferences = serialize($this->request->post('pref'));
                $noticesetting->save();
                Session::instance()->set('success', 'Notice preferences modified successfully');
                Request::current()->redirect('notice/preferences');
            }
        }
        $notices = Kohana::config('notices')->as_array();
        $pref_email = Notice::instance()->preferences('email');
        $pref_sms = Notice::instance()->preferences('sms');
        $success = Session::instance()->get_once('success');
        $this->content = $view;
    }
}

