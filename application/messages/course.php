<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'name' => array(
        'not_empty'     => 'Please enter course Name',
        'min_length'    => 'Name must be more than 3 characters',
    ),
    'description' => array(
        'not_empty' => 'Please enter description for course.',
    ),
    'access_code' => array(
        'Model_Course::code_unique' => 'Access code is used in other course'
    ),
    'end_date' => array(
        'Model_Course::validate_end_date' => 'End Date should be greater than Start Date'
    )
);