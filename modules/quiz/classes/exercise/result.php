<?php defined('SYSPATH') or die('No direct script access.');

class Exercise_Result {

    /**
     * Exercise orm object
     * Model_Exercise
     */
    protected $_exercise;

    /**
     * Array of Exercise_Question objects
     */
    protected $_questions = array();

    /**
     * Array of question_ids that were attempted
     */
    protected $_questions_attempted = array();

    /**
     * Final Score
     */
    protected $_score;

    /**
     * Int number of correct answers
     */
    protected $_num_correct;

    /**
     * Int number of incorrect answers
     */
    protected $_num_incorrect;

    /**
     * @param the exercise progress information stored in the Session
     */
    public function __construct($attempt_session) {
        $this->_exercise = ORM::factory('exercise', $attempt_session['exercise_id']);
        $questions = $this->_exercise->questions();                        
        foreach ($questions as $question) {
            $q = Question::factory((int)$question->question_id);
            $q->marks($question->marks);
            $this->_questions[] = $q;
        }        
        $this->_questions_attempted = $attempt_session['ques_attempted'];
        $this->_score = $this->calculate_score();
        $this->_num_correct = count(array_filter($this->_questions_attempted));
        $this->_num_incorrect = count($this->_questions) - $this->_num_correct;
    }

    /**
     * Method to calculate the score by adding the marks for every corectly answered question
     * @return float Score
     */
    protected function calculate_score() {
        $total = 0;
        foreach ($this->_questions as $q) {
            if ($this->is_correctly_answered($q->orm()->id)) {
                $total += $q->marks();
            }
        }
        return (float)$total;
    }

    /**
     * Method to find out if a question has been answered correctly
     * @param int $question_id
     */
    protected function is_correctly_answered($question_id) {
        return Arr::get($this->_questions_attempted, (int)$question_id, false);
    }

    /**
     * Getter for the exercise array
     * @return float 
     */
    public function exercise() {
        return $this->_exercise;
    }

    /**
     * Getter for the questions array
     * @return Array 
     */
    public function questions() {
        return $this->_questions;
    }

    /**
     * Getter for the score array
     * @return float 
     */
    public function score() {
        return $this->_score;
    }

    /**
     * Getter for the num_correct array
     * @return int
     */
    public function num_correct() {
        return $this->_num_correct;
    }

    /**
     * Getter for the num_incorrect array
     * @return int 
     */
    public function num_incorrect() {
        return $this->_num_incorrect;
    }
}
