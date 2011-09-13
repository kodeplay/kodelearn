<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Feed extends Controller_Base {
    
    public function action_index(){
        
        $feeds = Request::factory('feed/feeds')
            ->method(Request::GET)
            ->execute()
            ->body();

        $post_form = Request::factory('post/form')
            ->execute()
            ->body();
            
        $total_feeds = Model_Feed::get_total_feeds();
        $view = View::factory('feed/index')
                       ->bind('feeds', $feeds)
                       ->bind('post_form', $post_form)
                       ->bind('total_feeds', $total_feeds);

		if($this->request->is_initial()){
		        Breadcrumbs::add(array(
		            'Feeds', Url::site('feed')
		        ));
		}
                       
                       
        $this->content = $view;
    }
    
    /**
     * Method to get multiple feeds
     */
    public function action_feeds(){
        
    	$data = array();
    	
        if($this->request->param('start')){
            $data['offset'] = $this->request->param('start');
        } 
        
        $course_id = $this->request->param('id');
        if($course_id){
            $data['course_id'] = $course_id;
        }
        
    	$result = Model_Feed::get_feeds($data);
        
        $feeds = array();
        
        foreach($result as $feed){
            $feeds[$feed->id] = Feed::factory($feed->type, $feed->id)->render();
        }
        
        $view = View::factory('feed/feeds')
                       ->bind('feeds', $feeds);

        $this->content = $view;        
    }

    /**
     * Action to get only single feed html
     * @param int feed_id
     * will be used in ajax requests to get the recently added field
     */
    public function action_feed() {
        $feed_id = $this->request->param('feed_id');
        $feed = ORM::factory('feed', $feed_id);
        $feeds = array();
        $feeds[$feed->id] = Feed::factory($feed->type, $feed->id)->render();
        $view = View::factory('feed/feeds')
            ->bind('feeds', $feeds);        
        $this->content = $view;        
    }    
}
