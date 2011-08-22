<?php defined('SYSPATH') or die('No direct access allowed.');

class Event_Lecture extends Event_Abstract {
    
    public function add(){
        
/*    	$event = new Event_Abstract();
    	
    	$event->set_eventtype('exam');
    	
        $event->set_eventstart($this->_values['eventstart']);
        $event->set_eventend($this->_values['eventend']);
        $event->set_room_id($this->_values['room_id']);
        $event_id = $event->add();
        $this->set_value('event_id', $event_id);
*/       
        $lecture = ORM::factory('lecture');
        
        $lecture->values($this->_values);
        
        $lecture->save();
        
    }
    
    public function update($id){
        
        $exam = ORM::factory('exam', $id);
        
        parent::update($exam->event_id);
        
        $exam->values($this->_values);
        
        $exam->save();
    }
}
