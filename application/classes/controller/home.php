<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Base {
    
    public function action_index() {
        $this->content = '';
    }
    
    public function action_logout() {
         Auth::instance()->logout();
         Request::current()->redirect('welcome');
        
    }
}