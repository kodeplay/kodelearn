<?php defined('SYSPATH') or die('No direct script access.');

abstract class Feed {

    /**
     * The feed model object
     */
    protected $_feed;
    
    protected $id;
    
    protected $type;
    
    protected $action;
    
    protected $respective_id;
    
    protected $course_id = 0;
    
    protected $actor_id;
    
    protected $time;

    /**
     * Array of Feed stream object
     * Depending upon whether a stream exists, a new streams will be created
     * to which this feed will be associated
     * All users in these streams will then see this feed
     * There can be multiple feed streams associated with a feed
     */
    protected $_streams = array();
    
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

    public static function factory ($type, $id = NULL) {        
        $file = MODPATH . $type . '/classes/feed/' . $type . '.php';        
        $file_feed = MODPATH . 'feed/classes/feed/' . $type . '.php';    
        if(file_exists($file) || file_exists($file_feed)){
            $class = 'Feed_' . $type;
            return new $class($id);
        } else {
            throw new Exception('Class Feed_ ' . $type . ' not found');
        }        
    }

    /**
     * If an id is passed while instantiating this class,
     * load the feed corresponding to this id and populate the variables
     * otherwise just create a new instance of the Feed model and keep
     * it assigned to the $_feed instance variable
     */
    public function __construct($id = null) {
    	if($id !== null){
            $this->_feed = $this->load($id);
    	} else {
            $this->_feed = ORM::factory('feed');        
        }
    }
    
    public function load($id) {
        $feed = ORM::factory('feed', $id);
        $this->_feed = $feed;
        $this->id = $id;
        $this->type = $feed->type;
        $this->action = $feed->action;
        $this->respective_id  = $feed->respective_id;
        $this->actor_id  = $feed->actor_id;
        $this->course_id = $feed->course_id;
        $this->time = $feed->time;
        $this->_streams = $feed->feedstreams->find_all()->as_array();
        return $this->_feed;
    }
    
    public function render(){
        return $this->type . ' ' . $this->action;
    }
    
    public function save() {        
        $this->_feed->type = $this->type;
        $this->_feed->action = $this->action;
        $this->_feed->respective_id = $this->respective_id;
        $this->_feed->actor_id = $this->actor_id;
        $this->_feed->course_id = $this->course_id;
        $this->_feed->time = time();
        $this->_feed->save();
        $this->update_streams();
        $this->load($this->_feed->id);
    }

    /**
     * Method to save the streams to be associated to the feed
     * @param array $data
     */
    public function streams($data) {
        if (!empty($data['user_id']) && is_array($data['user_id'])) { // multiple user ids passed
            $users = $data['user_id'];
            foreach ($users as $user_id) {
                $this->_streams[] = Model_Feedstream::create_if_not_exists(array('user_id' => $user_id));
            }
        }
        elseif (!empty($data['role_id']) && is_array($data['role_id'])) { // if multiple role_ids passed
            $roles = $data['role_id'];
            foreach ($roles as $role_id) {
                $this->_streams[] = Model_Feedstream::create_if_not_exists(array_merge($data, array(
                    'role_id' => $role_id
                )));
            }                
        } else { // create only one stream with whatever data passed including user_id and role_id
            $this->_streams[] = Model_Feedstream::create_if_not_exists($data);            
        }
        return $this;
    }

    /**
     * Update the feed streams-feed association by adding the feedstream objects to feed
     */
    public function update_streams() {
        foreach ($this->_streams as $stream) {
            if ($this->_feed->has('feedstreams', $stream)) {
                continue;
            }
            $this->_feed->add('feedstreams', $stream);
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