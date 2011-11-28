<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'exam' => array(
        'create' => array(
            'help_text' => 'When a new exam is created for a course.'
        ),
        'reschedule' => array(
            'help_text' => 'When a exam is rescheduled.'
        ),
        'relocate' => array(
            'help_text' => 'When a venue for an exam changes.'
        ),
        'reminder' => array(
            'help_text' => 'Reminding the user about the exam 1 day ago.'
        ),
    ),
    'examresult' => array(
        'declare' => array(
            'help_text' => 'When results for an exam are declared.'
        ),
    ),
);
