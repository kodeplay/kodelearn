<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Flashcard extends Feed {
   
    public function render(){
        $span = Date::fuzzy_span($this->time);
       
        $flashcard = ORM::factory('flashcard', $this->respective_id);
        if($this->check_deleted($flashcard)) return View::factory('feed/unavaliable')->render();
        $user = ORM::factory('user', $this->actor_id);
        
        $feed_id = $this->id;
        $comment = ORM::factory('feedcomment');
        $comment->where('feed_id', '=', $feed_id)
                ->order_by('date', 'DESC');
        $comments = $comment->find_all();
        
        $curr_user = Auth::instance()->get_user();
        $role = $curr_user->role()->name;
        
        $url = Url::site('profile/view/id/');
        
        $view = View::factory('feed/'.$this->type.'_'.$this->action)
               ->bind('flashcard', $flashcard)
               ->bind('user', $user)
               ->bind('span', $span)
               ->bind('role', $role)
               ->bind('feed_id', $feed_id)
               ->bind('comments', $comments)
               ->bind('url', $url);
        
        return $view->render();
    }
    
    public function save(){
        $this->type = 'flashcard';
        parent::save();
    }    
}