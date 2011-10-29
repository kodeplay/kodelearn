<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Document extends Feed {
    
    public function render(){
    	
        $span = Date::fuzzy_span($this->time);
        $document = ORM::factory('document', $this->respective_id);
        if($this->check_deleted($document)) return View::factory('feed/unavaliable')->render();
        $user = ORM::factory('user', $this->actor_id);
            
        $view = View::factory('feed/'.$this->type.'_'.$this->action)
               ->bind('document', $document)
               ->bind('user', $user)
               ->bind('span', $span);
        
        return $view->render();
    }
    
    public function save(){
    	$this->type = 'document';
    	parent::save();
    }
    
}