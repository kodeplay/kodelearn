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

    /**
     * Method to get the courses as per the passed criteria
     * @param $criteria = array();
     * *keys = 'user', 'filters', 'sort', 'order', 'limit', 'offset'
     * @return Database_MySQL_Result
     */
    public static function courses($criteria=array()) {
        if (isset($criteria['user']) && $criteria['user'] instanceof Model_User) {
            $user = $criteria['user'];
            $course = $user->courses;
        } else {
            $course = ORM::factory('course');
        }        
        $filters = Arr::get($criteria, 'filters', array());
        if (isset($filters['name'])) {
            $course->where('courses.name', 'LIKE', '%' . $filters['name'] . '%');
        }        
        if (isset($filters['access_code'])) {
            $course->where('courses.access_code', 'LIKE', '%' . $filters['access_code'] . '%');
        }        
        if (isset($filters['start_date'])) {
            $course->where('courses.start_date', '=', '' . $filters['start_date'] . '');
        }        
        if (isset($filters['end_date'])) {
            $course->where('courses.end_date', '=', '' . $filters['end_date'] . '');
        }
        if (isset($criteria['sort'])) {
            $course->order_by($criteria['sort'], Arr::get($criteria, 'order', 'ASC'));
        }
        if (isset($criteria['limit'])) {
            $course->limit($criteria['limit'])
                ->offset(Arr::get($criteria, 'offset', 0));            
        }
        return $course->find_all();
    }

    /**
     * Method to get the total courses to generate pagination links
     * @param array $criteria *keys = ('user', 'filters',)
     * @return int $total
     */
    public static function courses_total($criteria=array()) {
        if (isset($criteria['user']) && $criteria['user'] instanceof Model_User) {
            $user = $criteria['user'];
            $course = $user->courses;
        } else {
            $course = ORM::factory('course');
        }        
        $filters = Arr::get($criteria, 'filters', array());
        if (isset($filters['name'])) {
            $course->where('courses.name', 'LIKE', '%' . $filters['name'] . '%');
        }        
        if (isset($filters['access_code'])) {
            $course->where('courses.access_code', 'LIKE', '%' . $filters['access_code'] . '%');
        }        
        if (isset($filters['start_date'])) {
            $course->where('courses.start_date', '=', '' . $filters['start_date'] . '');
        }        
        if (isset($filters['end_date'])) {
            $course->where('courses.end_date', '=', '' . $filters['end_date'] . '');
        }
        return $course->count_all();
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