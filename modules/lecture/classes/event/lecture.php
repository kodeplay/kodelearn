<?php defined('SYSPATH') or die('No direct access allowed.');

class Event_Lecture extends Event_Abstract {
    
    public function add(){
        
    	$this->set_value('eventtype', 'lecture');
        return parent::add();
    }
    
    
}
