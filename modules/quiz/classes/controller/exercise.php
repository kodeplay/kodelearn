<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Exercise extends Controller_Base {

    protected $_errors = array();

    protected function breadcrumbs() {
        parent::breadcrumbs();
        $course = ORM::factory('course', Session::instance()->get('course_id'));
        if (!$this->request->is_ajax() && $this->request->is_initial()) {
            Breadcrumbs::add(array('Courses', Url::site('course')));
            Breadcrumbs::add(array(sprintf($course->name), Url::site('course/id/'.$course->id)));
            Breadcrumbs::add(array('Exercises', Url::site('exercise')));
        }
    }

    /**
     * Action to show the list of exercises
     */
    public function action_index() {
        $view = View::factory('exercise/list')
            ->bind('table', $table)
            ->bind('course', $course)
            ->bind('links', $links)
            ->set('success', Session::instance()->get_once('success', ''));
        $course = ORM::factory('course', Session::instance()->get('course_id'));
        $exercises = ORM::factory('exercise')
            ->where('course_id', ' = ', $course->id)
            ->find_all();
        $links = array(
            'add' => Html::anchor('/exercise/add/', 'Create an Exercise', array('class' => 'createButton l')),
            'delete' => URL::site('/exercise/delete/'),
        );
        $sortables = new Sort(array(
            'Title' => '',
            'Type' => '',
            'Questions' => array('sort' => '', 'attributes' => array('class' => 'tac')),
            'Marks' => array('sort' => '', 'attributes' => array('class' => 'tac')),
            'Status' => array('sort' => '', 'attributes' => array('class' => 'tac')),
            'Actions' => array('sort' => '', 'attributes' => array('class' => 'tac')),
        ));
        $headings = $sortables->render();
        $table = array(
            'headings' => $headings,
            'data' => $exercises,
        );

        $this->content = $view;
    }

    public function action_add() {
        $view = View::factory('exercise/form')
            ->bind('form', $form)
            ->bind('questions', $questions)
            ->bind('selected_questions', $selected_questions)
            ->bind('error_notif', $error_notif);
        $submitted = false;
        $course = ORM::factory('course', Session::instance()->get('course_id'));
        $selected_questions = array();
        $error_notif = array();
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $submitted = true;
            $exercise = ORM::factory('exercise');
            $safepost = Arr::map('Security::xss_clean', $this->request->post());
            $validator = $exercise->validator($safepost);
            if ($validator->check() && $this->validate_form($this->request->post())) {
                $exercise->values(array_merge($safepost, array(
                    'course_id' => $course->id,
                    'slug' => Text::limit_chars(Inflector::underscore($safepost['title']))
                )));
                $exercise->save();
                $zip_ques = Arr::zip($safepost['selected'],$safepost['marks']);
                $exercise->add_questions($zip_ques);
                Session::instance()->set('success', 'Exercise added successfully.');
                Request::current()->redirect('exercise');
                exit;
            } else {
                $this->_errors = array_merge($this->_errors, $validator->errors('exercise'));
                $selected_questions = Arr::get($this->request->post(), 'selected', array());
                $error_notif = Arr::get($this->_errors, 'questions', '');
            }
        }
        $form = $this->form('exercise/add', $submitted);
        $questions = Model_Question::get_questions(array('course_id' => $course->id));
        Breadcrumbs::add(array('Add', ''));
        $this->content = $view;
    }

    public function action_edit() {
        $view = View::factory('exercise/form')
            ->bind('form', $form)
            ->bind('questions', $questions)
            ->bind('selected_questions', $selected_questions)
            ->bind('exercise_questions', $exercise_questions)
            ->bind('error_notif', $error_notif);
        $submitted = false;
        $course = ORM::factory('course', Session::instance()->get('course_id'));
        $error_notif = array();
        $exercise_id = (int) $this->request->param('id');
        $exercise = ORM::factory('exercise', $exercise_id);
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $submitted = true;
            $safepost = Arr::map('Security::xss_clean', $this->request->post());
            $validator = $exercise->validator($safepost);
            if ($validator->check() && $this->validate_form($safepost)) {
                $exercise->values(array_merge($safepost, array(
                    'course_id' => $course->id,
                    'slug' => Text::limit_chars(Inflector::underscore($safepost['title']))
                )));
                $exercise->save();
                $zip_ques = Arr::zip($safepost['selected'],$safepost['marks']);
                $exercise->delete_questions()
                    ->add_questions($zip_ques);
                Session::instance()->set('success', 'Exercise edited successfully.');
                Request::current()->redirect('exercise');
                exit;
            } else {
                $this->_errors = array_merge($this->_errors, $validator->errors('exercise'));
                $error_notif = Arr::get($this->_errors, 'questions', '');
            }
        }
        $exercise_questions = $exercise->questions()->as_array('question_id', 'marks');
        $selected_questions = array_keys($exercise_questions);
        $saved_data = $exercise->as_array();
        $form = $this->form('exercise/edit/id/'.$exercise->id, $submitted, $saved_data);
        Breadcrumbs::add(array('Edit', ''));
        // set content
        $questions = Model_Question::get_questions(array('course_id' => $course->id));
        $this->content = $view;
    }

    protected function form($action, $submitted=false, $saved_data=array()) {
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'title' => '',
            'format' => 'quiz',
            'description' => '',
            'pub_status' => 1,
            // 'session_resumable' => 0,
            'time_minutes' => '',
        );
        $form->saved_data = $saved_data;
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Exercise Title', 'title', 'text');
        $form->append('Description', 'description', 'textarea', array('attributes' => array('class' => 'w70 ht120')));
        $form->append('Format', 'format', 'select', array('options' => array(
            'quiz' => 'Quiz Format',
            'test' => 'Test Format'
        )));
        $form->append('Status', 'pub_status', 'select', array('options' => array(1 => 'Published', 0 => 'Unpublished')));
        // $form->append('Resume Session?', 'session_resumable', 'select', array('options' => array(1 => 'Yes', 0 => 'No')));
        $form->append('Time (in mins)', 'time_minutes', 'text');
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button r')));
        $form->process();
        return $form;
    }

    /**
     * Extra validation to check that atleast one question has been selected
     */
    protected function validate_form($data) {
        if (empty($data['selected'])) {
            $this->_errors['questions'] = 'Please select atleast one question';
        }
        return !($this->_errors);
    }

    /**
     * Action for deleting the exercises from an array of exercise ids
     * coming in from the post request
     */
    public function action_delete() {
        if ($this->request->method() === 'POST' && $this->request->post()) {
            if ($this->request->post('selected')) {
                DB::delete('exercises')
                    ->where('id', ' IN ', $this->request->post('selected'))
                    ->execute();
            }
            Session::instance()->set('success', 'Exercise(s) deleted successfully.');
        }
        Request::current()->redirect('exercise');
    }

    /**
     * Action when the user attempts the exercise
     */
    public function action_start() {
        $view = View::factory('exercise/start')
            ->bind('exercise', $exercise)
            ->bind('partial', $partial);
        $exercise_id = $this->request->param('id');
        $exercise = ORM::factory('exercise', $exercise_id);
        $format = $exercise->format;
        $questions = $exercise->questions();
        Session::instance()->delete('exercise_attempt');
        $attempt_session = array(
            'exercise_id' => $exercise->id,
            'format' => $format,
            'ques_total' => count($questions->as_array())
        );
        if ($format == 'quiz') {
            $attempt_session = array_merge($attempt_session, array(
                'ques_upcoming' => array_map('intval', $questions->as_array(null, 'question_id')),
                'ques_attempted' => array(),
            ));
            $partial_view = View::factory('exercise/partial_quiz');
        } elseif ($format == 'test') {
            $partial_view = View::factory('exercise/partial_test')
                ->set('questions', $questions);
        }
        $partial = $partial_view->render();
        Session::instance()->set('exercise_attempt', $attempt_session);
        $this->content = $view;
    }

    /**
     * Method to show a question while the exercise session is on
     * A question will be requested by ajax and the response will
     * be sent in json
     */
    public function action_ajax_next_question() {
        // get the exercise id from the session
        $attempt_session = Session::instance()->get('exercise_attempt');
        if ($attempt_session === null) {
            throw new Exception('No Exercise found in session');
        }
        $question_id = array_shift($attempt_session['ques_upcoming']);
        // StopIteration!
        if ($question_id == null) {
            $this->content = json_encode(array('status' => 404));
        } else {
            $question = Question::factory($question_id); // load from the question id
            $attempt_session = Session::instance()->set('exercise_attempt', $attempt_session);
            $response = array(
                'status' => 200,
                'html' => $question->render_question(),
                'question_id' => $question_id,
                'type' => $question->type(),
                'num_hints' => count($question->orm()->hints_as_array()),
            );
            $this->content = json_encode($response);
        }
    }

    /**
     * Action to receive the answer
     * Will be an ajax post request
     * and will except following data -
     * question_id, answer
     */
    public function action_ajax_submit_answer() {
        $attempt_session = Session::instance()->get('exercise_attempt');
        if ($attempt_session === null) {
            throw new Exception('No Exercise found in session');
        }
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $question_id = (int)$this->request->post('question_id');
            $answer = Arr::get($this->request->post(), 'answer', array());
            $question = Question::factory($question_id); // load from the question id
            $result = $question->check_answer($answer);
            $attempt_session['ques_attempted'][$question_id] = $result; 
            Session::instance()->set('exercise_attempt', $attempt_session);
            $ques_remaining = (int)$attempt_session['ques_total'] - count($attempt_session['ques_upcoming']);
            $response = array(
                'status' => 1,
                'result' => (int)$result,
                'progress' => sprintf('%d/%d', $ques_remaining, $attempt_session['ques_total']),
            );
        } else {
            $response = array('status' => 0);
        }
        $this->content = json_encode($response);
    }

    public function action_results() {
        error_reporting(E_ALL|E_STRICT);
        ini_set('display_errors', 'on');
        $view = View::factory('exercise/results')
            ->bind('result', $result);
        $attempt_session = Session::instance()->get('exercise_attempt');
        if ($attempt_session === null) {
            throw new Exception('No on going Exercise session found');
        }
        $result = new Exercise_Result($attempt_session);
        $this->content = $view;
    }
}
