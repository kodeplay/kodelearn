<?php defined('SYSPATH') or die('No direct script access.');

class Model_User_Role extends ORM {

    protected $_belongs_to = array(
        'lectures' => array(),
        'events' => array(),
    );    
}
