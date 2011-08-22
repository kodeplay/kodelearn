<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'name' => array(
        'not_empty' => 'Please enter a name',
    ),
    'once_date' => array(
        'not_empty' => 'Please select a date',
        'date'      => 'Date is Invalid',
    ),
    'repeat_from' => array(
        'not_empty' => 'Please select a date',
        'date'      => 'From Date is Invalid',
        'Model_Lecture::date_check' => 'From date should be less than To date'
    ),
    'repeat_to' => array(
        'not_empty' => 'Please select a date',
        'date'      => 'To Date is Invalid',
    )
);