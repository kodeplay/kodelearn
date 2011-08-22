<?php defined('SYSPATH') or die('No direct script access.');

class Model_Lecture extends ORM {
	
    protected $_has_many = array(
        'events' => array(
            'model'   => 'event',
            'through' => 'lectures_events',
        ),
    );

    public function validator($data) {
        return Validation::factory($data)
            ->rule('name', 'not_empty')
            ->rule('name', 'min_length', array(':value', 3))
            ->rule('course_id', 'not_empty')
            ->rule('user_id', 'not_empty')
            ->rule('room_id', 'not_empty')
            ;
    }

    public static function date_check($from, $to = NULL) {
        $s_from = strtotime($from);
        
        $s_to = strtotime($to);
        
        if($s_from > $s_to){
            return false;
        } else {
            return true;
        }
    }

}
