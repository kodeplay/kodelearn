<?php defined('SYSPATH') or die('No direct access allowed.');

class Event {
	
	private $_values;

	public static function factory($type){
		$file = MODPATH . 'event\classes\event\\' . $type . '.php';

		if(file_exists($file)){
			$class = 'Event_' . $type;
			return new $class;
		} else {
			throw new Event_Exception('Class Event_ ' . $type . ' not found');
		}
	}
	
	public function set_values(array $values){
		if($this->check_default_values($values)){
			$this->_values = $values;
		} else {
			throw new Event_Exception('The required values for the event is not set.');
		}
	}
	
	public function set_value($key, $value){
		$this->_values[$key] = $value; 
	}
	
	public function check_default_values($values){
		 return (isset($values['eventstart']) && isset($values['eventend']) && isset($values['room_id']));
	}
	
	public static function get_avaliable_rooms($from, $to){

		$room = ORM::factory('room');
		$rooms = $room->join('events', 'LEFT')
		              ->on('rooms.id', '=', 'events.room_id')
		              ->where('events.room_id', 'IS', NULL)
		              ->and_where_open()
		              ->and_where('events.eventstart' , '>', $from)
		              ->or_where('events.eventsstart', '<', $to)
		              ->and_where_close()
		              ->find_all();
		echo $room->last_query(); exit;
		return $rooms;
	}
}