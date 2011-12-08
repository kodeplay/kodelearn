<?php defined('SYSPATH') or die('No direct script access.');

class Model_Link extends ORM {
    
    public function validator($data) {
        return Validation::factory($data)
            ->rule('title', 'not_empty')
            ->rule('title', 'min_length', array(':value', 3))
            ->rule('description', 'not_empty');
    }
    
    public static function links($criteria=array()) {
        
        $link = ORM::factory('link');
              
        $filters = Arr::get($criteria, 'filters', array());
        if (isset($filters['title'])) {
           $link->where('links.title', 'LIKE', '%' . $filters['title'] . '%');
        } 
               
        if (isset($filters['description'])) {
            $link->where('links.description', 'LIKE', '%' . $filters['description'] . '%');
        }        
        
        $link->where('links.course_id', '=',  Session::instance()->get('course_id'));
        
        if (isset($criteria['sort'])) {
            $link->order_by("links.".$criteria['sort'], Arr::get($criteria, 'order', 'ASC'));
        }
        
        if (isset($criteria['limit'])) {
            $link->limit($criteria['limit'])
                      ->offset(Arr::get($criteria, 'offset', 0));            
        }
        
        return $link->find_all();
        
    }
    
    public static function link_total($criteria=array()) {
        
        $link = ORM::factory('link');
                
        $filters = Arr::get($criteria, 'filters', array());
        if (isset($filters['title'])) {
            $link->where('links.title', 'LIKE', '%' . $filters['title'] . '%');
        }        
        if (isset($filters['description'])) {
            $link->where('links.description', 'LIKE', '%' . $filters['description'] . '%');
        }        
        $link->where('links.course_id', '=',  Session::instance()->get('course_id'));
        
        return $link->count_all();
    } 
    
    
}