<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Document extends Feed {
    
    public function render(){
    	
        $span = Date::fuzzy_span($this->time);
        $document = ORM::factory('document', $this->respective_id);
        if($this->check_deleted($document)) return View::factory('feed/unavaliable')->render();
        $user = ORM::factory('user', $this->actor_id);

        $feed_id = $this->id;
        
        $comment = ORM::factory('feedcomment');
        $comment->where('feed_id', '=', $feed_id)
                ->order_by('date', 'DESC');
        $comments = $comment->find_all();
        
        $view = View::factory('feed/'.$this->type.'_'.$this->action)
               ->bind('document', $document)
               ->bind('user', $user)
               ->bind('span', $span)
               ->bind('feed_id', $feed_id)
               ->bind('comments', $comments);
        
        return $view->render();
    }
    
    public function save(){
    	$this->type = 'document';
    	parent::save();
    }
    
}