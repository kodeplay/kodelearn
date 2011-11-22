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
     * Array of with question_id as key and assoc array
     * with answer and result as values, answer being the submitted answer
     */
    protected $_questions_attempted = array();

    /**
     * Array with question_ids as keys and submitted answers as values
     */
    protected $_questions_answers = array();

    /**
     * Array with question_ids as keys and results as values
     */
    protected $_questions_results = array();

    /**
     * Final Score
     */
    protected $_score;

    /**
     * Total marks (Max) that can be obtained if all answers are correct
     */      
    protected $_total_marks = 0;

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
        $questions = $attempt_session['questions'];
        foreach ($questions as $question_id=>$marks) {
            $q = Question::factory((int)$question_id);
            $q->marks($marks);
            $this->_total_marks += $marks;
            $this->_questions[] = $q;
        }        
        $this->_questions_attempted = $this->questions_attempted($attempt_session['ques_attempted']);
        $this->_score = $this->calculate_score();
        $this->_num_correct = count(array_filter($this->_questions_results));
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
        return Arr::get($this->_questions_results, (int)$question_id, false);
    }

    /**
     * Combined Setter/Getter method for questions_attempted array
     * @param Array $ques (optional (default null))
     * As a sideeffect, it will also set the $_questions_answers and
     * $_questions_results arrays
     */
    public function questions_attempted($ques=null) {
        if ($ques != null) {
            $this->_questions_attempted = $ques;
            $question_ids = array_keys($this->_questions_attempted);
            $answers = Arr::pluck($this->_questions_attempted, 'answer');
            $results = Arr::pluck($this->_questions_attempted, 'result');
            $this->_questions_answers = array_combine($question_ids, $answers);
            $this->_questions_results = array_combine($question_ids, $results);
            return null;
        }
        return $this->_questions_attempted;
    }

    /**
     * Method to get an array of all questions and the answer reviews for the same
     * It will also have an explanation as to why the answer submitted is right or wrong
     * @return Array 
     */
    public function answer_reviews() {
        $question_list = array();
        foreach ($this->_questions as $ques) {
            $question_list[] = array(
                'question' => $ques->orm()->question,
                'score' => $this->is_correctly_answered($ques->orm()->id) ? $ques->marks() : 0,
                'total_marks' => $ques->marks(),
                'answer_review' => $ques->answer_review(Arr::get($this->_questions_answers, $ques->orm()->id))
            );
        }
        return $question_list;        
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
     * Getter for the total_marks array
     * @return float 
     */
    public function total_marks() {
        return $this->_total_marks;
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
    
    /**
     * Method to get the list of question ids of questions
     * in this exercise
     */
    public function question_id_list() {
        $list = array();
        foreach ($this->_questions as $question) {
            $list[] = $question->orm()->id;
        }
        return $list;
    }
}
