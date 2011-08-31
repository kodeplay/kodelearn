<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Exam extends Feed {
    
    public function __construct($id){
    	if($id){
    		$this->load($id);
    	}
    }
    
    public function render(){
        if($this->action == "publish_result"){
            $examgroup = ORM::factory('examgroup', $this->respective_id);
            $percent = $examgroup->get_ExamGroupPercent();            
            
            $user = ORM::factory('user', $this->actor_id);
             
            $view = View::factory('feed/'.$this->type.'_'.$this->action)
                   ->bind('user', $user)
                   ->bind('percent', $percent)
                   ->bind('id', $this->respective_id)
                   ;
        } else {
            $exam = ORM::factory('exam', $this->respective_id);
            $user = ORM::factory('user', $this->actor_id);
            $event = ORM::factory('event', $exam->event_id);
            
            $view = View::factory('feed/'.$this->type.'_'.$this->action)
                   ->bind('exam', $exam)
                   ->bind('user', $user)
                   ->bind('event', $event)
                   ;
            
        }
        
        return $view->render();
        //return $this->type . ' ' . $this->action .' '. $this->id;
    }
    
}