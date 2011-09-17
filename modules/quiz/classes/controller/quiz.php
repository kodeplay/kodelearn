<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Quiz extends Controller_Base {
	
    public function action_index() {
    	$view = View::factory('quiz/index');
        
        $this->content = $view;
    }
}