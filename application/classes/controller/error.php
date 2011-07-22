<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Error extends Controller_Base {

    public function action_not_found() {
        $view = View::factory('error/error')
            ->set('heading', 'Error 404! Page you requested not found.');
        $this->content = $view;
    }

    public function action_access_denied() {
        $view = View::factory('error/error')
            ->set('heading', 'Access Denied.');
        $this->content = $view;
    }

    public function action_session_timedout() {
        $view = View::factory('error/error')
            ->set('heading', 'Session Timed out. Please click here to login again.');
        $this->content = $view;
    }
}