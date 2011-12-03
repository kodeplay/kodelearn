<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Batch extends Feed {
    
    public function render() {
        $user = ORM::factory('user', $this->actor_id);        
        $batch = ORM::factory('batch',$this->respective_id);
        if($this->check_deleted($batch)) return View::factory('feed/unavaliable')->render();
        $count_user = Model_Batch::get_users_count($this->respective_id,'student');        
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
               ->bind('batch', $batch)
               ->bind('span', $span)
               ->bind('role', $role)
               ->bind('feed_id', $feed_id)
               ->bind('comments', $comments)
               ->bind('url', $url); 
                             
        return $view->render();
    }
    
    public function save(){
        $this->type = 'batch';
        parent::save();
    }
    
}