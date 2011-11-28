<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Flashcard extends Feed {
   
    public function render(){
        $span = Date::fuzzy_span($this->time);
       
        $flashcard = ORM::factory('flashcard', $this->respective_id);
        if($this->check_deleted($flashcard)) return View::factory('feed/unavaliable')->render();
        $user = ORM::factory('user', $this->actor_id);
        
        $view = View::factory('feed/'.$this->type.'_'.$this->action)
               ->bind('flashcard', $flashcard)
               ->bind('user', $user)
               ->bind('span', $span);
        
        return $view->render();
    }
    
    public function save(){
        $this->type = 'flashcard';
        parent::save();
    }    
}