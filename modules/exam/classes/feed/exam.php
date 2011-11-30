<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Exam extends Feed {
    
    public function render(){
        $span = Date::fuzzy_span($this->time);
        $feed_id = $this->id;
        
        $comment = ORM::factory('feedcomment');
        $comment->where('feed_id', '=', $feed_id)
                ->order_by('date', 'DESC');
        $comments = $comment->find_all();
        
        if($this->action == "publish_result"){
            $examgroup = ORM::factory('examgroup', $this->respective_id);
            if($this->check_deleted($examgroup)) return View::factory('feed/unavaliable')->render();
            $percent = $examgroup->get_ExamGroupPercent();            
            
            $user = ORM::factory('user', $this->actor_id);
             
            $view = View::factory('feed/'.$this->type.'_'.$this->action)
                   ->bind('user', $user)
                   ->bind('percent', $percent)
                   ->bind('id', $this->respective_id)
                   ->bind('span', $span)
                   ->bind('feed_id', $feed_id)
                   ->bind('comments', $comments);
        } else {
            $exam = ORM::factory('exam', $this->respective_id);
            if($this->check_deleted($exam)) return View::factory('feed/unavaliable')->render();
            $user = ORM::factory('user', $this->actor_id);
            $event = ORM::factory('event', $exam->event_id);
            
            $view = View::factory('feed/'.$this->type.'_'.$this->action)
                   ->bind('exam', $exam)
                   ->bind('user', $user)
                   ->bind('event', $event)
                   ->bind('span', $span)
                   ->bind('feed_id', $feed_id)
                   ->bind('comments', $comments);
            
        }
        
        return $view->render();
    }
    
    public function save(){
    	$this->type = 'exam';
    	parent::save();
    }    
}