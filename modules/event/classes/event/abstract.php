<?php defined('SYSPATH') or die('No direct access allowed.');

class Event_Abstract {
    
    protected $_values;
    
    private $_eventtype;
    
    private $_eventstart;
    
    private $_eventend;
    
    private $_room_id;
    
    public function get_room_id(){
      return $this->_room_id;
    }
    
    public function set_room_id($value){
      $this->_room_id = $value;
    }
       
     
    public function get_eventend(){
      return $this->_eventend;
    }
    
    public function set_eventend($value){
      $this->_eventend = $value;
    }
       
     
    public function get_eventstart(){
      return $this->_eventstart;
    }
    
    public function set_eventstart($value){
      $this->_eventstart = $value;
    }
       
     
    public function get_eventtype(){
      return $this->_eventtype;
    }
    
    public function set_eventtype($value){
      $this->_eventtype = $value;
    }
    
    
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
        
        $event = ORM::factory('event');
        
        $event->eventtype = $this->_eventtype;
        
        $event->eventstart = $this->_eventstart;
        
        $event->eventend = $this->_eventend;
        
        $event->room_id = $this->_room_id;
        
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
        
        $event->eventtype = $this->_eventtype;
        
        $event->eventstart = $this->_eventstart;
        
        $event->eventend = $this->_eventend;
        
        $event->room_id = $this->_room_id;
                
        $event->save();
        
    }
    
}