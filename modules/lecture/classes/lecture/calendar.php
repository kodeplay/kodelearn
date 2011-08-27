<?php defined('SYSPATH') or die('No direct script access.');

class Lecture_Calendar extends Event_Calendar {
    
    protected function event_data($event) {
        $data = parent::event_data($event);       
        $event = $data['event']; // this is a guaranteed object of type Model_Event
        $lecture = $event->lectures->find();
        return array_merge($data, array(
            'lecture' => $lecture,
            'course' => $lecture->course,
        ));
    }
}

