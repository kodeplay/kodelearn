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
	public static function get_feeds($data = array()){
		
		$data = array_merge(array(
		 'limit'     => 5,
		 'offset'    => 0
		) , $data);
		
		$user = Acl::instance()->relevant_user();
		
		if(!$user)
		  $user = Auth::instance()->get_user();
		  
		$feed = ORM::factory('feed')
		        ->join('feeds_users')
		        ->on('feeds.id', '=', 'feeds_users.feed_id')
		        ->where('feeds_users.user_id', '=', $user->id);
		if(isset($data['course_id'])){
		    $feed->where('course_id', '=', $data['course_id']);
		}               
		               
		$feed->order_by('time', 'DESC')
		     ->limit($data['limit'])
		     ->offset($data['offset']);

		$feeds = $feed->find_all();
            
	   return $feeds;
		
	}
	
	public static function get_total_feeds($data = array()){
        
		$user = Acl::instance()->relevant_user();
        
        if(!$user)
          $user = Auth::instance()->get_user();
          
        $feed = ORM::factory('feed')
                       ->join('feeds_users')
                       ->on('feeds.id', '=', 'feeds_users.feed_id')
                       ->where('feeds_users.user_id', '=', $user->id);
        if(isset($data['course_id'])){
            $feed->where('course_id', '=', $data['course_id']);
        } 
        $feeds = $feed->count_all();
               
       return $feeds;
		
	} 
}