<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'from' => array(
        'Model_Exam::time_check'     => 'from time should not be greater than to time',
        
    ),
    'passing_marks' => array(
        'Model_Exam::marks_check'    => 'Passing marks should not be greater than total marks',
        
    ),
    
    
);