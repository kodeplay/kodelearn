<?php defined('SYSPATH') or die('No direct script access.');

DynamicMenu::extend(array(
    'sidemenu' => array(
        array('exam', 'Exam', 5, array()),
    ),
));

Route::set('exam', '(<controller>(/<action>(/<params>)))' , array('params' => '.*?'))
	->defaults(array(
		'controller' => 'exam',
		'action'     => 'index',
	));
