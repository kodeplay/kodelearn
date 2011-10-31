<?php defined('SYSPATH') or die('No direct script access.');

class Feed_Batch extends Feed {
    
    public function render(){
        $user = ORM::factory('user', $this->actor_id);
        
        $batch = ORM::factory('batch',$this->respective_id);
        if($this->check_deleted($batch)) return View::factory('feed/unavaliable')->render();
        $count_user = Model_Batch::get_users_count($this->respective_id,'student');
        /*$count_user = DB::select('*')
                    ->from('batches_users')
                    ->where('batch_id', '=', $this->respective_id)
                    ->execute()->count();*/
        
        $span = Date::fuzzy_span($this->time);
        
        $view = View::factory('feed/'.$this->type . '_' . $this->action)
               ->bind('user', $user)
               ->bind('count_user', $count_user)
               ->bind('batch', $batch)
               ->bind('span', $span);
               
        return $view->render();
    }
    
    public function save(){
        $this->type = 'batch';
        parent::save();
    }
    
}