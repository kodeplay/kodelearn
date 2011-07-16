<?php defined('SYSPATH') or die('No direct script access.');

class Model_Role extends ORM {
	
    protected $_has_many = array(
        'users' => array(
            'model'   => 'user',
            'through' => 'roles_users',
        ),
    );    
}