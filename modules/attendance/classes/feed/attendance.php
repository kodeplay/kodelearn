<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Attendance extends Feed {
    
    public function __construct($id = NULL){
        if($id){
            $this->load($id);
        }
    }
    
    public function render(){
               
        $user = ORM::factory('user', $this->actor_id);
        
        $event = ORM::factory('event',$this->respective_id);
        $attendance = $event->get_Attendance();   
        $class = 'Event_'.$event->eventtype;
        $dynamic_object = new $class($this->respective_id);
        $event_details = $dynamic_object->get_event_details();
        
        $view = View::factory('feed/'.$this->type . '_' . $this->action)
               ->bind('user', $user)
               ->bind('event', $event)
               ->bind('event_details', $event_details)
               ->bind('attendance', $attendance);
               
        return $view->render();
    }
    
    public function save(){
        $this->type = 'attendance';
        parent::save();
    }
    
}