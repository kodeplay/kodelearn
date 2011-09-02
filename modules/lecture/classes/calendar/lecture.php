<?php defined('SYSPATH') or die('No direct script access.');

class Calendar_Lecture extends Calendar_Event {
    
    protected function event_data($event) {
        $data = parent::event_data($event);       
        $event = $data['event']; // this is a guaranteed object of type Model_Event
        $lecture = $event->lectures->find();
        $teacher = ORM::factory('user', $lecture->user_id);
        return array_merge($data, array(
            'lecture' => $lecture,
            'course' => $lecture->course,
            'teacher' => $teacher,
        ));
    }
}

