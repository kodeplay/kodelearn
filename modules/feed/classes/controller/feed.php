<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Feed extends Controller_Base {
    
    public function action_index(){    	
    	$feeds = Request::factory('feed/feeds')
            ->method(Request::GET)
            ->execute()
            ->body();
        $total_feeds = Model_Feed::get_total_feeds();
        $view = View::factory('feed/index')
            ->bind('feeds', $feeds)
            ->bind('total_feeds', $total_feeds);
    	Breadcrumbs::add(array(
            'Feeds', Url::site('feed')
        ));
                       
    	$this->content = $view;
    }
    
    public function action_feeds(){
        
    	$data = array();
    	
        if($this->request->param('start')){
            $data['offset'] = $this->request->param('start');
        } 
        
    	$result = Model_Feed::get_feeds($data);
        
        $feeds = array();
        
        foreach($result as $feed){
            $feeds[$feed->id] = Feed::factory($feed->type, $feed->id)->render();
        }
        
        $view = View::factory('feed/feeds')
            ->bind('feeds', $feeds);

        Breadcrumbs::add(array(
            'Feeds', Url::site('feed')
        ));
                       
        $this->content = $view;
    	
    }
    
}