<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Lecture extends Feed {
    
    public function render(){
    	
        $view = View::factory('feed/'.$this->type . '_' . $this->action)
               ->bind('lecture', $lecture)
               ->bind('user', $user)
               ->bind('span', $span)
               ->bind('feed_id', $feed_id)
               ->bind('comments', $comments);
               
    	if($this->action == 'add'){
	        $lecture = ORM::factory('lecture', $this->respective_id);
	        if($this->check_deleted($lecture)) return View::factory('feed/unavaliable')->render();
    	} else if($this->action == 'canceled'){
    		$lecture = Model_Lecture::get_lecture_from_event($this->respective_id);
    		$event = ORM::factory('event', $this->respective_id);
    		if($this->check_deleted($lecture)) return View::factory('feed/unavaliable')->render();
    		$view->bind('event', $event);
    	}
        $user = ORM::factory('user', $this->actor_id);
        $span = Date::fuzzy_span($this->time);
        
        $feed_id = $this->id;
        
        $comment = ORM::factory('feedcomment');
        $comment->where('feed_id', '=', $feed_id)
                ->order_by('date', 'DESC');
        $comments = $comment->find_all();
        
        return $view->render();
    }
    
    public function save(){
    	$this->type = 'lecture';
        parent::save();
    }
}