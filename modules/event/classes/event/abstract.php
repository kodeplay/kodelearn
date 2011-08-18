<?php defined('SYSPATH') or die('No direct access allowed.');

abstract class Event_Abstract {
    
    protected $_values;
    
    protected $_type;

    public static function factory($type){
        $file = MODPATH . 'event/classes/event/' . $type . '.php';
        
        if(file_exists($file)){
            $class = 'Event_' . $type;
            return new $class;
        } else {
            throw new Event_Exception('Class Event_ ' . $type . ' not found');
        }
    }
    
    public function set_values(array $values){
        $this->_values = $values;
    }
    
    public function set_value($key, $value){
        $this->_values[$key] = $value; 
    }
    
    public function check_default_values($values){
        return (isset($values['eventstart']) && isset($values['eventend']) && isset($values['room_id']));
    }
    
    public function add(){
        
        $this->set_value('eventtype', $this->_type);
        
        $event = ORM::factory('event');
        
        $event->values($this->_values);
        
        $event->save();
        
        return $event->id; 
        
    }
    
    public static function get_avaliable_rooms($from, $to, $event_id = FALSE){

        $event = ORM::factory('event');
        $event->and_where_open()
            ->where('events.eventstart', 'BETWEEN', array($from, $to))
            ->and_where('events.eventend', 'BETWEEN', array($from, $to))
            ->and_where_close();
        if($event_id){
            $event->and_where('events.id', '!=', $event_id);
        }
        $occupied_room_ids = $event->find_all()->as_array(NULL, 'room_id');
        
        $room = ORM::factory('room');
        if($occupied_room_ids)
            $room->where('id', 'NOT IN', $occupied_room_ids);
        
        $rooms = $room->find_all()->as_array();
        
        return $rooms;
    }
    
    public function update($id){
        
        $event = ORM::factory('event', $id);
        
        $event->values($this->_values);
        
        $event->save();
        
    }
    
}