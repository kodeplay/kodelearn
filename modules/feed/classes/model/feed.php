<?php defined('SYSPATH') or die('No direct script access.');

class Model_Feed extends ORM {

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
		               ->join('feed_users')
		               ->on('feeds.id', '=', 'feed_users.feed_id')
		               ->where('feed_users.user_id', '=', $user->id)->find_all();
		               
	   return $feeds;
		
	}
}