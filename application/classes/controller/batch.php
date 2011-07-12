<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Batch extends Controller_Base 
{
	
	public $template = 'template/logged_template';
	
	public function action_index() 
	{
	   $this->content = View::factory('batch/list');	
	}
	
}