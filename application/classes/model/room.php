<?php defined('SYSPATH') or die('No direct script access.');

class Model_Room extends ORM {


    protected $_has_many = array(
        'events' => array(
            'model' => 'event', 
            'foreign_key' => 'room_id'
        )
    );

    public function validator($data) {
        return Validation::factory($data)
            ->rule('room_name', 'not_empty')
            ->rule('room_name', 'min_length', array(':value', 3))
            ->rule('room_number', 'not_empty')
            ->rule('location_id', 'not_empty');
    }

    public function __toString() {
        return ucfirst($this->room_name);
    }

    /**
     * Method to return an anchor tag with room_name as the text and 
     * link to the room as href
     */
    public function toLink() {
        if (Acl::instance()->is_allowed('exam_edit')) {
            $url = Url::site('room/edit/id/'.$this->id);
	        return Html::anchor($url, (string) $this);
        } else {
        	return Html::anchor('#', (string) $this, array('onclick' => 'javascript:KODELEARN.modules.get("rooms").showMap("'. $this->id .'");return false;'));
        }
    }
    
    public static function rooms_total($filters=array()) {
       
        $room = ORM::factory('room');
        $room->select('locations.name','room_number','room_name')
             ->join('locations','left')
             ->on('locations.id','=','location_id');
        if (isset($filters['filter_room_name'])) {
            $room->where('rooms.room_name', 'LIKE', '%' . $filters['filter_room_name'] . '%');
        } 
        if (isset($filters['filter_number'])) {
            $room->where('rooms.room_number', 'LIKE', '%' . $filters['filter_number'] . '%');
        }  
        if (isset($filters['filter_location'])) {
            $room->where('locations.name', 'LIKE', '%' . $filters['filter_location'] . '%');
        }       
        return $room->count_all();
    }
    
    public static function rooms($filters=array()) {
       
       $room = ORM::factory('room');
       $room->select('locations.name','room_number','room_name')
             ->join('locations','left')
             ->on('locations.id','=','location_id');
             
       if (isset($filters['filter_room_name'])) {
            $room->where('rooms.room_name', 'LIKE', '%' . $filters['filter_room_name'] . '%');
       }        
       if (isset($filters['filter_number'])) {
            $room->where('rooms.room_number', 'LIKE', '%' . $filters['filter_number'] . '%');
       }  
       if (isset($filters['filter_location'])) {
            $room->where('locations.name', 'LIKE', '%' . $filters['filter_location'] . '%');
       } 
        
        $room->group_by('id'); 
              
        if (isset($filters['sort'])) {
            $room->order_by($filters['sort'], Arr::get($filters, 'order', 'ASC'));
        }
        if (isset($filters['limit'])) {
            $room->limit($filters['limit'])
                ->offset(Arr::get($filters, 'offset', 0));            
        }
        return $room->find_all();
    }
}