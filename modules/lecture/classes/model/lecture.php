<?php defined('SYSPATH') or die('No direct script access.');

class Model_Lecture extends ORM {

    protected $_belongs_to = array('course' => array());
	
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
    
    public function __toString(){
    	return ucfirst($this->name);
    }
    
    public static function get_lecture_from_event($event_id){
    	$lecture = ORM::factory('lecture')->join('lectures_events')->on('lecture_id', '=', 'id')->where('event_id', '=', $event_id)->find();
    	
    	return $lecture;
    }
    
    public static function lectures_total($filters=array()) {
       
        $lecture = ORM::factory('lecture');
        $lecture->select(array('courses.name','course_name'), 'firstname', 'lastname')->join('courses')
            ->on('courses.id', '=', 'lectures.course_id')
            ->join('users')
            ->on('users.id', '=', 'lectures.user_id');
        if (isset($filters['filter_name'])) {
            $lecture->where('lectures.name', 'LIKE', '%' . $filters['filter_name'] . '%');
        }
        if (isset($filters['filter_course'])) {
            $lecture->where('courses.name', 'LIKE', '%' . $filters['filter_course'] . '%');
        } 
        if (isset($filters['filter_lecturer'])) {
            $lecture->and_where_open()
                ->where('users.firstname', 'LIKE', '%' . $filters['filter_lecturer'] . '%')
                ->or_where('users.lastname', 'LIKE', '%' . $filters['filter_lecturer'] . '%')
                ->and_where_close();
        }         
        
        return $lecture->count_all();
        
    }
    
    public static function lectures($filters=array()) {
       
        $lecture = ORM::factory('lecture');
        $lecture->select(array('courses.name','course_name'), 'firstname', 'lastname')->join('courses')
            ->on('courses.id', '=', 'lectures.course_id')
            ->join('users')
            ->on('users.id', '=', 'lectures.user_id');
        if (isset($filters['filter_name'])) {
            $lecture->where('lectures.name', 'LIKE', '%' . $filters['filter_name'] . '%');
        }
        if (isset($filters['filter_course'])) {
            $lecture->where('courses.name', 'LIKE', '%' . $filters['filter_course'] . '%');
        } 
        if (isset($filters['filter_lecturer'])) {
            $lecture->and_where_open()
                ->where('users.firstname', 'LIKE', '%' . $filters['filter_lecturer'] . '%')
                ->or_where('users.lastname', 'LIKE', '%' . $filters['filter_lecturer'] . '%')
                ->and_where_close();
        } 
        
        $lecture->group_by('id'); 
              
        if (isset($filters['sort'])) {
            $lecture->order_by($filters['sort'], Arr::get($filters, 'order', 'ASC'));
        }
        if (isset($filters['limit'])) {
            $lecture->limit($filters['limit'])
                ->offset(Arr::get($filters, 'offset', 0));            
        }
        return $lecture->find_all();
    }
    
    public static function lectures_total_when($filters=array()) {
       
        $lecture = ORM::factory('lecture');
        $lecture->select(array('courses.name','course_name'), 'firstname', 'lastname')->join('courses')
            ->on('courses.id', '=', 'lectures.course_id')
            ->join('users')
            ->on('users.id', '=', 'lectures.user_id')
            ->join('lectures_events')
            ->on('lectures_events.lecture_id', '=', 'lectures.id')
            ->join('events')
            ->on('lectures_events.event_id', '=', 'events.id');        
        $lecture->where('events.eventstart', 'between', array($filters['sdate'], $filters['edate']));
        $lecture->group_by('lectures.id'); 
        $lectures = $lecture->find_all()->as_array(Null,'id');
        
        return count($lectures);
        
    }
    
    public static function lectures_when($filters=array()) {
       
        $lecture = ORM::factory('lecture');
        $lecture->select(array('courses.name','course_name'), 'firstname', 'lastname')->join('courses')
            ->on('courses.id', '=', 'lectures.course_id')
            ->join('users')
            ->on('users.id', '=', 'lectures.user_id')
            ->join('lectures_events')
            ->on('lectures_events.lecture_id', '=', 'lectures.id')
            ->join('events')
            ->on('lectures_events.event_id', '=', 'events.id');        
        $lecture->where('events.eventstart', 'between', array($filters['sdate'], $filters['edate']));
        $lecture->group_by('lectures.id');
              
        if (isset($filters['sort'])) {
            $lecture->order_by($filters['sort'], Arr::get($filters, 'order', 'ASC'));
        }
        if (isset($filters['limit'])) {
            $lecture->limit($filters['limit'])
                ->offset(Arr::get($filters, 'offset', 0));            
        }
        return $lecture->find_all();
    }

    public function get_students($lecture_id) {
        $lecture = ORM::factory('lecture', $lecture_id);
        $users = $lecture->course->users->find_all();
        return $users;
    }
    
    public static function send_lecture_reminder() {
        $start_date = strtotime(date('d-m-Y'));
        $start_date = $start_date + 86400;
        $end_date = $start_date + 86400;
        $lecture = ORM::factory('lecture')
                ->select('events.eventtype','events.eventstart')
                ->join('lectures_events', 'left')
                ->on('lectures_events.lecture_id', '=', 'lectures.id' )
                ->join('events', 'left')
                ->on('events.id','=','lectures_events.event_id');
        $lecture->where('events.eventstart', 'between', array($start_date, $end_date));
        $lectures = $lecture->find_all();
        foreach($lectures as $lecture_result) {
            $students = $lecture->get_students($lecture_result->id);
            $lecture->send_lecture_reminder_email($students,$lecture_result);       
            
        }
        
    }
    
    public function send_lecture_reminder_email($students,$lecture_result) {
        foreach($students as $student) {
            $file = "lecture_reminder_email";
            $data =array(
                '{user_name}'   => $student->firstname ." ". $student->lastname,
                '{lecture_name}'=> $lecture_result->name,
                '{time}'        => date('g:i:s a', $lecture_result->eventstart),
            ); 
            Email::send_mail($student->email, $file, $data);
             
        }
    }
    
    public static function get_course_lectures_count($course) {
        $count_lecture = ORM::factory('lecture');
        $count_lecture = $count_lecture->where('course_id', '=', $course->id)->count_all();
        return "<a href='".Url::site('lecture')."/index/filter_course/".$course->name."' target='_blank'>".$count_lecture." lectures</a>";       
    }
    
}
