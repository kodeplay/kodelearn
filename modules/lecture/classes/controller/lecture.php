<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Lecture extends Controller_Base {
    
    public function action_index(){
    	
    	$view = View::factory('lecture/list');
    	
        Breadcrumbs::add(array(
            'Lectures', Url::site('lecture')
        ));
    	
        $this->content = $view;
    }
}
