<?php defined('SYSPATH') or die('No direct script access.');

abstract class Feed {
    
    protected $id;
    
    protected $type;
    
    protected $action;
    
    protected $respective_id;
    
    protected $course_id = 0;
    
    protected $actor_id;
    
    protected $time;
    
    public function get_time(){
        return $this->time;
    }
    
    public function set_time($value){
        $this->time = $value;
    }
    
    public function get_actor_id(){
        return $this->actor_id;
    }
    
    public function set_actor_id($value){
        $this->actor_id = $value;
    }
    
    
    public function get_course_id(){
        return $this->course_id;
    }
    
    public function set_course_id($value){
        $this->course_id = $value;
    }
    
    
    public function get_respective_id(){
        return $this->respective_id;
    }
    
    public function set_respective_id($value){
        $this->respective_id = $value;
    }
    
    
    public function get_action(){
        return $this->action;
    }
    
    public function set_action($value){
        $this->action = $value;
    }
    
    
    public function get_type(){
        return $this->type;
    }
    
    public function set_type($value){
        $this->type = $value;
    }
    
    
    public function get_id(){
        return $this->id;
    }
    
    public function set_id($value){
        $this->id = $value;
    }
    
    public function load($id){
        $feed = ORM::factory('feed', $id);
        
        $this->id = $id;
        $this->type = $feed->type;
        $this->action = $feed->action;
        $this->respective_id  = $feed->respective_id;
        $this->actor_id  = $feed->actor_id;
        $this->course_id = $feed->course_id;
        $this->time = $feed->time;
    }
    
    public static function factory($type, $id = NULL){
        
        $file = MODPATH . $type . '/classes/feed/' . $type . '.php';        
        $file_feed = MODPATH . 'feed/classes/feed/' . $type . '.php';    
        if(file_exists($file) || file_exists($file_feed)){
            $class = 'Feed_' . $type;
            return new $class($id);
        } else {
            throw new Exception('Class Feed_ ' . $type . ' not found');
        }
        
    }
    
    public function render(){
        return $this->type . ' ' . $this->action;
    }
    
    public function save(){
        $feed = ORM::factory('feed');
        
        $feed->type = $this->type;
        $feed->action = $this->action;
        $feed->respective_id = $this->respective_id;
        $feed->actor_id = $this->actor_id;
        $feed->course_id = $this->course_id;
        $feed->time = time();
        $feed->save();
        $this->load($feed->id);
    }
    /*
     * Method will subscribe users to get feed.
     * @param array $users array of user object
     * 
     */
    public function subscribe_users($users = array()){
        if(!$users){
            $course = ORM::factory('course', $this->course_id);
            $users = Model_Course::get_students($course);
        }
        $feed = ORM::factory('feed', $this->id);
        foreach($users as $user){
            $feed->add('users', $user);
        }
        
    }
    
    public function check_deleted($object){
        
        if($object->id === NULL){
            $this->delete();
            return true;
        } else {
            return false;
        }
        
    }
    
    public function delete(){
        ORM::factory('feed', $this->id)->delete();
    }
    
}