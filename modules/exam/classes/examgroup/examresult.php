<?php defined('SYSPATH') or die('No direct script access.');

class Examgroup_Examresult {

    /**
     * Database_Mysql_Result
     */      
    private $_exams;

    /**
     * equivalent to as_array('id', 'name')
     */
    private $_exams_arr;

    /**
     * Model_Examgroup
     */
    private $_examgroup;

    /**
     * $students as_array('id', 'name')
     * name = {firstname} + {lastname}
     */
    private $_students;

    /**
     * Array array($user_id => array ($exam_id => marks))
     */
    private $_results;

    /**
     * Array array($exam_id => array($user_ids))
     */
    private $_exam_wise_students;

    /**
     * @param int $examgroup_id
     */
    public function __construct($examgroup_id) {
        // keep everything fetched from the db
        $this->_examgroup = ORM::factory('examgroup', $examgroup_id);
        // get all the exams in this exam group
        $this->_exams = Model_Examgroup::get_exams($examgroup_id);
        $this->_exams_arr = $this->_exams->as_array('id', 'name');
        $this->_students = Model_Examgroup::get_students($examgroup_id);
        $this->_results = Model_Examgroup::get_results($examgroup_id);
        $this->_exam_wise_students = self::exam_wise_students($this->_exams);
    }
    
    /*
     * Simple getter for examgroup object
     * @return Model_Examgroup $_examgroup
     */
    public function examgroup() {
        return $this->_examgroup;
    }

    /*
     * Simple getter for exams
     * @return Database_Mysql_Result $_exams
     */
    public function exams() {
        return $this->_exams;
    }

    /*
     * Simple getter for exams_arr
     * @return Array $_exams_arr
     */
    public function exams_arr() {
        return $this->_exams_arr;
    }

    /*
     * Simple getter for Students array
     * @return Array $_students
     */
    public function students() {
        return $this->_students;
    }

    /*
     * Simple getter for results array
     * @return Array $_results
     */
    public function results() {
        return $this->_results;
    }

    /*
     * Method to get student's name from user_id
     * @param int $user_id
     * @return String $fullname
     */
    public function get_student_name($user_id) {
        return Arr::get($this->_students, $user_id);
    }

    /*
     * Method to get exam name from the exam_id
     * @param int $exam_id
     * @return String $exam_name
     */
    public function get_exam_name($exam_id) {
        return Arr::get($this->_exams_arr, $exam_id);
    }

    /*
     * Method to check whether the exam is applicable to the student
     * @param int $student_id
     * @param int $exam_id
     * @return boolean true if applicable
     */
    public function student_takes_exam($student_id, $exam_id) {
        return in_array($student_id, $this->_exam_wise_students[$exam_id]);
    }

    /*
     * Method to get list of students exam wise ie per exam
     * @param Database_Mysql_Result $exams
     * @return Array array($exam_id => array($user_ids))
     */
    public static function exam_wise_students($exams) {
        $arr = array();
        foreach ($exams as $exam) {
            $users = $exam->course->users->find_all()->as_array('id');
            $arr[$exam->id] = array_keys($users);
        }
        return $arr;
    }
}