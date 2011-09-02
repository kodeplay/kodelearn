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
            ->rule('end_date', 'date')
            ->rule('end_date', 'not_empty')
            ->rule('end_date',  'Model_Course::validate_end_date', array(':value',':start_date'))
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
    
    public static function validate_end_date($end_date, $start_date){
    	return (strtotime($end_date) > strtotime($start_date) );
    }

    /**
     * Method to save the user to course assignments
     * @param Model_Course $course
     * @param Array $user_ids - Array of user_ids
     * @return null
     */
    public static function assign_users($course, $user_ids) {
       
        $feed_exist = ORM::factory('course');
        $feed_exist->select('courses_users.user_id')
                   ->join('courses_users','right')
                   ->on('course_id','=','id')
                    ->where('course_id','=',$course->id)
                  ;
        $feed_exists = $feed_exist->find_all()->as_array(null,'user_id');
        $new_feed = array_diff($user_ids,$feed_exists);
        
        $feed = new Feed_Course();
        $feed->set_action('student_add');
        $feed->set_course_id('0');
        $feed->set_respective_id($course->id);
        $feed->set_actor_id(Auth::instance()->get_user()->id); 
        $feed->save();
        $feed->subscribe_users($new_feed);
        
        $course->remove('users');
        if($user_ids) {
            
            foreach($user_ids as $user_id){
                $course->add('users', ORM::factory('user', $user_id));
                
            }
        }
    }

    /**
     * Method to get the users assigned to this course
     * if optional role_name is passed, from all users assigned to this course, 
     * get only those that have value of $role_name  their role.
     * @param mixed $course (int/Model_Course)
     * @param String $role_name default = null
     * @param Database_MySQL_Result $users
     */
    public static function get_users($course, $role_name=null) {
        $course = $course instanceof Model_Course ? $course : ORM::factory('course', (int)$course);
        if ($role_name) {
            $role = Model_Role::from_name($role_name);
            $users = $course->users
                ->join('roles_users', 'INNER')
                ->on('users.id', ' = ', 'roles_users.user_id')
                ->where('roles_users.role_id', ' = ', $role->id)            
                ->find_all();
        } else {
            $users = $course->users->find_all();
        }
        return $users;
    }

    /**
     * Method to get the students assigned to this course
     * ie from all users assigned to this course, get only those that have
     * 'student' as their role.
     * @param mixed $course (int/Model_Course)
     * @param Database_MySQL_Result $users
     */
    public static function get_students($course) {
        return self::get_users($course, 'student');
    }

    /**
     * Method to get the teachers assigned to this course
     * ie from all users assigned to this course, get only those that have
     * 'teacher' as their role.
     * @param mixed $course (int/Model_Course)
     * @param Database_MySQL_Result $users
     */
    public static function get_teachers($course) {
        return self::get_users($course, 'teacher');
    }

    public function __toString() {
        return $this->name;
    }

    /**
     * Method to return an anchor tag with room_name as the text and 
     * link to the room as href
     */
    public function toLink() {
        return Html::anchor(Url::site('course/summary/id/'.$this->id), $this->name);
    }
}
