<?php defined('SYSPATH') or die('No direct access allowed.');

class Event_Lecture extends Event_Abstract {
    
    public function add(){

        $lecture = ORM::factory('lecture');
        
        $lecture->values($this->_values);
        
        $lecture->save();
       
        $this->create_events($lecture);
    }
    
    private function remove_events($lecture){
    	
    	$events = $lecture->events->find_all()->as_array(NULL, 'id');
    	
    	foreach($events as $event_id){
    		$event = ORM::factory('event', $event_id);
    		$event->delete();
    	}
    	
    	$lecture->remove('events');
    }
    
    private function create_events($lecture){
    	
        if($this->_values['type'] == 'once'){
            $event = new Event_Abstract();
            
            $event->set_eventtype('lecture');
            $event->set_eventstart($this->_values['start_date']);
            $event->set_eventend($this->_values['end_date']);
            $event->set_room_id($this->_values['room_id']);
            $event_id = $event->add();
            
            $lecture->add('events', ORM::factory('event', $event_id));
            
        } else {
            foreach($this->_values['days'] as $day => $value){
                
                $iterator = $this->_values['start_date'];
                $i = 1;
                $endtime = $this->_values['end_date'] + 86399; // This will add the seconds of the day till 23:59:59
                while(($iterator = (strtotime('+'.$i.' ' . $day, $this->_values['start_date']) + ($this->_values[strtolower($day)]['from'] * 60))) < ($endtime)){
                    $eventstart = $iterator ;
                    $eventend =  ($iterator + (60 * ($this->_values[strtolower($day)]['to'] - $this->_values[strtolower($day)]['from'])));
                    $event = new Event_Abstract();
                    
                    $event->set_eventtype('lecture');
                    $event->set_eventstart($eventstart);
                    $event->set_eventend($eventend);
                    $event->set_room_id($this->_values['room_id']);
                    $event_id = $event->add();
                    
                    $lecture->add('events', ORM::factory('event', $event_id));

                    $i++;
                }
                
            }
        }
    }
    
    public function update($id){
        $lecture = ORM::factory('lecture', $id);
        
        $lecture->values($this->_values);

        $lecture->save();        
        
        $this->remove_events($lecture);
        $this->create_events($lecture);
    }
}
