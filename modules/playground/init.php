<?php defined('SYSPATH') or die('No direct script access.');

Route::set('playground', 'playground(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'play',
		'action'     => 'index',
	));
