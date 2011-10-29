<?php defined('SYSPATH') or die('No direct script access.');

class Model_Feed extends ORM {

    protected $_has_many = array(
        'users' => array(
            'model'   => 'user',
            'through' => 'feeds_users',
        ),
        'feedstreams' => array(
            'model' => 'feedstream',
            'through' => 'feeds_feedstreams'
        )
    );
    
    /*
     * This will see for the role of the user and depending on that all the feeds of the user will be loaded
     * 
     * @return array of feed object
     */
    public static function get_feeds($data = array()) {        
        $data = array_merge(array(
            'limit'     => 5,
            'offset'    => 0
        ) , $data);
        // TODO the streams for the current user can be cached
        $user_streams = Model_Feedstream::user_streams(null, Arr::get($data, 'course_id'));
        $feed = ORM::factory('feed')
            ->join('feeds_feedstreams')
            ->on('feeds.id' , ' = ' , 'feeds_feedstreams.feed_id')
            ->where('feedstream_id', ' IN ', $user_streams->as_array(null, 'id'))
            ->order_by('time', 'DESC')
            ->limit($data['limit'])
            ->offset($data['offset']);
        $feeds = $feed->find_all();
        // var_dump($feeds->as_array(null, 'id'));        
        return $feeds;        
    }
    
    public static function get_total_feeds($data = array()) {        
        $user = Acl::instance()->relevant_user();        
        if (!$user) {
            $user = Auth::instance()->get_user();
        }        
        // TODO the streams for the current user can be cached
        $user_streams = Model_Feedstream::user_streams(null, Arr::get($data, 'course_id'));
        $feed = ORM::factory('feed')
            ->join('feeds_feedstreams')
            ->on('feeds.id' , ' = ' , 'feeds_feedstreams.feed_id')
            ->where('feedstream_id', ' IN ', $user_streams->as_array(null, 'id'));
        return $feed->count_all();                
    } 
}