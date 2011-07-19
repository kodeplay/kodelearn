<?php defined('SYSPATH') or die('No direct script access.');

class Model_User_Role extends ORM {

    protected $_belongs_to = array(
        'users' => array(),
        'roles' => array(),
    );    
}
