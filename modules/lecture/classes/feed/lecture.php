<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Lecture extends Feed {
    
    public function __construct($id = NULL){
    	if($id){
    		$this->load($id);
    	}
    }
    
    public function render(){
    	
        $view = View::factory('feed/'.$this->type . '_' . $this->action)
               ->bind('lecture', $lecture)
               ->bind('user', $user)
               ->bind('span', $span);
               
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
        return $view->render();
    }
    
    public function save(){
    	$this->type = 'lecture';
        parent::save();
    }
}