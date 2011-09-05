<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Exam extends Controller_Base {
    
    public function action_index(){
        
    	$relevant_user = Acl::instance()->relevant_user();
        
    	if($relevant_user){
            $this->get_schedule();
    	} else {
            $this->get_list();
    	}
    }
    
    private function get_schedule() {
        
    	$user = Auth::instance()->get_user();
        
    	$course_ids = $user->courses->find_all()->as_array(NULL, 'id');
        
    	if($course_ids){
            $exams = ORM::factory('exam')
                ->join('events')->on('exams.event_id', '=', 'events.id')
                ->where('exams.course_id', 'IN', $course_ids)
                ->and_where('events.eventstart', '>', time())
                ->find_all();
            $past_exams = ORM::factory('exam')
                ->join('events')->on('exams.event_id', '=', 'events.id')
                ->where('exams.course_id', 'IN', $course_ids)
                ->and_where('events.eventstart', '<', time())
                ->find_all();
    	} else {
            $exams = array(); 
            $past_exams = array(); 
    	}
        
    	$user_id = $user->id;
        $page_description = Kohana::message('page_title', 'exam_index_schedule.description');
        $page_title = Kohana::message('page_title', 'exam_index_schedule.title');
    	$view = View::factory('exam/schedule')
            ->bind('exams', $exams)
            ->bind('past_exams', $past_exams)
            ->bind('user_id', $user_id)
            ->bind('page_description', $page_description)
            ->bind('page_title', $page_title);
        
    	$this->content = $view;
    }
    
    private function get_list() {
        
        if($this->request->param('sort')){
            $sort = $this->request->param('sort');
        } else {
            $sort = 'name';
        }
        
        if($this->request->param('order')){
            $order = $this->request->param('order');
        } else {
            $order = 'DESC';
        }
        
        $exam = ORM::factory('exam');
        
        if($this->request->param('filter_name')){
            $exam->where('exams.name', 'LIKE', '%' . $this->request->param('filter_name') . '%');
        }
        
        if($this->request->param('filter_passing_marks')){
            $exam->where('exams.passing_marks', 'LIKE', '%' . $this->request->param('filter_passing_marks') . '%');
        }
        
        if($this->request->param('filter_total_marks')){
            $exam->where('exams.total_marks', 'LIKE', '%' . $this->request->param('filter_total_marks') . '%');
        }
        
        $count = $exam->count_all();
        
        $pagination = Pagination::factory(array(
            'total_items'    => $count,
            'items_per_page' => 5,
        ));
        
        if($this->request->param('filter_name')){
            $exam->where('exams.name', 'LIKE', '%' . $this->request->param('filter_name') . '%');
        }
        
        if($this->request->param('filter_passing_marks')){
            $exam->where('exams.passing_marks', 'LIKE', '%' . $this->request->param('filter_passing_marks') . '%');
        }
        
        if($this->request->param('filter_total_marks')){
            $exam->where('exams.total_marks', 'LIKE', '%' . $this->request->param('filter_total_marks') . '%');
        }
        
        $exam->group_by('id')
            ->order_by($sort, $order)
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ;
        $exams = $exam->find_all();
        
        $sorting = new Sort(array(
            'Name'              => 'name',
            'Grading Period'    => '',
            'Date / Time'       => '',
            'Course'            => '',
            'Total Marks'       => 'total_marks',
            'Passing Marks'     => 'passing_marks',
            'Reminder'          => 'reminder',
            'Action'        => ''
        ));
        
        $url = ('exam/index');
        
        if($this->request->param('filter_name')){
            $url .= '/filter_name/'.$this->request->param('filter_name');
        }
        
        if($this->request->param('filter_passing_marks')){
            $url .= '/filter_passing_marks/'.$this->request->param('filter_passing_marks');
        }
        
        if($this->request->param('filter_total_marks')){
            $url .= '/filter_total_marks/'.$this->request->param('filter_total_marks');
        }
        
        $sorting->set_link($url);
        
        $sorting->set_order($order);
        $sorting->set_sort($sort);
        $heading = $sorting->render();
        
        $table = array('heading' => $heading, 'data' => $exams);
        
        // Render the pagination links
        $pagination = $pagination->render();
        
        $links = array(
            'add'       => Html::anchor('/exam/add/', 'Create an Exam', array('class' => 'createButton l')),
            'delete'    => URL::site('/exam/delete/'),
            'examgroup' => Html::anchor('examgroup', 'Grading Period', array('class' => 'l pageAction')),
            'examresult' => Html::anchor('examresult/upload', 'Manage Results', array('class' => '1 pageAction')),
        );
        
        $filter_name = $this->request->param('filter_name');
        $filter_passing_marks = $this->request->param('filter_passing_marks');
        $filter_total_marks = $this->request->param('filter_total_marks');
        $filter_url = URL::site('exam/index');
        
        $success = Session::instance()->get('success');
        Session::instance()->delete('success');        
        
        $view = View::factory('exam/list')
            ->bind('links', $links)
            ->bind('table', $table)
            ->bind('count', $count)
            ->bind('filter_name', $filter_name)
            ->bind('filter_passing_marks', $filter_passing_marks)
            ->bind('filter_total_marks', $filter_total_marks)
            ->bind('filter_url', $filter_url)
            ->bind('success', $success)
            ->bind('pagination', $pagination);
        
        Breadcrumbs::add(array(
            'Exams', Url::site('exam')
        ));
            
        $this->content = $view;
    }
    
    public function action_add(){
        $submitted = FALSE;
        
        if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $exam = ORM::factory('exam');
                $validator = $exam->validator($this->request->post());
                $validator->bind(':to', $this->request->post('to'));
                $validator->bind(':total_marks', $this->request->post('total_marks'));
                if ($validator->check()) {

                    $from = strtotime($this->request->post('date')) + ($this->request->post('from') * 60); 
                    $to = strtotime($this->request->post('date')) + ($this->request->post('to') * 60); 
                    
                    $event_exam = Event_Abstract::factory('exam');

                    $event_exam->set_values($this->request->post());
                    $event_exam->set_value('eventstart', $from);
                    $event_exam->set_value('eventend', $to);
                    $event_id = $event_exam->add();
			
			        $exam = ORM::factory('exam');
			
			        $exam->values(array_merge($this->request->post(),array('event_id' => $event_id) ));
			
			        $exam->save();
			                    
			        $feed = new Feed_Exam();
			        
			        $feed->set_action('add');
			        $feed->set_course_id($this->request->post('course_id'));
			        $feed->set_respective_id($exam->id);
			        $feed->set_actor_id(Auth::instance()->get_user()->id); 
			        $feed->save();
			        $feed->subscribe_users();
			        Session::instance()->set('success', 'Exam added successfully.');
                    Request::current()->redirect('exam');
                    exit;
                } else {
                    $this->_errors = $validator->errors('exam');
                }
            }
        }
        
        $form = $this->form('exam/add', $submitted);
        $event_id = 0;
        $links = array(
            'rooms'       => Html::anchor('/room/', 'Add Rooms', array('target' => '_blank')),
        );
        
        $silder['start'] = 540;
        $silder['end'] = 600;
        
        $view = View::factory('exam/form')
            ->bind('form', $form)
            ->bind('event_id', $event_id)
            ->bind('slider', $silder)
            ->bind('links', $links);
        
        Breadcrumbs::add(array(
            'Exams', Url::site('exam')
        ));
            
        Breadcrumbs::add(array(
            'Create', Url::site('exam/add')
        ));
            
        $this->content = $view;
    }

    public function action_edit(){
        
    	$id = $this->request->param('id');
        
    	if(!$id)
            Request::current()->redirect('exam');
        
        $submitted = FALSE;
        
        if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $exam = ORM::factory('exam');
                $validator = $exam->validator($this->request->post());
                $validator->bind(':to', $this->request->post('to'));
                $validator->bind(':total_marks', $this->request->post('total_marks'));
                if ($validator->check()) {

                	$from = strtotime($this->request->post('date')) + ($this->request->post('from') * 60); 
                    $to = strtotime($this->request->post('date')) + ($this->request->post('to') * 60); 
                    
			        $exam = ORM::factory('exam', $id);
			
			        $exam->values($this->request->post());
			
			        $exam->save();
			                    
                    $event_exam = Event_Abstract::factory('exam');
                    $event_exam->set_values($this->request->post());
                    $event_exam->set_value('eventstart', $from);
                    $event_exam->set_value('eventend', $to);
                    
                    $event_exam->update($exam->event_id);

                    $feed = new Feed_Exam();
                    
                    $feed->set_action('edit');
                    $feed->set_course_id($this->request->post('course_id'));
                    $feed->set_respective_id($exam->id);
                    $feed->set_actor_id(Auth::instance()->get_user()->id); 
                    $feed->save();
                    $feed->subscribe_users();
                    Session::instance()->set('success', 'Exam edited successfully.');
                    Request::current()->redirect('exam');
                    exit;
                } else {
                    $this->_errors = $validator->errors('exam');
                }
            }
        }
        
        $exam = ORM::factory('exam', $id);
        
        $event = ORM::factory('event', $exam->event_id);
        
        $saved_data = array(
            'name'          => $exam->name,
            'examgroup_id'  => $exam->examgroup_id,
            'course_id'     => $exam->course_id,
            'total_marks'   => $exam->total_marks,
            'passing_marks' => $exam->passing_marks,
            'reminder'      => $exam->reminder,
            'date'          => date('Y-m-d', $event->eventstart),
            'from'          => date('H:i', $event->eventstart),
            'to'            => date('H:i', $event->eventend),
            'room_id'       => $event->room_id
        );

        $silder['start'] = ((($event->eventstart) - (strtotime($saved_data['date']))) / 60 );
        $silder['end'] = ((($event->eventend) - (strtotime($saved_data['date']))) / 60 );

        $form = $this->form('exam/edit/id/' . $id, $submitted, $saved_data);
        $event_id = $exam->event_id;
        $links = array(
            'rooms'       => Html::anchor('/room/', 'Add Rooms', array('target' => '_blank')),
        );
        $view = View::factory('exam/form')
            ->bind('form', $form)
            ->bind('event_id', $event_id)
            ->bind('links', $links)
            ->bind('slider', $silder);

        Breadcrumbs::add(array(
            'Exams', Url::site('exam')
        ));
            
        Breadcrumbs::add(array(
            'Edit', Url::site('exam/edit/id/' . $id)
        ));
            
        $this->content = $view;
    }
    
    private function form($action, $submitted = false, $saved_data = array()){
        
        
        $examgroups = array();
        foreach(ORM::factory('examgroup')->find_all() as $examgroup){
            $examgroups[$examgroup->id] = $examgroup->name;
        }
        
        $courses = array();
        foreach(ORM::factory('course')->find_all() as $course){
            $courses[$course->id] = $course->name;
        }
        
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'name'          => '',
            'examgroup_id'  => '',
            'course_id'     => '',
            'total_marks'   => '',
            'passing_marks' => '',
            'date' => '',
            'from' => '',
            'to' => '',
            'room_id' => '',
            'reminder'      => 1
            
        );
        
        $form->saved_data = $saved_data;
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Name', 'name', 'text');
        $form->append('Date', 'date', 'text', array('attributes' => array('class' => 'date')));
        $form->append('From', 'from', 'hidden', array('attributes' => array('id' => 'slider-range_from')));
        $form->append('To', 'to', 'hidden', array('attributes' => array('id' => 'slider-range_to')));
        $form->append('Total Marks', 'total_marks', 'text');
        $form->append('Passing Marks', 'passing_marks', 'text');
        $form->append('Reminder', 'reminder', 'hidden');
        $form->append('Grading Period', 'examgroup_id', 'select', array('options' => $examgroups));
        $form->append('Room', 'room_id', 'select', array('options' => array()));
        $form->append('Course', 'course_id', 'select', array('options' => $courses));
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        
        return $form;
        
    }
    
    public function action_delete(){
        if($this->request->method() === 'POST' && $this->request->post('selected')){
            foreach($this->request->post('selected') as $exam_id){
            	$exam = ORM::factory('exam', $exam_id);
            	ORM::factory('event', $exam->event_id);
            	$exam->delete();
            }
        }
        Session::instance()->set('success', 'Exam deleted successfully.');
        Request::current()->redirect('exam');
    }
}
