<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Assignment extends Controller_Base {
	
    public function action_index() {
    	$view = View::factory('assignment/index');
        
        $this->content = $view;
    }
}