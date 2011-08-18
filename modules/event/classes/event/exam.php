<?php defined('SYSPATH') or die('No direct access allowed.');

class Event_Exam extends Event_Abstract {

    public function __construct(){
        $this->_type = 'exam';
    }

    public function add(){
        $event_id = parent::add();

        $this->set_value('event_id', $event_id);

        $exam = ORM::factory('exam');

        $exam->values($this->_values);

        $exam->save();

    }

    public function update($id){

        $exam = ORM::factory('exam', $id);

        parent::update($exam->event_id);

        $exam->values($this->_values);

        $exam->save();
    }
}
