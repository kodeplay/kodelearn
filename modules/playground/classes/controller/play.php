<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Play extends Controller {
	
	public function action_index(){
		
		$this->response->body(View::factory('play/signupLogin'));
	}
}