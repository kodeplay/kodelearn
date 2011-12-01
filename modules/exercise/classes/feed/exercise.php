<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Exercise extends Feed {
   
    public function render(){
        $span = Date::fuzzy_span($this->time);
       
        $exercise = ORM::factory('exercise', $this->respective_id);
        if($this->check_deleted($exercise)) return View::factory('feed/unavaliable')->render();
        $user = ORM::factory('user', $this->actor_id);
        
        $feed_id = $this->id;
        
        $comment = ORM::factory('feedcomment');
        $comment->where('feed_id', '=', $feed_id)
                ->order_by('date', 'DESC');
        $comments = $comment->find_all();
        
        $curr_user = Auth::instance()->get_user();
        $role = $curr_user->role()->name;
        
        $view = View::factory('feed/'.$this->type.'_'.$this->action)
               ->bind('exercise', $exercise)
               ->bind('user', $user)
               ->bind('span', $span)
               ->bind('role', $role)
               ->bind('feed_id', $feed_id)
               ->bind('comments', $comments);
        
        return $view->render();
    }
    
    public function save(){
        $this->type = 'exercise';
        parent::save();
    }    
}