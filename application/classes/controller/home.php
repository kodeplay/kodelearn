<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Base {
    
    public function action_index() {
    	
    	$feeds = Request::factory('feed')
            ->method(Request::GET)
            ->execute()
            ->body();
    	
    	
    	$view = View::factory('home/index')
    	               ->bind('feeds', $feeds);
        $this->content = $view;
    }
    
    public function action_logout() {
         Auth::instance()->logout();
         Request::current()->redirect('welcome');
        
    }
}