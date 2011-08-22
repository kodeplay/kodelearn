<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Lecture extends Controller_Base {
    
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
        
        $lecture = ORM::factory('lecture')
                         ->join('courses')
                         ->on('courses.id', '=', 'lectures.course_id');
        
        $count = $lecture->count_all();
        
        $pagination = Pagination::factory(array(
            'total_items'    => $count,
            'items_per_page' => 5,
        ));
        
        $lecture->select(array('courses.name','course_name'), 'firstname', 'lastname')->join('courses')
            ->on('courses.id', '=', 'lectures.course_id')
            ->join('users')
            ->on('users.id', '=', 'lectures.user_id')
            ->group_by('id')
            ->order_by($sort, $order)
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ;
        $lectures = $lecture->find_all();
        
        $sorting = new Sort(array(
            'Lecture'           => 'name',
            'Course'            => 'courses.name',
            'Lecturer'          => 'firstname',
            'When'              => '',
            'Action'            => ''
        ));
        
        $url = ('lecture/index');
        
        $sorting->set_link($url);
        
        $sorting->set_order($order);
        $sorting->set_sort($sort);
        $heading = $sorting->render();
        
        $table = array('heading' => $heading, 'data' => $lectures);
        
        // Render the pagination links
        $pagination = $pagination->render();
        
        $links = array(
            'add'       => Html::anchor('/lecture/add/', 'Create a Lecture', array('class' => 'createButton l')),
            'delete'    => URL::site('/exam/delete/'),
        );
        
        $view = View::factory('lecture/list')
            ->bind('links', $links)
            ->bind('table', $table)
            ->bind('count', $count)
            ->bind('pagination', $pagination);
    	    	
        Breadcrumbs::add(array(
            'Lectures', Url::site('lecture')
        ));
    	
        $this->content = $view;
    }
    
    public function action_add(){
    	
        $submitted = FALSE;
        
        if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                	
                $submitted = true;
                $lecture = ORM::factory('lecture');
                $data = Stickyform::ungroup_params(($this->request->post()));
                $validator = $lecture->validator($data);
                if($this->request->post('type') == 'once'){
                    $validator->rule('once_date', 'not_empty')
                              ->rule('once_date', 'date');
                } else {
                	$validator->rule('repeat_from', 'not_empty')
                              ->rule('repeat_from', 'date')
                              ->rule('repeat_to', 'not_empty')
                              ->rule('repeat_to', 'date')
                              ->rule('repeat_from', 'Model_Lecture::date_check', array(':value',$data['repeat_to']));
                }
                
                if($this->request->post('type') == 'once'){
                    $data['when'] = '';
                    $data['start_date'] = strtotime($data['once_date']) + ($data['once_from'] * 60);
                    $data['end_date'] = strtotime($data['once_date']) + ($data['once_to'] * 60);
                    
                } else {
                	$date_range = $this->request->post('repeat');
                    $data['start_date'] = strtotime($date_range['from']);
                    $data['end_date'] = strtotime($date_range['to']) ;
                	
                	$days = array();
                	foreach($this->request->post('days') as $day=>$value){
                		$time = $this->request->post($day);
                		$days[$day] = $time['from'] . ':' . $time['to'];
                	}
                	
                    $data['when'] = serialize($days);
                }
                
                $event_lecture = new Event_Lecture();
                $event_lecture->set_values($data);
                $event_lecture->add();
                Request::current()->redirect('lecture');
                exit;
                
            } else {
                $this->_errors = $validator->errors('lecture');
            }
        }
        
        $form = $this->form('lecture/add', $submitted);

        $view = View::factory('lecture/form')
            ->bind('form', $form);
        
        Breadcrumbs::add(array(
            'Lectures', Url::site('lecture')
        ));
            
        Breadcrumbs::add(array(
            'Create', Url::site('lecture/add')
        ));
            
        $this->content = $view;
    	
    }

    private function form($action, $submitted = false, $saved_data = array()){
        
        $courses = ORM::factory('course')->find_all()->as_array('id', 'name');

        $users = array();
        foreach(Model_Role::get_users('teacher') as $user){
            $users[$user->id] = $user->firstname . ' ' . $user->lastname;
        }
        
        $rooms = array();
        foreach(ORM::factory('room')->find_all() as $room){
        	$rooms[$room->id] = $room->room_number . ', ' . $room->room_name;
        }

        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'name'          => '',
            'user_id'       => '',
            'course_id'     => '',
            'room_id'       => '',
            'once_date'     => '',
            'repeat_from'   => '',
            'repeat_to'     => '',
            'type'          => 'once',
        );
        
        $form->saved_data = $saved_data;
        $form->posted_data = $submitted ? Stickyform::ungroup_params(($this->request->post())) : array();
        $form->append('Name', 'name', 'text');
        $form->append('Type', 'type', 'radio');
        $form->append('Date:', 'once_date', 'text', array('attributes' => array('class' => 'date', 'name' => 'once[date]')));
        $form->append('From:', 'repeat_from', 'text', array('attributes' => array('class' => 'date', 'name' => 'repeat[from]')));
        $form->append('To:', 'repeat_to', 'text', array('attributes' => array('class' => 'date', 'name' => 'repeat[to]')));
        $form->append('Lecturer', 'user_id', 'select', array('options' => $users));
        $form->append('Course', 'course_id', 'select', array('options' => $courses));
        $form->append('Room', 'room_id', 'select', array('options' => $rooms));
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        
        return $form;
        
    }
}
