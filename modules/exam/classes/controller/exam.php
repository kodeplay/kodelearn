<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Exam extends Controller_Base {
	
	public function action_index(){
        
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
                'Total Marks'       => '',
                'Passing Marks'     => '',
                'Reminder'          => '',
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
            'add' => Html::anchor('/exam/add/', 'Create an Exam', array('class' => 'createButton l')),
            'delete'      => URL::site('/exam/delete/')
        );
		
        $view = View::factory('exam/list')
                        ->bind('links', $links)
                        ->bind('table', $table)
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
                    
                    $event_exam->set_values($this->request->post());
                    echo '<pre>';
                    print_r($this->request->post());
                	echo '</pre>';
                	exit;
                    Request::current()->redirect('exam');
                    exit;
                } else {
                    $this->_errors = $validator->errors('exam');
                }
            }
        }
        
        $form = $this->form('exam/add', $submitted);
		
		$view = View::factory('exam/form')
		               ->bind('form', $form);
		
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
        $form->append('From', 'from', 'text', array('attributes' => array('class' => 'time', 'size' => '4', 'style' => 'min-width: 20px;')));
        $form->append('To', 'to', 'text', array('attributes' => array('class' => 'time', 'size' => '4', 'style' => 'min-width: 20px;')));
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
    
    public function action_get_avaliable_rooms(){
    	
        $from = $this->request->post('date') . ' ' . $this->request->post('from');
        if(!(strtotime($from)))
            $from = $this->request->post('date') . ' 00:00';
                          
        $to = $this->request->post('date') . ' ' . $this->request->post('to'); 
        if(!(strtotime($to)))
            $to = $this->request->post('date') . ' 00:00';
            
        $from = strtotime($from);
        $to = strtotime($to);
        
        $rooms = Event::get_avaliable_rooms($from, $to);
        
    }
    
}
