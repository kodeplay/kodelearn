<?php defined('SYSPATH') or die('No direct access allowed.');

class Event_Lecture extends Event_Abstract {
    
    public function add(){
        
    	$this->set_value('eventtype', 'lecture');
        return parent::add();
    }
    
    public function get_event_details(){
        $lecture = ORM::factory('lecture');
        $lecture->join('lectures_events','left')
             ->on('lectures_events.lecture_id','=','id');
        $lecture->where('lectures_events.event_id','=',$this->_event_id);
        $lectures = $lecture->find();
        return $lectures;
    }
    
    
}
