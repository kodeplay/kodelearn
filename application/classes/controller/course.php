<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Course extends Controller_Base {
    
    public function action_index() {        
        $sort = $this->request->param('sort', 'name');        
        $order = $this->request->param('order', 'ASC');
        
        $criteria = array(
            'user' => Acl::instance()->relevant_user(),
            'filters' => array(
                'name' => $this->request->param('filter_name'),
                'access_code' => $this->request->param('filter_access_code'),
                'start_date' => $this->request->param('filter_start_date'),
                'end_date' => $this->request->param('filter_end_date'),
            ),
        );

        $total = Model_Course::courses_total($criteria);

        $pagination = Pagination::factory(array(
            'total_items'    => $total,
            'items_per_page' => 5,
        ));
        
        $criteria = array_merge($criteria, array(
            'sort' => $sort,
            'order' => $order,
            'limit' => $pagination->items_per_page,
            'offset' => $pagination->offset,            
        ));
        
        $courses = Model_Course::courses($criteria);
        
        $sorting = new Sort(array(
            'Course'        => 'name',
            'Access Code'   => 'access_code',
            'Start Date'    => 'start_date',
            'End Date'      => 'end_date',
            'Actions'       => '',
        ));
        
        $url = ('course/index');
        
        if($this->request->param('filter_name')){
            $url .= '/filter_name/'.$this->request->param('filter_name');
        }
        
        if($this->request->param('filter_access_code')){
            $url .= '/filter_access_code/'.$this->request->param('filter_access_code');
        }
        
        if($this->request->param('filter_start_date')){
            $url .= '/filter_start_date/'.$this->request->param('filter_start_date');
        }
        
        if($this->request->param('filter_end_date')){
            $url .= '/filter_end_date/'.$this->request->param('filter_end_date');
        }
        
        $sorting->set_link($url);        
        $sorting->set_order($order);
        $sorting->set_sort($sort);
        $heading = $sorting->render();
        
        // Render the pagination links
        $pagination = $pagination->render();
        
        $links = array(
            'add' => Html::anchor('/course/add/', 'Create a course', array('class' => 'createButton l')),
            'delete'      => URL::site('/course/delete/'),
            'join' => Html::anchor('/course/join/', 'Join Course', array('class' => 'pageAction c'))
        );
        
        $table = array('heading' => $heading, 'data' => $courses);
        
        $filter_name = $this->request->param('filter_name');
        $filter_access_code = $this->request->param('filter_access_code');
        $filter_start_date = $this->request->param('filter_start_date');
        $filter_end_date = $this->request->param('filter_end_date');
        $filter_url = URL::site('course/index');        
        
        $view = View::factory('course/list')
            ->bind('table', $table)
            ->bind('count', $total)
            ->bind('links', $links)
            ->bind('pagination', $pagination)
            ->bind('filter_name', $filter_name)
            ->bind('filter_access_code', $filter_access_code)
            ->bind('filter_start_date', $filter_start_date)
            ->bind('filter_end_date', $filter_end_date)
            ->bind('filter_url', $filter_url)
            ;
        
        Breadcrumbs::add(array(
            'Courses', Url::site('course')
        ));
        
        $this->content = $view;
    }
    
    public function action_delete(){
        if($this->request->method() === 'POST' && $this->request->post('selected')){
            foreach($this->request->post('selected') as $course_id){
                ORM::factory('course', $course_id)->delete();
            }
        }
        Request::current()->redirect('course');
    }
    
    public function action_add() {        
        $submitted = FALSE;
        if ($this->request->method() === 'POST' && $this->request->post()) {
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $course = ORM::factory('course');
                $validator = $course->validator($this->request->post());
                $validator->bind(':course', NULL);
                $validator->bind(':start_date', $this->request->post('start_date'));
                if ($validator->check()) {
                    $course->name = $this->request->post('name');
                    $course->description = $this->request->post('description');
                    $course->access_code = $this->request->post('access_code');
                    $course->start_date = $this->request->post('start_date');
                    $course->end_date = $this->request->post('end_date');
                    $course->save();
                    Model_Course::assign_users($course, $this->request->post('selected'));
                    Request::current()->redirect('course');
                    exit;
                } else {
                    $this->_errors = $validator->errors('course');
                }
            }
        }        
        $form = $this->form('course/add', $submitted);        
        $cacheimage = CacheImage::instance();
        $user_ids = array();
        $data = array();
        $count = 0;
        $selected = $this->request->post('selected');
        if ($selected) {
            $user_ids = $selected;
            $student_role_id = Model_Role::from_name('student')->id;
            $users = ORM::factory('user')
                ->join('roles_users')
                ->on('users.id', ' = ', 'roles_users.user_id')
                ->where('users.id' , 'IN', $selected)
                ->and_where('roles_users.role_id', ' = ', $student_role_id);
            $data = $users->find_all();
            $count = $users->count_all();
        } else {
        	$selected = array();
        }
        $course_id = 0;
        $users = View::factory('course/assign')
            ->bind('data', $data)
            ->bind('count', $count)
            ->bind('cacheimage', $cacheimage)
            ->bind('user_ids', $user_ids);
        $teachers = Model_Role::get_users('teacher');
        $teachers_table = View::factory('course/teachers')
            ->bind('teachers', $teachers)
            ->bind('cacheimage', $cacheimage)
            ->bind('assigned_teachers', $selected); // same selected user_ids will work in c_ase of teachers
        $batches = ORM::factory('batch')->find_all();
        $view = View::factory('course/form')
            ->bind('form', $form)
            ->bind('users', $users)
            ->bind('teachers_table', $teachers_table)
            ->bind('batches', $batches)
            ->bind('course_id', $course_id);        
        
        Breadcrumbs::add(array(
            'Courses', Url::site('course')
        ));
        
        Breadcrumbs::add(array(
            'Create', Url::site('course/add')
        ));
        
        $this->content = $view;
    }
    
    private function form($action, $submitted = false, $saved_data = array()) {        
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'name' => '',
            'description' => '',
            'access_code' => '',
            'start_date'  => date('Y-m-d'),
            'end_date'    => '',
        );        
        $form->saved_data = $saved_data;
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Name', 'name', 'text');
        $form->append('Description', 'description', 'textarea', array('attributes' => array('cols' => 50, 'rows' => 5)));
        $form->append('Access code', 'access_code', 'text');
        $form->append('Start Date', 'start_date', 'text', array('attributes' => array('class' => 'date')));
        $form->append('End Date', 'end_date', 'text', array('attributes' => array('class' => 'date')));
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button r')));
        $form->process();
        return $form;
    }
    
    public function action_edit() {
        $submitted = false;        
        $id = $this->request->param('id');
        if (!$id) {
            Request::current()->redirect('course');
        }        
        $course = ORM::factory('course', $id);
        if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $validator = $course->validator($this->request->post());
                $validator->bind(':course', $course);
                $validator->bind(':start_date', $this->request->post('start_date'));
                if ($validator->check()) {
                    $course->name = $this->request->post('name');
                    $course->description = $this->request->post('description');
                    $course->access_code = $this->request->post('access_code');
                    $course->start_date = $this->request->post('start_date');
                    $course->end_date = $this->request->post('end_date');                    
                    $course->save();
                    Model_Course::assign_users($course, $this->request->post('selected'));                    
                    Request::current()->redirect('course');
                    exit;
                } else {
                    $this->_errors = $validator->errors('course');
                }
            }
        }
        $saved_data = array(
            'name' => $course->name, 
            'description' => $course->description, 
            'access_code' => $course->access_code, 
            'start_date' => $course->start_date, 
            'end_date' => $course->end_date
        );
        $form = $this->form('course/edit/id/'.$id ,$submitted, $saved_data);
        $data = Model_Course::get_students($course);
        $cacheimage = CacheImage::instance();
        $user_ids = $data->as_array(NULL, 'id');
        $count = $course->users->count_all();
        $users = View::factory('course/assign')
            ->bind('data', $data)
            ->bind('count', $count)
            ->bind('cacheimage', $cacheimage)
            ->bind('user_ids', $user_ids);
        $teachers = Model_Role::get_users('teacher');
        $assigned_teachers = Model_Course::get_teachers($course)->as_array(null, 'id');
        $teachers_table = View::factory('course/teachers')
            ->bind('teachers', $teachers)
            ->bind('cacheimage', $cacheimage)
            ->bind('assigned_teachers', $assigned_teachers);        
        $batches = ORM::factory('batch')->find_all();
        $view = View::factory('course/form')
            ->bind('form', $form)
            ->bind('users', $users)
            ->bind('batches', $batches)
            ->bind('teachers_table', $teachers_table)
            ->bind('course_id', $id);        
        
        Breadcrumbs::add(array(
            'Courses', Url::site('course')
        ));
        
        Breadcrumbs::add(array(
            $course->name, Url::site('course/edit/id/'.$id)
        ));
        
       $this->content = $view;
    }
    
    public function action_summary() {        
    	$id = $this->request->param('id');
    	if(!$id) {
            Request::current()->redirect('course');
        }        
    	$course = ORM::factory('course', $id);
        // Todo
    	$count_student = ORM::factory('course', $id)->users->count_all();    	
    	$count_exam = ORM::factory('exam');
    	$count_exam = $count_exam->where('course_id', '=', $id)->count_all();    	
    	$count = array(
            'count_student' => $count_student,
            'count_exam' => $count_exam,
        );
        $feeds = Request::factory('feed/feeds/id/'.$id)
            ->method(Request::GET)
            ->execute()
            ->body();
        $data = array();
        $data['course_id'] = $id;
        $total_feeds = Model_Feed::get_total_feeds($data);
    	$view = View::factory('course/summary')
    	               ->bind('course', $course)
    	               ->bind('feeds', $feeds)
    	               ->bind('total_feeds', $total_feeds)
    	               ->bind('count', $count);    	
        

        Breadcrumbs::add(array(
            'Courses', Url::site('course')
        ));
        
        Breadcrumbs::add(array(
            $course->name, Url::site('course/summary/id/'.$id)
        ));
        
        $this->content = $view;
    }
    
    public function action_get_users() {
        $course_id = $this->request->post('course_id');
        $batch_id = $this->request->post('batch_id');
        $course_users = Model_Course::get_students($course_id)->as_array(NULL, 'id');
        $batch_users = Model_Batch::get_students($batch_id)->as_array(NULL, 'id');
        $user_ids = array_unique(array_merge($course_users, $batch_users));        
        if($user_ids){
            $data = ORM::factory('user')->where('id', 'IN', $user_ids )->find_all();
            $count = ORM::factory('user')->where('id', 'IN', $user_ids )->count_all();
        } else {
            $data = ORM::factory('user')->where('id', '=', 0 )->find_all();
            $count = ORM::factory('user')->where('id', '=', 0 )->count_all();
        }
        $cacheimage = CacheImage::instance();        
        $view = View::factory('course/assign')
            ->bind('data', $data)
            ->bind('count', $count)
            ->bind('cacheimage', $cacheimage)
            ->bind('user_ids', $course_users);
        $response = $this->response->body($view)->body();
    	echo json_encode(array('response' => $response));
    }
    
    public function action_join() {        
    	if($this->request->method() === 'POST' && $this->request->post()){
            $access_code = $this->request->post('access_code');            
            if($access_code){
            	$course = ORM::factory('course')->where('access_code' , '=' , $access_code)->find();
            	$user = Auth::instance()->get_user();
            	$user->add('courses', $course);
            	$json = array('response' => 'You are joined in ' . $course->name . ' course.');                
            } else {
            	$json = array('response' => 'Please enter access code.');
            }            
            echo json_encode($json);
            exit;
    	}        
    	$view = View::factory('course/join');        
        
    	Breadcrumbs::add(array(
            'Courses', Url::site('course')
        ));
        
        Breadcrumbs::add(array(
            'Join', Url::site('course/join')
        ));
        
    	$this->content = $view;
    }
    
    public function action_course_detail(){        
    	$access_code = $this->request->post('access_code');        
    	if ($access_code) {
            $course = ORM::factory('course')->where('access_code' , '=' , $access_code)->find();
            if ($course->id !== NULL) {                
                $user = Auth::instance()->get_user();
                if ($user->has('courses', $course)) {
                    $json = array('response' => 'You are Already in this Course.');
                } else {
                    $html = '<table class="formcontainer">';
                    $html .= '<tr><td>Course Name:</td><td>' . $course->name . '</td>';
                    $html .= '<tr><td>Start Date:</td><td>' . $course->start_date . '</td>';
                    $html .= '<tr><td>End Date:</td><td>' . $course->end_date . '</td>';
                    $html .= '<tr><td></td><td><a class="button" id="join_course">Join</a>';
                    $json = array('response' => $html);
                }                
            } else {
                $json = array('response' => 'No course found for this access code');
            }            
    	} else {
            $json = array('response' => 'Please enter access code.');
    	}
    	echo json_encode($json);
    }
    
    public function action_get_students(){
    	
    	if(!$this->request->post('course_id')){
	    	$response = '<p>No Course Selected</p>';
	        echo json_encode(array('html' => $response));
	        exit;
    	}
        $course = ORM::factory('course', $this->request->post('course_id'));
        
    	$users = Model_Course::get_students($course);

        $cacheimage = CacheImage::instance();
            	
    	$view = View::factory('course/ajax_show_students')
    	               ->bind('cacheimage', $cacheimage)
    	               ->bind('course', $course)
    	               ->bind('users', $users);
    	
        $response = $this->response->body($view)->body();
        echo json_encode(array('html' => $response));
    }
    
}    

