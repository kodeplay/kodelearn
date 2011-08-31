<?php defined('SYSPATH') or die('No direct script access.');

class Model_Feed extends ORM {

    protected $_has_many = array(
        'users' => array(
            'model'   => 'user',
            'through' => 'feeds_users',
        ),
    );      
	/*
	 * This will see for the role of the user and depending on that all the feeds of the user will be loaded
	 * 
	 * @return array of feed object
	 */
	public static function get_feeds(){
		
		$user = Acl::instance()->relevant_user();
		
		if(!$user)
		  return array();
		  
		$feeds = ORM::factory('feed')
		               ->join('feeds_users')
		               ->on('feeds.id', '=', 'feeds_users.feed_id')
		               ->where('feeds_users.user_id', '=', $user->id)
		               ->order_by('time', 'DESC')->find_all();
		               
	   return $feeds;
		
	}
}