<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Course extends Feed {
    
    public function __construct($id){
        if($id){
            $this->load($id);
        }
    }
    
    public function render(){
        $user = ORM::factory('user', $this->actor_id);
        
        $course = ORM::factory('course',$this->respective_id);
        $count_user = DB::select('*')
                    ->from('courses_users')
                    ->where('course_id', '=', $this->respective_id)
                    ->execute()->count();
        
        $view = View::factory('feed/'.$this->type . '_' . $this->action)
               ->bind('user', $user)
               ->bind('count_user', $count_user)
               ->bind('course', $course);
               
        return $view->render();
    }
    
}