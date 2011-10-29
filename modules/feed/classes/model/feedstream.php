<?php defined('SYSPATH') or die('No direct script access.');

class Model_Feedstream extends ORM {

    protected $_has_many = array(
        'feeds' => array(
            'model' => 'feed',
            'through' => 'feeds_feedstreams'
        )
    );

    public static function create_if_not_exists($data) {
        if (!$data) {
            throw new Exception('no feed stream criteria provided');
        }
        if ($stream = self::already_exists($data)) {
            return $stream;
        }
        $stream = ORM::factory('feedstream');
        $stream->user_id = Arr::get($data, 'user_id', 0);
        $stream->role_id = Arr::get($data, 'role_id', 0);
        $stream->course_id = Arr::get($data, 'course_id', 0);
        $stream->batch_id = Arr::get($data, 'batch_id', 0);
        $stream->save();
        return $stream;
    }

    protected static function already_exists($data) {
        $user_id = (int) Arr::get($data, 'user_id', 0);
        $role_id = (int) Arr::get($data, 'role_id', 0);
        $course_id = (int) Arr::get($data, 'course_id', 0);
        $batch_id = (int) Arr::get($data, 'batch_id', 0);
        $stream = ORM::factory('feedstream');            
        if ($user_id) {
            $stream->where('user_id', ' = ', $user_id);
        }    
        elseif ($course_id) {
            $stream->or_where_open()
                ->where('course_id', ' = ', $course_id)
                ->and_where('role_id', ' = ', $role_id)
                ->or_where_close();
        }
        elseif ($batch_id) {
            $stream->or_where_open()
                ->where('batch_id', ' = ', $batch_id)
                ->and_where('role_id', ' = ', $role_id)
                ->or_where_close();
        } else {
            $stream->or_where_open()
                ->where('role_id', ' = ', $role_id)
                ->and_where('user_id', ' = ', 0)
                ->and_where('course_id', ' = ', 0)
                ->and_where('batch_id', ' = ', 0)
                ->or_where_close();
        }
        $stream->find();
        // print_r($stream->_db->last_query); exit;
        /* var_dump($stream->as_array()); */
        if ($stream->id !== null) {
            return $stream;            
        } else {
            return false;
        }
    }

    public static function user_streams($user=null, $course_id=null, $batch_id=null) {
        // first get the relevant user, if not the current user
        if ($user === null) {
            $user = Acl::instance()->relevant_user();        
            if (!$user) {
                $user = Auth::instance()->get_user();
            }
        }
        $role = $user->role();
        if ($course_id === null) {
            $courses = $user->courses->find_all()->as_array(null, 'id');            
        } else {
            $courses = array($course_id);
        }
        $batches = $user->batches->find_all()->as_array(null, 'id');
        $streams = ORM::factory('feedstream')
            ->where('user_id', ' IN', array($user->id, 0))
            ->and_where('role_id', ' IN ', array($role->id, 0))
            ->and_where('course_id', ' IN ', array_merge($courses, array(0)))
            ->and_where('batch_id', ' IN ', array_merge($batches, array(0)))
            ->find_all();
        return $streams;
    }
}
