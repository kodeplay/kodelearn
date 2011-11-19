<?php defined('SYSPATH') or die('No direct script access.');

DynamicMenu::extend(array(
    'coursemenu' => array(
        array('quiz', 'Quiz', 5, array()),
        array('exercise', 'Exercise', 4, array()),
    ),
));
