<?php defined('SYSPATH') or die('No direct script access.');

Route::set('exam', '(<controller>(/<action>(/<params>)))' , array('params' => '.*?'))
	->defaults(array(
		'controller' => 'exam',
		'action'     => 'index',
	));
