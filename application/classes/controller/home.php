<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Controller_Base {

    public function action_index() {
    	$view = View::factory('home/index')
            ->bind('feeds', $feeds);
            
    	$feeds = Request::factory('feed/index')
            ->method(Request::GET)
            ->execute()
            ->body();
        $this->content = $view;
    }

    public function action_logout() {
         Auth::instance()->logout();
         Request::current()->redirect('welcome');
    }
}