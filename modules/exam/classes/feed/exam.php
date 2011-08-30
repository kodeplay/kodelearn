<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Exam extends Feed {
    
    public function __construct($id){
    	$feed = ORM::factory('feed', $id);
    	
    	$this->id = $id;
    	$this->type = $feed->type;
    	$this->action = $feed->action;
    }
    
    public function render(){
        return $this->type . ' ' . $this->action .' '. $this->id;
    }
    
}