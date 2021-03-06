<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Flashcard extends Controller_Base {
	
    protected $_errors = array();

    protected function breadcrumbs() {
        parent::breadcrumbs();
        $course = ORM::factory('course', Session::instance()->get('course_id'));
        if (!$this->request->is_ajax() && $this->request->is_initial()) {
            Breadcrumbs::add(array('Courses', Url::site('course')));
            Breadcrumbs::add(array(sprintf($course->name), Url::site('course/summary/id/'.$course->id)));        
            Breadcrumbs::add(array('Flashcard', Url::site('flashcard')));
        }
    }
    
    public function action_index() {
        $sort = $this->request->param('sort', 'title');        
        $order = $this->request->param('order', 'ASC');
        
        //Session::instance()->delete('course_id');    
        
        $criteria = array(
            'filters' => array(
                'title' => $this->request->param('filter_title'),
                'description' => $this->request->param('filter_description'),
            ),
        );
        
        $total = Model_Flashcard::flashcard_total($criteria);
        
        $pagination = Pagination::factory(array(
            'total_items'    => $total,
            'items_per_page' => 5,
        ));
       
        $criteria = array_merge($criteria, array(
            'sort' => $sort,
            'order' => $order,
            'limit' => $pagination->items_per_page,
            'offset' => $pagination->offset            
        ));
        
        $flashcards = Model_Flashcard::flashcards($criteria);
        
        $sorting = new Sort(array(
            'Title'            => 'title',
            'Description'       => 'description',
            'No Of Questions'   => '',
            'Actions'           => '',
        ));
        
        $url = ('flashcard/index');
        
        if($this->request->param('filter_title')){
            $url .= '/filter_title/'.$this->request->param('filter_title');
            $filter = $this->request->param('filter_title');
            $filter_select = 'filter_title';
        }
        
        if($this->request->param('filter_description')){
            $url .= '/filter_description/'.$this->request->param('filter_description');
            $filter = $this->request->param('filter_description');
            $filter_select = 'filter_description';
        }
        
        $sorting->set_link($url);        
        $sorting->set_order($order);
        $sorting->set_sort($sort);
        $heading = $sorting->render();
        
        // Render the pagination links
        $pagination = $pagination->render();
        
        $links = array(
            'add' => Html::anchor('/flashcard/add/', 'Create a Flashcard Set', array('class' => 'createButton l')),
            'delete'      => URL::site('/flashcard/delete/')
        );
        
        $table = array('heading' => $heading, 'data' => $flashcards);
        
        $filter_title = $this->request->param('filter_title');
        $filter_description = $this->request->param('filter_description');
        
        $filter_url = URL::site('flashcard/index');        
        
        $success = Session::instance()->get('success');
        Session::instance()->delete('success');        
        
        $view = View::factory('flashcard/list')
            ->bind('table', $table)
            ->bind('count', $total)
            ->bind('links', $links)
            ->bind('pagination', $pagination)
            ->bind('filter', $filter)
            ->bind('filter_select', $filter_select)
            ->bind('filter_url', $filter_url)
            ->bind('success', $success)
            ;
        
        $this->content = $view;
        
    }
    
    public function action_add() {
        $submitted = false;
        
        if ($this->request->method() === 'POST' && $this->request->post()) {
            if (Arr::get($this->request->post(), 'save') !== null) {
                $submitted = true;
                $flashcard = ORM::factory('flashcard');
                $safepost = Arr::map('Security::xss_clean', $this->request->post());
                $validator = $flashcard->validator($safepost);
                if ($validator->check()) {
                    $flashcard->title = Arr::get($safepost, 'title');
                    $flashcard->description = Arr::get($safepost, 'description');
                    $flashcard->course_id = Session::instance()->get('course_id');
                    $flashcard->save();
                    if(Arr::get($safepost, 'question_selected')) {
                        Model_Flashcard::insert_flashcard_question($flashcard->id, Arr::get($safepost, 'question_selected'));
                    }
                    
                    $feed = new Feed_Flashcard();
                    
                    $feed->set_action('add');
                    $feed->set_course_id(Session::instance()->get('course_id'));
                    $feed->set_respective_id($flashcard->id);
                    $feed->set_actor_id(Auth::instance()->get_user()->id); 
                    $feed->streams(array(
                        'course_id' => (int)Session::instance()->get('course_id'),                        
                    ));
                    $feed->save();
                    
                    Session::instance()->set('success', 'Flashcard added successfully.');
                    Request::current()->redirect('flashcard');
                    exit;
                } else {
                    $this->_errors = $validator->errors('flashcard');
                }
            }
        }
        
        Breadcrumbs::add(array(
            'Create', Url::site('flashcard/add')
        ));

        $this->form('flashcard/add', $submitted);

    }

    private function form($action, $submitted = false, $saved_data = array()) {

        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'title' => '',
            'description' => '',
        );

        $form->saved_data = $saved_data;
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Title', 'title', 'text');
        $form->append('Description', 'description', 'textarea', array('attributes' => array('cols' => 50, 'rows' => 5)));
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();

        $id = $this->request->param('id');
        $sel_question = array();
        if($id != "") {
            $sel_question = Model_Flashcard::getQuestions($id);
        }
        
        $links = array(
            'cancel' => Html::anchor('/flashcard/', 'or cancel'),
            'click_here' => Html::anchor('/question/add/type/open', 'Click here')
        );

        $action = $this->request->action();
        
        $course_id = Session::instance()->get('course_id');
        
        $questions = Model_Flashcard::get_questions($course_id);
        
        $view = View::factory('flashcard/form')
            ->bind('links', $links)
            ->bind('form', $form)
            ->bind('action', $action)
            ->bind('id', $id)
            ->bind('questions', $questions)
            ->bind('selected_question', $sel_question)
            ;

        $this->content = $view;

    }

    public function action_edit() {
        $submitted = false;

        $id = $this->request->param('id');
        if (!$id) {
            Request::current()->redirect('flashcard');
        }

        $flashcard = ORM::factory('flashcard',$id);

        if ($this->request->method() === 'POST' && $this->request->post()) {
            if (Arr::get($this->request->post(), 'save') !== null) {
                $submitted = true;
                $safepost = Arr::map('Security::xss_clean', $this->request->post());
                $validator = $flashcard->validator($safepost);
                if ($validator->check()) {
                    $flashcard->title = Arr::get($safepost, 'title');
                    $flashcard->description = Arr::get($safepost, 'description');
                    $flashcard->course_id = Session::instance()->get('course_id');
                    $flashcard->save();
                    if(Arr::get($safepost, 'question_selected')) {
                        Model_Flashcard::insert_flashcard_question($flashcard->id, Arr::get($safepost, 'question_selected'));
                    }
                    
                    Session::instance()->set('success', 'Flashcard edited successfully.');
                    Request::current()->redirect('flashcard');
                    exit;
                } else {
                    $this->_errors = $validator->errors('flashcard');
                }
            }
        }

        Breadcrumbs::add(array(
            'Edit', Url::site('flashcard/edit/id/'.$id )
        ));
        
        $this->form('flashcard/edit/id/'.$id ,$submitted, array('title' => $flashcard->title, 'description' => $flashcard->description));
    }

    public function action_delete() {
        if ($this->request->method() === 'POST' && $this->request->post('selected')) {
            foreach($this->request->post('selected') as $flashcard_id) {
                ORM::factory('flashcard', $flashcard_id)->delete();
            }
        }
        Session::instance()->set('success', 'Flashcard(s) deleted successfully.');
        Request::current()->redirect('flashcard');
    }
    
    public function action_study() {
        $id = $this->request->param('id');
        $question_id = array();
        if($id != "") {
            $question_id = Model_Flashcard::getQuestions($id);
        }  
        $questions = Model_Flashcard::getQuestionsAndAnswers($question_id);
        $result = array();
        foreach($questions as $question) {
            if($question->attribute_name == 'matched_pairs') {
                $temps = unserialize($question->attribute_value);
                foreach($temps as $temp) {
                    $result[] =array( 
                           'question_id'        => $question->question_id,
                           'attribute_name'     => $question->attribute_name,
                           'attribute_value'    => $temp[1], 
                           'explanation'        => '',
                           'question'           => $temp[0], 
                        ); 
                } 
            } else {
                $result[] =array( 
                       'question_id'        => $question->question_id,
                       'attribute_name'     => $question->attribute_name,
                       'attribute_value'    => $question->attribute_value, 
                       'explanation'        => $question->explanation,
                       'question'           => $question->question, 
                    );
            }
        }
        
        
        $current_card = ORM:: factory('flashcard', $id);
        $current_card = $current_card->title;
        
        $other_cards = ORM::factory('flashcard');
        $other_cards->where('flashcards.course_id', '=',  Session::instance()->get('course_id'));
        $other_cards->where('flashcards.id', '<>',  $id);
        $other_cards->limit(5);
        $cards = $other_cards->find_all();
        
        $view = View::factory('flashcard/view')
            ->bind('questions', $result)
            ->bind('cards', $cards)
            ->bind('current_card', $current_card)
            ;
        Breadcrumbs::add(array(
            'View', Url::site('flashcard/study/id/'.$id )
        ));
        
        $this->content = $view;
    }
    
    public function action_revision() {
        $id = $this->request->param('id');
        $question_id = array();
        if($id != "") {
            $question_id = Model_Flashcard::getQuestions($id);
        }  
        $questions = Model_Flashcard::getQuestionsAndAnswers($question_id);
        $view = View::factory('flashcard/viewFlash')
            ->bind('questions', $questions)
            ;
        
         Breadcrumbs::add(array(
            'View', Url::site('flashcard/preview/id/'.$id )
        ));

        Breadcrumbs::add(array(
            'Revision Mode', Url::site('flashcard/revision/id/'.$id )
        ));
        
        $this->content = $view;
    }
    
    public function action_preview() {
        $id = $this->request->param('id');
        
        $view = View::factory('flashcard/preview')
            ->bind('id', $id)
            ;
        
        Breadcrumbs::add(array(
            'View', Url::site('flashcard/preview/id/'.$id )
        ));
        
        $this->content = $view;
    }
}