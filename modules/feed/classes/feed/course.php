<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Course extends Feed {
    
    public function __construct($id = NULL){
        if($id){
            $this->load($id);
        }
    }
    
    public function render(){
        $user = ORM::factory('user', $this->actor_id);
        
        $course = ORM::factory('course',$this->respective_id);
        if($this->check_deleted($course)) return View::factory('feed/unavaliable')->render();
        $count_user = DB::select('*')
                    ->from('courses_users')
                    ->where('course_id', '=', $this->respective_id)
                    ->execute()->count();
        $span = Date::fuzzy_span($this->time);
                    
        $view = View::factory('feed/'.$this->type . '_' . $this->action)
               ->bind('user', $user)
               ->bind('count_user', $count_user)
               ->bind('course', $course)
               ->bind('span', $span);
               
        return $view->render();
    }
    
    public function save(){
        $this->type = 'course';
        parent::save();
    }
    
}