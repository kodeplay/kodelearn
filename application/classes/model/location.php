<?php defined('SYSPATH') or die('No direct script access.');

class Model_Location extends ORM {

    
    public function validator_location($data) {
        return Validation::factory($data)
            ->rule('name', 'not_empty')
            //->rule('email', 'Model_User::email_unique')
            ->rule('image', 'not_empty');
    }

    public static function email_unique($email) {
        $user = ORM::factory('user');
        $user->where('email', ' = ', $email)
            ->find();
            
        return ($user->id === null);
    }

}