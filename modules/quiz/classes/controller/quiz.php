<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Quiz extends Controller_Base {
	
    public function action_index() {
    	$view = View::factory('quiz/index');        
        $this->content = $view;
    }

    /**
     * Action when the user takes the quiz
     */
    public function action_play() {
        $view = View::factory('quiz/play')
            ->bind('quiz', $quiz);
        // get the quiz id from the param        
        Session::instance()->delete('quiz');        
        $questions = ORM::factory('question')
            ->find_all()
            ->as_array(null, 'id');
        // store it in the session 
        $quiz_session = array(
            'quiz_id' => 1,
            'ques_upcoming' => array_map('intval', $questions),
            'ques_attempted' => array(),
        );
        Session::instance()->set('quiz', $quiz_session);
        // for now try with all questions with static data
        $quiz = array(
            'quiz_id' => 1,
            'title' => 'A sample quiz',
            'instructions' => " is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries",
            'resume_session' => 0
        );        
        $this->content = $view;
    }

    /**
     * Method to show a question while the quiz session is on
     * A question will be requested by ajax and the response will
     * be sent in json
     */
    public function action_question() {
        // get the quiz id from the session         
        $quiz_session = Session::instance()->get('quiz');
        if ($quiz_session === null) {
            throw new Exception('No Quiz found in session');
        }
        $question_id = array_shift($quiz_session['ques_upcoming']);        
        $question = Question::factory($question_id); // load from the question id        
        $quiz_session['ques_attempted'][] = $question_id;
        Session::instance()->set('quiz', $quiz_session);
        $response = array(
            'status' => 200,
            'html' => $question->render_question(),
            'question_id' => $question_id,
            'type' => $question->type(),
            'num_hints' => count($question->orm()->hints_as_array())
        );
        $this->content = json_encode($response);        
    }

    /**
     * Action to receive the answer
     * Will be an ajax post request
     * and will except following data - 
     * question_id, answer
     */
    public function action_answer() {
        $quiz_session = Session::instance()->get('quiz');
        if ($quiz_session === null) {
            throw new Exception('No Quiz found in session');
        }
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $question_id = (int)$this->request->post('question_id');
            $answer = $this->request->post('answer');
            $question = Question::factory($question_id); // load from the question id
            $result = $question->check_answer($answer);
            $response = array(
                'status' => 1,
                'result' => (int)$result,
            );
        } else {
            $response = array('status' => 0);
        }
        $this->content = json_encode($response);
    }
}