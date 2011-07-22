<?php defined('SYSPATH') or die('No direct script access.');

class Model_Course extends ORM {
	
    protected $_has_many = array(
        'users' => array(
            'model'   => 'user',
            'through' => 'courses_users',
        ),
    );    
	
    public function validator($data) {
        return Validation::factory($data)
            ->rule('name', 'not_empty')
            ->rule('start_date', 'not_empty')
            ->rule('start_date', 'date')
            ->rule('end_date', 'not_empty')
            ->rule('access_code', 'Model_Course::code_unique', array(':value',':course'))
            ->rule('name', 'min_length', array(':value', 3))
            ->rule('description', 'min_length', array(':value', 10))
            ->rule('description', 'not_empty');
    }

    public static function code_unique($code, $course_object = NULL) {
        $course = ORM::factory('course');
        $course->where('access_code', ' = ', $code);
        if($course_object !== NULL)
            $course->where('id', '!=', $course_object->id);    
        $course->find();
        return ($course->id === null);
    }
}