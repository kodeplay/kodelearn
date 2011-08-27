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
            ->rule('from', 'Model_Exam::time_check', array(':value',':to'))
            ->rule('passing_marks', 'Model_Exam::marks_check', array(':value',':total_marks'))
            ->rule('passing_marks', 'digit')
            ->rule('name', 'min_length', array(':value', 3));
    }
    
    public static function time_check($from, $to = NULL) {
        $s_from = strtotime($from);
        
        $s_to = strtotime($to);
        
        if($s_from > $s_to){
            return false;
        } else {
            return true;
        }
    }
    
    public static function marks_check($passing_marks, $total_marks = NULL) {
        
        if($passing_marks > $total_marks){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Method to get the students appearing for an exam
     * @param int $exam_id
     * @return array (values = user_ids of the students)
     */
    public function get_students($exam_id) {
        $exam = ORM::factory('exam', $exam_id);
        $users = $exam->course->users->find_all();
        return $users;
    }

    public function __toString() {
        return ucfirst($this->name);
    }

    /**
     * Method to return an anchor tag with exam name the text and 
     * link to the exam details page
     */
    public function toLink() {
        if (Acl::instance()->is_allowed('exam_edit')) {
            $url = Url::site('exam/edit/id/');
        } else {
            $url = Url::site('exam');
        }
        return Html::anchor($url, (string)$this);
    }
}