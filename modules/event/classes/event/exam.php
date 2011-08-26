<?php defined('SYSPATH') or die('No direct access allowed.');

class Event_Exam extends Event_Abstract {
    public function add(){
        
    	$this->set_value('eventtype', 'exam');
       
    	return parent::add();
    	
    }

    public function update($id){

        parent::update($id);

    }
}
