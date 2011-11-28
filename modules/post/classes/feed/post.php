<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Post extends Feed {
    
    public function render(){
    	
        $view = View::factory('feed/'.$this->type . '_' . $this->action)
            ->bind('post', $post)
            ->bind('user', $user)
            ->bind('span', $span)
            ->bind('role', $role);        
        $post = ORM::factory('post', $this->respective_id);
        $user = ORM::factory('user', $this->actor_id);
        $curr_user = Auth::instance()->get_user();
        $role = $curr_user->role()->name;
        
        $span = Date::fuzzy_span($this->time);
        return $view->render();        
    }
    
    public function save(){
    	$this->type = 'post';
    	parent::save();
    }    
}