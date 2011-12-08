<?php defined('SYSPATH') or die('No direct script access.');

class Model_Video extends ORM {
    
    public function validator($data) {
        return Validation::factory($data)
            ->rule('title', 'not_empty')
            ->rule('title', 'min_length', array(':value', 3))
            ->rule('description', 'not_empty');
    }
    
    public static function videos($criteria=array()) {
        
        $video = ORM::factory('video');
              
        $filters = Arr::get($criteria, 'filters', array());
        if (isset($filters['title'])) {
           $video->where('videos.title', 'LIKE', '%' . $filters['title'] . '%');
        } 
               
        if (isset($filters['description'])) {
            $video->where('videos.description', 'LIKE', '%' . $filters['description'] . '%');
        }        
        
        $video->where('videos.course_id', '=',  Session::instance()->get('course_id'));
        
        if (isset($criteria['sort'])) {
            $video->order_by("videos.".$criteria['sort'], Arr::get($criteria, 'order', 'ASC'));
        }
        
        if (isset($criteria['limit'])) {
            $video->limit($criteria['limit'])
                      ->offset(Arr::get($criteria, 'offset', 0));            
        }
        
        return $video->find_all();
        
    }
    
    public static function video_total($criteria=array()) {
        
        $video = ORM::factory('video');
                
        $filters = Arr::get($criteria, 'filters', array());
        if (isset($filters['title'])) {
            $video->where('videos.title', 'LIKE', '%' . $filters['title'] . '%');
        }        
        if (isset($filters['description'])) {
            $video->where('videos.description', 'LIKE', '%' . $filters['description'] . '%');
        }        
        $video->where('videos.course_id', '=',  Session::instance()->get('course_id'));
        
        return $video->count_all();
    } 
    
    
}