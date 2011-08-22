<?php defined('SYSPATH') or die('No direct script access.');

class Model_Event extends ORM {

    protected $_has_many = array(
        'lectures' => array(
            'model'   => 'lecture',
            'through' => 'lectures_events',
        ),
    );      
	
}