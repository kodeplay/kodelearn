<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Flashcard extends Controller_Base {
	
    public function action_index() {
    	
        $view = View::factory('flashcard/index');
        
        $this->content = $view;
    }
}