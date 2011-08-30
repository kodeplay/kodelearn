<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Exam extends Feed {
    
    public function __construct($id){
    	if($id){
    		$this->load($id);
    	}
    }
    
    public function render(){
        $exam = ORM::factory('exam', $this->respective_id);
        $user = ORM::factory('user', $this->actor_id);
        $event = ORM::factory('event', $exam->event_id);
        
        $view = View::factory('feed/'.$this->action)
               ->bind('exam', $exam)
               ->bind('user', $user)
               ->bind('event', $event)
               ;
        return $view->render();
        //return $this->type . ' ' . $this->action .' '. $this->id;
    }
    
}