<?php defined('SYSPATH') or die('No direct script access.');

class Model_Exam extends ORM {

    protected $_belongs_to = array('course' => array(), 'event' => array(), 'examgroup' => array());

    protected $_has_many = array('examresult' => array('model' => 'examresult'));

    public function validator($data) {
        return Validation::factory($data)
            ->rule('name', 'not_empty')
            ->rule('room_id', 'not_empty')
            ->rule('total_marks', 'not_empty')
            ->rule('total_marks', 'digit')
            ->rule('passing_marks', 'not_empty')
            ->rule('date', 'date')
            ->rule('date', 'not_empty')
            ->rule('from', 'not_empty')
            ->rule('to', 'not_empty')
            ->rule('passing_marks', 'digit')
            ->rule('name', 'min_length', array(':value', 3));
    }
}