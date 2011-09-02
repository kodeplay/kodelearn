<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Controller_Base {
    
    private $error;
    private $success = '';
    
    public function action_index() {        
        
        if($this->request->param('sort')){
            $sort = $this->request->param('sort');
        } else {
            $sort = 'id';
        }
        
        if($this->request->param('order')){
            $order = $this->request->param('order');
        } else {
            $order = 'DESC';
        }
        
        $user = ORM::factory('user');

        if($this->request->param('filter_name')){
            $user->and_where_open()
                 ->where('users.firstname', 'LIKE', '%' . $this->request->param('filter_name') . '%')
                 ->or_where('users.lastname', 'LIKE', '%' . $this->request->param('filter_name') . '%')
                 ->and_where_close();
        }
        
        if($this->request->param('filter_id')){
            $user->where('users.id', '=', (int) $this->request->param('filter_id') );
        }
        
        $count = $user->count_all();
        
        $pagination = Pagination::factory(array(
            'total_items'    => $count,
            'items_per_page' => 50,
        ));
        
        if($this->request->param('filter_name')){
            $user->and_where_open()
                 ->where('users.firstname', 'LIKE', '%' . $this->request->param('filter_name') . '%')
                 ->or_where('users.lastname', 'LIKE', '%' . $this->request->param('filter_name') . '%')
                 ->and_where_close();
        }
        
        if($this->request->param('filter_id')){
            $user->where('users.id', '=', (int) $this->request->param('filter_id') );
        }
        
        $users = $user->order_by($sort, $order)
            ->limit($pagination->items_per_page)
            ->offset($pagination->offset)
            ->find_all();
        
        $sorting = new Sort(array(
            'Roll No'           => 'id',
            'Name'              => array('sort' => 'firstname', 'attributes' => array('width' => 330)),
            'Batch'             => array('sort' => '', 'attributes' => array('width' => 140)),
            'Courses'           => array('sort' => '', 'attributes' => array('width' => 140)),
            'Actions'           => ''
        ));
        
        $url = ('user/index');
        
        if($this->request->param('filter_name')){
            $url .= '/filter_name/'.$this->request->param('filter_name');
        }
        
        if($this->request->param('filter_id')){
            $url .= '/filter_id/'.$this->request->param('filter_id');
        }
        
        $sorting->set_link($url);
        
        $sorting->set_order($order);
        $sorting->set_sort($sort);
        $heading = $sorting->render();
        
        $pagination = $pagination->render();
        
        $links = array(
            'add'       => Html::anchor('/user/add/', 'Create a user', array('class' => 'createButton l')),
            'uploadcsv' => Html::anchor('/user/uploadcsv/', 'Upload CSV', array('class' => 'pageAction l')),
            'roles'     => Html::anchor('/role/', 'Manage Roles', array('class' => 'pageAction 1')),
            'delete'    => URL::site('/user/delete/')
        );
        
        $table['heading'] = $heading;
        $table['data'] = $users;
        
        $filter_name = $this->request->param('filter_name');
        $filter_url = URL::site('user/index');
        $cacheimage = CacheImage::instance();
        
       
        $view = View::factory('user/list')
            ->bind('table', $table)
            ->bind('users', $users)
            ->bind('count', $count)
            ->bind('links', $links)
            ->bind('pagination', $pagination)
            ->bind('filter_name', $filter_name)
            ->bind('filter_id', $filter_id)
            ->bind('filter_url', $filter_url)
            ->bind('cacheimage', $cacheimage)
            ;
        
        Breadcrumbs::add(array(
            'User', Url::site('user')
        ));
            
        $this->content = $view;
    }
    
    public function action_add(){
        $submitted = false;
        
        if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $user = ORM::factory('user');
                $validator = $user->validator_create($this->request->post());
                $validator->bind(':user', NULL);
                if($validator->check()) {
                    $user->firstname = $this->request->post('firstname');
                    $user->lastname = $this->request->post('lastname');
                    $user->email = $this->request->post('email');
                    $password = rand(10000, 65000);
                    $user->password = Auth::instance()->hash($password);
                    $user->status = $this->request->post('status');
                    $role = ORM::factory('role', $this->request->post('role_id'));
                    $user->save();
                    $user->add('roles', $role);
                    
                    if($this->request->post('batch_id')){
                        $feed = new Feed_Batch();
                        foreach($this->request->post('batch_id') as $batch_id){
                            $batch = ORM::factory('batch', $batch_id);
                            $user->add('batches', $batch);
                            $feed->set_action('add');
                            $feed->set_course_id('0');
                            $feed->set_respective_id($batch_id);
                            $feed->set_actor_id(Auth::instance()->get_user()->id); 
                            $feed->save();
                            $feed->subscribe_users(array('0' => $user->id));
                        }
                    }
                    
                    if($this->request->post('course_id')){
                        $feed = new Feed_Course();
                        foreach($this->request->post('course_id') as $course_id){
                            $course = ORM::factory('course', $course_id);
                            $user->add('courses', $course);
                            $feed->set_action('student_add');
                            $feed->set_course_id('0');
                            $feed->set_respective_id($course_id);
                            $feed->set_actor_id(Auth::instance()->get_user()->id); 
                            $feed->save();
                            $feed->subscribe_users(array('0' => $user->id));
                        }
                    }
                    self::notify_by_email($user, $password);
                    Request::current()->redirect('user');
                    exit;
                } else {
                    $this->_errors = $validator->errors('register');
                }
            }
        }
        
        $form = $this->form('user/add', $submitted);
        
        
        $view = View::factory('user/form')
            ->bind('form', $form)
            ->set('page_title', 'Create a new user');
        Breadcrumbs::add(array(
            'User', Url::site('user')
        ));
        Breadcrumbs::add(array(
            'Create', Url::site('user/add')
        ));    
        $this->content = $view;
    }
    
    private function form($action, $submitted = false, $saved_data = array()) {
        
        $roles = array();
        foreach(ORM::factory('role')->find_all() as $role){
            $roles[$role->id] = $role->name;
        }

        $batches = array();
        foreach(ORM::factory('batch')->find_all() as $batch){
            $batches[$batch->id] = $batch->name;
        }
        
        $courses = array();
        foreach(ORM::factory('course')->find_all() as $course) {
            $courses[$course->id] = $course->name;
        }
        
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'firstname' => '',
            'lastname'  => '',
            'email'     => '',
            'role_id'   => '',
            'batch_id'  => '',
            'course_id' => '',
            'status'    => 0,
        );        
        $form->saved_data = $saved_data;
        // var_dump($saved_data); exit;
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('First Name', 'firstname', 'text');
        $form->append('Last Name', 'lastname', 'text');
        $form->append('Email', 'email', 'text');
        $form->append('Role', 'role_id', 'select', array('options' => $roles));
        $form->append('Select batch', 'batch_id', 'select', array('options' => $batches, 'attributes' => array('multiple' => 'multiple', 'name' => 'batch_id[]')));
        $form->append('Select Course', 'course_id', 'select', array('options' => $courses, 'attributes' => array('multiple' => 'multiple', 'name' => 'course_id[]')));
        $form->append('User Status', 'status', 'select', array(
            'options' => array(
                1 => 'Approved',
                0 => 'Unapproved/Banned',
            ),         
        ));
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        return $form;
    }
    
    public function action_edit() {
        $submitted = false;
        
        $id = $this->request->param('id');
        if (!$id) {
            Request::current()->redirect('user');
        }
        
        $user = ORM::factory('user', $id);

        if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $validator = $user->validator_create($this->request->post());
                $validator->bind(':user', $user);
                if ($validator->check()) {
                    $user->firstname = $this->request->post('firstname');
                    $user->lastname = $this->request->post('lastname');
                    $user->email = $this->request->post('email');
                    $user->status = $this->request->post('status');
                    //removing the previous role assigned
                    $user->remove('roles');
                    //creating a role object and assigning a new role
                    $role = ORM::factory('role', $this->request->post('role_id'));
                    $user->add('roles', $role);
                    
                    //removing the previous batches assigned
                    $user->remove('batches');
                    if($this->request->post('batch_id')){
                        $feed = new Feed_Batch();
                        foreach($this->request->post('batch_id') as $batch_id){
                            $batch = ORM::factory('batch', $batch_id);
                            $user->add('batches', $batch);
                            $feed_exist = ORM::factory('feed');
                            $feed_exist->join('feeds_users','left')
                                             ->on('feeds_users.feed_id','=','feeds.id')
                                             ->where('feeds.type','=','batch')
                                             ->where('feeds.respective_id','=',$batch_id)
                                             ->where('feeds_users.user_id','=',$user->id);
                            $feed_exists = $feed_exist->find();
                            if(!$feed_exists->id){
                                $feed->set_action('add');
                                $feed->set_course_id('0');
                                $feed->set_respective_id($batch_id);
                                $feed->set_actor_id(Auth::instance()->get_user()->id); 
                                $feed->save();
                                $feed->subscribe_users(array('0' => $user->id));       
                            }
                               
                        }
                    }
                    //removing the previous courses assigned
                    $user->remove('courses');
                    if($this->request->post('course_id')){
                        $feed = new Feed_Course();
                        foreach($this->request->post('course_id') as $course_id){
                            $course = ORM::factory('course', $course_id);
                            $user->add('courses', $course);
                            $feed_exist = ORM::factory('feed');
                            $feed_exist->join('feeds_users','left')
                                             ->on('feeds_users.feed_id','=','feeds.id')
                                             ->where('feeds.type','=','course')
                                             ->where('feeds.respective_id','=',$course_id)
                                             ->where('feeds_users.user_id','=',$user->id);
                            $feed_exists = $feed_exist->find();
                            if(!$feed_exists->id){
                                $feed->set_action('student_add');
                                $feed->set_course_id('0');
                                $feed->set_respective_id($course_id);
                                $feed->set_actor_id(Auth::instance()->get_user()->id); 
                                $feed->save();
                                $feed->subscribe_users(array('0' => $user->id));       
                            }
                        }
                    }
                    
                    $user->save();
                    Request::current()->redirect('user');
                    exit;
                } else {
                    $this->_errors = $validator->errors('register');
                }
            }
        }
        
        $form = $this->form('user/edit/id/'.$id ,$submitted, array(
            'firstname' => $user->firstname, 
            'lastname' => $user->lastname, 
            'email' => $user->email, 
            'role_id' => $user->roles->find()->id, 
            'batch_id' => $user->batches->find_all()->as_array(NULL, 'id'), 
            'course_id' => $user->courses->find_all()->as_array(NULL, 'id'),
            'status' => (int) $user->status,
        ));        
        //$heading[] = "View/Edit ".$user->firstname."'s Profile";        
        
        $view = View::factory('user/form')
            ->bind('form', $form)
            ->set('page_title', sprintf('View/Edit %s\'s profile', $user->fullname()));
        Breadcrumbs::add(array(
            'User', Url::site('user')
        ));
        Breadcrumbs::add(array(
            'Edit', Url::site('user/edit/id/'.$id)
        ));    
        $this->content = $view;
    }

    public function action_delete(){
        if($this->request->method() === 'POST' && $this->request->post('selected')){
            foreach($this->request->post('selected') as $user_id){
                ORM::factory('user', $user_id)->delete();
            }
        }
        Request::current()->redirect('user');
    }
    
    public function action_uploadcsv(){

        if($this->request->method() === 'POST' && $this->request->post()){
            
            if (Arr::get($this->request->post(), 'save') !== null){
               
                $filename = $_FILES['csv']['name'];
                $extension = explode(".",$filename);
                if(isset($extension[1]) && strtolower($extension[1]) === "csv"){ //Validation of file 
                     
                    $filename = $_FILES['csv']['tmp_name'];
                    $handle = fopen($filename, "r");
                    
                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE){
                        $filedata[] = $data;
                    }

                    unset($filedata[0]);

                    $records_added = 0;
                    $error = 0;
                    
                    $user_id = array();
                    foreach($filedata as $key => $row){
                    	$data = array(
                            'firstname' => isset($row[0]) ? $row[0] : '',
                            'lastname'  => isset($row[1]) ? $row[1] : '',
                    	    'email'     => isset($row[2]) ? $row[2] : '',
                    	);
                        
                    	$user = ORM::factory('user');
                        $validator = $user->validator_create($data);
                        $validator->bind(':user', NULL);
                        if ($validator->check()) {
                            //add user
                            $user->firstname = $data['firstname'];
                            $user->lastname = $data['lastname'];
                            $user->email = $data['email'];
                            $password = rand(10000, 65000);
                            $user->password = Auth::instance()->hash($password);
                            $role = ORM::factory('role', $this->request->post('role_id'));
                            $user->save();
                            $user->add('roles', $role);
                            $user_id[] = $user->id;
                             
                            if(($this->request->post('batch_id'))){
                                foreach($this->request->post('batch_id') as $batch_id){
                                    $batch = ORM::factory('batch', $batch_id);
                                    $user->add('batches', $batch);
                                }
                            }
                            // send email
                            self::notify_by_email($user, $password);
                            $records_added += 1;	
                        } else {
                            $this->error['warning'] = "There was an error on line # " . $key . " Records Added " . $records_added;
                            $this->error['description'] = implode('<br/>',$validator->errors('register'));
                            $error = 1;
                            break;
                        }
                    }
                    
                    
                    if(!$error){
                        $this->success = "Users uploaded successfully. Records Added " . $records_added ;
                        $feed = new Feed_Batch();
                        if(($this->request->post('batch_id'))){
                            foreach($this->request->post('batch_id') as $batch_id){
                                $feed->set_action('add');
                                $feed->set_course_id('0');
                                $feed->set_respective_id($batch_id);
                                $feed->set_actor_id(Auth::instance()->get_user()->id); 
                                $feed->save();
                                $feed->subscribe_users($user_id);
                            }
                        }
                    }
                    
                    fclose($handle);
                } else {
                    $this->error['warning'] = "The file you uploaded is not a valid csv file";
                    $this->error['description'] = ""; 
                }
            }
        }
        
    	$roles = array();
        foreach(ORM::factory('role')->find_all() as $role){
            $roles[$role->id] = $role->name;
        }

        $batches = array();
        foreach(ORM::factory('batch')->find_all() as $batch){
            $batches[$batch->id] = $batch->name;
        }
        
        $form = new Stickyform('user/uploadcsv', array('enctype' => 'multipart/form-data'), array());
        $form->default_data = array(
            'role_id'   => '',
            'batch_id'  => $this->request->param('batch_id', array())
        );
        
        $form->saved_data = array();
        $form->posted_data =  array();
        $form->append('Role', 'role_id', 'select', array('options' => $roles));
        $form->append('Select batch', 'batch_id', 'select', array('options' => $batches, 'attributes' => array('multiple' => 'multiple', 'name' => 'batch_id[]')));
        $form->append('Upload', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        
        $links = array(
            'sample'    => Html::anchor('/users_sample.csv', 'or click here to download a sample CSV file')
        );
        
    	$view = View::factory('user/uploadcsv')
            ->bind('form', $form)
            ->bind('error', $this->error)
            ->bind('success', $this->success)
            ->bind('links', $links)
            ;
        Breadcrumbs::add(array(
            'User', Url::site('user')
        ));
        Breadcrumbs::add(array(
            'Upload csv', Url::site('user/uploadcsv')
        ));
    	$this->content = $view;
        
    }

    private static function notify_by_email($user, $password) {
        $subject = "Your Kodelearn Account Details";
        $message = "Dear {name}, <br/>
                    Your account has been created on Kodelearn successfully.<br/>
                    Please use the following details to login to your account <br/> <br/>
                    Email: {email}, <br/>
                    Password: {password} <br/> <br/>
                    Best Regards, <br/>
                    Kodelearn Team.";
        $search = array('{name}', '{email}', '{password}');
        $replace = array($user->firstname . ' ' . $user->lastname, $user->email, $password);
        $message = str_replace($search, $replace, $message);
        $html = true;
        Email::send_mail($user->email, $subject, $message, $html);
    }    
}
