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
                          ->where('course_id', 'IN', $course_ids)
                          ->and_where('events.eventstart', '>', time())
                          ->find_all();
          $past_exams = ORM::factory('exam')
                          ->join('events')->on('exams.event_id', '=', 'events.id')
                          ->where('course_id', 'IN', $course_ids)
                          ->and_where('events.eventstart', '<', time())
                          ->find_all();
    	} else {
            $exams = array(); 
            $past_exams = array(); 
    	}
    	
    	$user_id = $user->id;
    	
    	$view = View::factory('exam/schedule')
    	               ->bind('exams', $exams)
    	               ->bind('past_exams', $past_exams)
    	               ->bind('user_id', $user_id);
    	
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
        
        $count = $exam->count_all();
        
        $pagination = Pagination::factory(array(
            'total_items'    => $count,
            'items_per_page' => 5,
        ));
        
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
            'examgroup' => Html::anchor('examgroup', 'Grading Period', array('class' => 'l pageAction'))
        );
        
        $view = View::factory('exam/list')
            ->bind('links', $links)
            ->bind('table', $table)
            ->bind('count', $count)
            ->bind('pagination', $pagination);
        
        $this->content = $view;
    }
    
    public function action_add(){
        $submitted = FALSE;
        
        if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $exam = ORM::factory('exam');
                $validator = $exam->validator($this->request->post());
                if ($validator->check()) {
                    $event_exam = Event::factory('exam');

                    $from = $this->request->post('date') . ' ' . $this->request->post('from');
                    if(!(strtotime($from)))
                        $from = $this->request->post('date') . ' 00:00';
                    
                    $to = $this->request->post('date') . ' ' . $this->request->post('to'); 
                    if(!(strtotime($to)))
                        $to = $this->request->post('date') . ' 00:00';
                    
                    $from = strtotime($from);
                    $to = strtotime($to);
                    
                    $event_exam->set_values($this->request->post());
                    $event_exam->set_value('eventstart', $from);
                    $event_exam->set_value('eventend', $to);
                    $event_exam->add();

                    Request::current()->redirect('exam');
                    exit;
                } else {
                    $this->_errors = $validator->errors('exam');
                }
            }
        }
        
        $form = $this->form('exam/add', $submitted);
        $event_id = 0;
        $view = View::factory('exam/form')
            ->bind('form', $form)
            ->bind('event_id', $event_id);
        
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
                if ($validator->check()) {
                    $event_exam = Event::factory('exam');

                    $from = $this->request->post('date') . ' ' . $this->request->post('from');
                    if(!(strtotime($from)))
                        $from = $this->request->post('date') . ' 00:00';
                    
                    $to = $this->request->post('date') . ' ' . $this->request->post('to'); 
                    if(!(strtotime($to)))
                        $to = $this->request->post('date') . ' 00:00';
                    
                    $from = strtotime($from);
                    $to = strtotime($to);
                    
                    $event_exam->set_values($this->request->post());
                    $event_exam->set_value('eventstart', $from);
                    $event_exam->set_value('eventend', $to);
                    $event_exam->update($id);

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

        $results = Event::get_avaliable_rooms($event->eventstart, $event->eventend, $event->id);
        
        $rooms = array();
        foreach($results as $room){
            $rooms[$room->id] = $room->room_number . ', ' . $room->room_name;
        }
        
        $room = ORM::factory('room', $event->room_id);
        
        $rooms[$room->id] = $room->room_number . ', ' . $room->room_name;
        
        $form = $this->form('exam/edit/id/' . $id, $submitted, $saved_data, $rooms);
        $event_id = $exam->event_id;
        $view = View::factory('exam/form')
            ->bind('form', $form)
            ->bind('event_id', $event_id);
        
        $this->content = $view;
    }
    
    private function form($action, $submitted = false, $saved_data = array(), $rooms = array()){
        
        
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
        $form->append('From', 'from', 'text', array('attributes' => array('class' => 'time', 'size' => '4', 'style' => 'min-width: 20px;')));
        $form->append('To', 'to', 'text', array('attributes' => array('class' => 'time', 'size' => '4', 'style' => 'min-width: 20px;')));
        $form->append('Total Marks', 'total_marks', 'text');
        $form->append('Passing Marks', 'passing_marks', 'text');
        $form->append('Reminder', 'reminder', 'hidden');
        $form->append('Grading Period', 'examgroup_id', 'select', array('options' => $examgroups));
        $form->append('Room', 'room_id', 'select', array('options' => $rooms));
        $form->append('Course', 'course_id', 'select', array('options' => $courses));
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        
        return $form;
        
    }
    
    public function action_get_avaliable_rooms(){
        
        $from = $this->request->post('date') . ' ' . $this->request->post('from');
        if(!(strtotime($from)))
            $from = $this->request->post('date') . ' 00:00';
        
        $to = $this->request->post('date') . ' ' . $this->request->post('to'); 
        if(!(strtotime($to)))
            $to = $this->request->post('date') . ' 00:00';
        
        $from = strtotime($from);
        $to = strtotime($to);
        
        $event_id = $this->request->post('event_id');
        
        $results = Event::get_avaliable_rooms($from, $to, $event_id);
        
        $rooms = array();
        foreach($results as $room){
            $rooms[$room->id] = $room->room_number . ', ' . $room->room_name;
        }
        
        $element =Form::select('room_id',$rooms);
        
        echo json_encode(array('element' => $element));
        
    }
    
    public function action_delete(){
        if($this->request->method() === 'POST' && $this->request->post('selected')){
            foreach($this->request->post('selected') as $exam_id){
                ORM::factory('exam', $exam_id)->delete();
            }
        }
        Request::current()->redirect('exam');
    }
}
