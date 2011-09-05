<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Post extends Feed {
    
    public function __construct($id = NULL){
    	if($id){
    		$this->load($id);
    	}
    }
    
    public function render(){
    	
    }
    
    public function save(){
    	$this->type = 'post';
    	parent::save();
    }
    
}