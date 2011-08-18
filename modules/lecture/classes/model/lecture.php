<?php defined('SYSPATH') or die('No direct script access.');

class Model_Lecture extends ORM {
	
    protected $_has_many = array(
        'events' => array(
            'model'   => 'event',
            'through' => 'lectures_events',
        ),
    );
}
