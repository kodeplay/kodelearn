<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Course extends Feed {
    
    public function render(){
        $user = ORM::factory('user', $this->actor_id);
        
        $course = ORM::factory('course',$this->respective_id);
        if($this->check_deleted($course)) return View::factory('feed/unavaliable')->render();
        $count_user = Model_Course::get_users_count($this->respective_id,'student');
        $span = Date::fuzzy_span($this->time);

        $feed_id = $this->id;
        
        $comment = ORM::factory('feedcomment');
        $comment->where('feed_id', '=', $feed_id)
                ->order_by('date', 'DESC');
        $comments = $comment->find_all();
        
        $curr_user = Auth::instance()->get_user();
        $role = $curr_user->role()->name;
        
        $url = Url::site('profile/view/id/');
        
        $view = View::factory('feed/'.$this->type . '_' . $this->action)
               ->bind('user', $user)
               ->bind('count_user', $count_user)
               ->bind('course', $course)
               ->bind('span', $span)
               ->bind('role', $role)
               ->bind('feed_id', $feed_id)
               ->bind('comments', $comments)
               ->bind('url', $url);
               
        return $view->render();
    }
    
    public function save(){
        $this->type = 'course';
        parent::save();
    }    
}