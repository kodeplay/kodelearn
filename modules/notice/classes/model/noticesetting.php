<?php defined('SYSPATH') or die('No direct script access.');

class Model_Noticesetting extends ORM {

    public static function settings($institution_id = 1) {
        $noticesetting = ORM::factory('noticesetting')
            ->where('institution_id', ' = ', (int)$institution_id)
            ->find();   
        return $noticesetting;
    }
}

