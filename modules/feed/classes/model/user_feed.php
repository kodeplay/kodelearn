<?php defined('SYSPATH') or die('No direct script access.');

class Model_User_Feed extends ORM {

    protected $_belongs_to = array(
        'users' => array(),
        'feeds' => array(),
    );    
}
