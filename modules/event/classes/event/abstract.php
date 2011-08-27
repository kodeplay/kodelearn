<?php defined('SYSPATH') or die('No direct access allowed.');

abstract class Event_Abstract {
    
    protected $_values;
    
    protected $_eventtype;
    
    protected $_eventstart;
    
    protected $_eventend;
    
    protected $_room_id;

    protected $_event_id;

    public function __construct($event_id = null) {
        $this->_event_id = $event_id;
    }
    
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
    
    
    public static function factory($type, $event_id = null){
        $file = MODPATH . 'event/classes/event/' . $type . '.php';
        
        if(file_exists($file)){
            $class = 'Event_' . $type;
            return new $class($event_id);
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
        
        $event->values($this->_values);
        
        $event->save();
        
        return $event->id; 
        
    }
    
    public static function get_avaliable_rooms($from, $to, $event_id = FALSE){

    	$sql = 'SELECT `events`.* FROM `events` WHERE ((`events`.`eventstart` BETWEEN :from AND :to OR `events`.`eventend` BETWEEN :from AND :to) OR (:from BETWEEN `events`.`eventstart` AND `events`.`eventend` OR :to BETWEEN `events`.`eventstart` AND `events`.`eventend`)) ';
    	
    	if($event_id){
    		$sql .= ' AND `events`.id != ' . (int) $event_id;
    	}

		$query = DB::query(Database::SELECT, $sql);
		 
		$query->parameters(array(
		    ':from' => $from,
		    ':to' => $to,
		));

		$occupied_room_ids = $query->execute()->as_array(NULL, 'room_id');
    	
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