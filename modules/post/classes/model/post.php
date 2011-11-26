<?php defined('SYSPATH') or die('No direct script access.');

class Model_Post extends ORM {
    
    public static function delPosts($id) {
               DB::delete('feeds')
                    ->where('type','=', 'post')
                    ->where('respective_id', '=', $id)
                    ->execute();
        
    }
}