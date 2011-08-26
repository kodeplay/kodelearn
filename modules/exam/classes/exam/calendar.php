<?php defined('SYSPATH') or die('No direct script access.');

class Exam_Calendar extends Event_Calendar {
    
    /**
     * Method to get the day_event partial html of the exam type
     * @param int $event_id
     * @return String html
     */
    public function day_event($event) {
        $data = $this->event_data($event);
        $view = View::factory('calendar/partial_exam')
            ->bind('event', $data)
            ->set('exam', $data['exam'])
            ->set('examgroup', $data['examgroup'])
            ->set('course', $data['course'])
            ->set('room', $data['room']);        
        unset($data['exam']);
        unset($data['examgroup']);
        unset($data['course']);
        unset($data['room']);
        return $view->render();
    }

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