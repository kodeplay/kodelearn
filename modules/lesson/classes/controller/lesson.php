<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Lesson extends Controller_Base {
	
    public function action_index() {
    	$view = View::factory('lesson/index');
        
        $this->content = $view;
    }
}