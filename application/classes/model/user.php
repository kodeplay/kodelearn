<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends ORM {

	protected $_has_many = array(
	    'batches' => array(
	        'model'   => 'batch',
	        'through' => 'batches_users',
	    ),
	);		
	
    public function validator_login($data) {
        return Validation::factory($data)
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('password', 'not_empty');
    }

    public function validator_register($data) {
        return Validation::factory($data)
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('email', 'Model_User::email_unique')
            ->rule('email_parent', 'not_empty')
            ->rule('email_parent', 'email')
            ->rule('firstname', 'not_empty')
            ->rule('lastname', 'not_empty')
            ->rule('password', 'not_empty')
            ->rule('password', 'min_length', array(':value', 8))
            ->rule('confirm_password', 'matches', array(':validation', ':field', 'password'))
            ->rule('agree', 'not_empty');
    }

    public static function email_unique($email) {
        $user = ORM::factory('user');
        $user->where('email', ' = ', $email)
            ->find();
        return ($user->id === null);
    }

}