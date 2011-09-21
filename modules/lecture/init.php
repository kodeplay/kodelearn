<?php defined('SYSPATH') or die('No direct script access.');

DynamicMenu::extend(array(
    'sidemenu' => array(
        array('lecture', 'Lecture', 6, array()),
    ),
));

Hook::instance()->register("course_count",'Model_Lecture::get_course_lectures_count');
Hook::instance()->register("send_reminder",'Model_Lecture::send_lecture_reminder');

