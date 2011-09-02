<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Feed extends Controller_Base {
    
    public function action_index(){
    	
    	$result = Model_Feed::get_feeds();
    	
    	$feeds = array();
    	
    	foreach($result as $feed){
    		$feeds[$feed->id] = Feed::factory($feed->type, $feed->id)->render();
    	}
    	
    	$view = View::factory('feed/index')
    	               ->bind('feeds', $feeds);

    	Breadcrumbs::add(array(
            'Feeds', Url::site('feed')
        ));
                       
    	$this->content = $view;
    }
}