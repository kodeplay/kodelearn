<?php defined('SYSPATH') or die('No direct access allowed.');

class Event_Lecture extends Event_Abstract {
    
    public function add() {
        
    	$this->set_value('eventtype', 'lecture');
        return parent::add();
    }
    
    public function get_event_details() {
        $lecture = ORM::factory('lecture');
        $lecture->join('lectures_events','left')
             ->on('lectures_events.lecture_id','=','id');
        $lecture->where('lectures_events.event_id','=',$this->_event_id);
        return $lecture->find();
    }

    /**
     * Method to get the teacher associated with this lecture
     */
    public function associated_teacher() {
        $lecture = $this->get_event_details();
        $teacher = ORM::factory('user', $lecture->user_id);
        return $teacher;
    }    
}
