<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Question extends Controller_Base {

    protected $_errors = array();

    public function action_index() {
        $view = View::factory('question/list')
            ->bind('table', $table)
            ->bind('total', $total)
            ->bind('links', $links)
            ->bind('success', $success)
            ->bind('types', $types);
        // get all the courses
        $questions = ORM::factory('question')->find_all();
        $total = ORM::factory('question')->count_all();
        $sortables = new Sort(array(
            'Question' => 'question',
            'Type' => 'type',
            'Actions' => '',
        ));
        $headings = $sortables->render();
        $table = array(
            'headings' => $headings,
            'data' => $questions
        );
        $types = array('choice', 'open', 'ordering', 'matching');
        $links = array(
            'add' => Html::anchor('/question/add/', 'Create a question', array('class' => 'createButton l')),
            'delete' => URL::site('/question/delete/'),
        );        
        $success = Session::instance()->get_once('success');
        $this->content = $view;
    }

    public function action_add() {
        $view = View::factory('question/form')
            ->bind('type', $type)
            ->bind('form', $form)
            ->bind('hints', $hints)
            ->bind('error_notif', $error_notif)
            ->bind('solution_form', $solution_form)
            ->bind('solution_tab', $solution_tab);        
        $submitted = false;
        $type = $this->request->param('type');
        $question = Question::factory($type);
        $hints = array();
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $submitted = true;
            if ($question->validate($this->request->post())) {
                // var_dump($this->request->post()); exit;
                $question->save($this->request->post());
                Session::instance()->set('success', 'Question added successfully.');
                Request::current()->redirect('question');
            } else {
                $this->_errors = $question->validation_errors();
                $error_notif = __('Form could not be submitted due to errors. Please check the other tabs for error messages too');
            }
            // stickyness for the hints section
            $post_hints = $this->request->post('hints');
            $hints = $question->process_hints($post_hints);
        }
        $form = $this->form('question/add/type/'.$type, $submitted);
        $solution_form = $question->render_form($this->request->post());
        $solution_tab = $question->solution_tab();
        if (!$hints) {
            $hints[] = array(
                'hint' => '',
                'sort_order' => '',
                'deduction' => '',
            );
        }
    	Breadcrumbs::add(array(
            'Questions', Url::site('question')
        ));        
        Breadcrumbs::add(array(
            'Create', Url::site('question/add')
        ));
        $this->content = $view;
    }

    public function action_edit() {
        $view = View::factory('question/form')
            ->bind('type', $type)
            ->bind('form', $form)
            ->bind('hints', $hints)
            ->bind('error_notif', $error_notif)
            ->bind('solution_form', $solution_form)
            ->bind('solution_tab', $solution_tab);        
        $submitted = false;
        $question = Question::factory((int) $this->request->param('id'));
        $hints = $question->orm()->hints_as_array();
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $submitted = true;
            if ($question->validate($this->request->post())) {
                $question->save($this->request->post());
                Session::instance()->set('success', 'Question edited successfully.');
                Request::current()->redirect('question');
            } else {
                $this->_errors = $question->validation_errors();
                $error_notif = __('Form could not be submitted due to errors. Please check the other tabs for error messages too');
            }
            // stickyness for the hints section
            $post_hints = $this->request->post('hints');
            $hints = $question->process_hints($post_hints);
        }
        $form = $this->form('question/edit/id/'.$question->orm()->id, $submitted, $question->orm()->as_array());
        $solution_form = $question->render_form($this->request->post());
        $solution_tab = $question->solution_tab();
        if (!$hints) {
            $hints[] = array(
                'hint' => '',
                'sort_order' => '',
                'deduction' => '',
            );
        }
    	Breadcrumbs::add(array(
            'Questions', Url::site('question')
        ));        
        Breadcrumbs::add(array(
            'Edit', Url::site('question/add')
        ));
        $this->content = $view;
    }

    protected function form($action, $submitted=false, $saved_data=array()) {
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'question' => '',
            'extra' => '',
        );
        $form->saved_data = $saved_data;
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Question', 'question', 'textarea', array('attributes' => array('class' => 'w70 ht120')));
        $form->append('Extra Info', 'extra', 'textarea', array('attributes' => array('class' => 'w70 ht120')));
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button r')));
        $form->process();
        return $form;        
    }

    public function action_preview() {        
        $view = View::factory('question/view')
            ->set('preview', true)
            ->bind('question_partial', $question_partial);
        $question_id = $this->request->param('id');
        $ques_obj = Question::factory((int)$question_id);   
        $question_partial = $ques_obj->render_question(true);
        $this->content = $view;
    }

    public function action_delete() {
        if ($this->request->method() === 'POST' && $this->request->post('selected')) {
            $selected = $this->request->post('selected');
            foreach ($selected as $question_id) {
                $question = ORM::factory('question', $question_id);
                $question->delete();
            }
            Session::instance()->set('success', 'Question(s) deleted successfully.');
        }
        Request::current()->redirect('question');
    }
}
