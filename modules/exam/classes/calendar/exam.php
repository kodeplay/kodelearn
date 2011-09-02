<?php defined('SYSPATH') or die('No direct script access.');

class Calendar_Exam extends Calendar_Event {
    
    protected function event_data($event) {
        $data = parent::event_data($event);       
        $exam = ORM::factory('exam')
            ->where('event_id', ' = ', (int) $event->id)
            ->find();
        return array_merge($data, array(
            'exam' => $exam,
            'course' => $exam->course,
            'examgroup' => $exam->examgroup,
        ));
    }
}
