<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Attendance extends Feed {
    
    public function render(){
               
        $user = ORM::factory('user', $this->actor_id);
        
        $event = ORM::factory('event',$this->respective_id);
        if($this->check_deleted($event)) return View::factory('feed/unavaliable')->render();
        $attendance = $event->get_Attendance();   
        $class = 'Event_'.$event->eventtype;
        $dynamic_object = new $class($this->respective_id);
        $event_details = $dynamic_object->get_event_details();
        
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
               ->bind('event', $event)
               ->bind('event_details', $event_details)
               ->bind('attendance', $attendance)
               ->bind('span', $span)
               ->bind('role', $role)
               ->bind('feed_id', $feed_id)
               ->bind('comments', $comments)
               ->bind('url', $url);
               
        return $view->render();
    }
    
    public function save(){
        $this->type = 'attendance';
        parent::save();
    }
    
}