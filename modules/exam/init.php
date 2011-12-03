<?php defined('SYSPATH') or die('No direct script access.');

DynamicMenu::extend(array(
    'sidemenu' => array(
        array('exam', 'Exam', 5, array()),
    ),
));

// register handler class for sending exam related notices upon various events
Notice::instance()->register_handler('exam');

Hook::instance()->register("send_reminder",'Model_Exam::send_exam_reminder');

Hook::instance()->register("course_count",'Model_Exam::get_course_exams_count');

Route::set('exam', '(<controller>(/<action>(/<params>)))' , array('params' => '.*?'))
	->defaults(array(
		'controller' => 'exam',
		'action'     => 'index',
	));
	
	
