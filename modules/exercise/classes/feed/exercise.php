<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Exercise extends Feed {
   
    public function render(){
        $span = Date::fuzzy_span($this->time);
       
        $exercise = ORM::factory('exercise', $this->respective_id);
        if($this->check_deleted($exercise)) return View::factory('feed/unavaliable')->render();
        $user = ORM::factory('user', $this->actor_id);
        
        $view = View::factory('feed/'.$this->type.'_'.$this->action)
               ->bind('exercise', $exercise)
               ->bind('user', $user)
               ->bind('span', $span);
        
        return $view->render();
    }
    
    public function save(){
        $this->type = 'exercise';
        parent::save();
    }    
}