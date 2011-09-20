<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Document extends Controller_Base {
	
	private $_errors = array();
	
    public function action_index() {
    	
		$course_id = Session::instance()->get('course_id');
    	
		$course = ORM::factory('course', $course_id);
		
		$role = Auth::instance()->get_user()->role();
		
		$criteria = array('course' => $course, 'role' => $role);
		
		$documents = Model_Document::documents($criteria); //ORM::factory('document')->find_all();
        
        $view = View::factory('document/list')
            ->set('page_title', 'Documents Manager')
            ->bind('documents', $documents);
        
        $this->content = $view;
        
        Breadcrumbs::add(array(
            'Courses', Url::site('course')
        ));
        
        Breadcrumbs::add(array(
            'Documents', Url::site('document')
        ));
        
    }
    
    public function action_download(){
    	
    	$id = $this->request->param('id');
    	
    	$document = ORM::factory('document', $id);
    	$path = UPLOAD_PATH;
    	
    	$filename =  $path . $document->name;
    	
    	if((!file_exists($filename)) || (file_exists($filename) && is_dir($filename))){
    		Request::current()->redirect('error/not_found');
    	}

    	if(!$document->is_allowed()){
    		Request::current()->redirect('error/access_denied');
    	}
    	 
    	header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Type: " . File::mime($filename));
		header("Content-Disposition: attachment; filename=" . basename($filename));
		header("Content-Transfer-Encoding: binary");
		readfile($filename);
		exit;
    }
    
    public function action_upload(){
    	
    	$submitted = FALSE;
        if ($this->request->method() === 'POST' && $this->request->post()) {
            if (Arr::get($this->request->post(), 'save') !== null) {
            	$submitted = TRUE;
            	$document = ORM::factory('document');
            	$validator = $document->validator(array_merge($this->request->post(), $_FILES));
            	$validator->bind(':files', $_FILES['name']);
            	if($validator->check()){
            		
            		$filename = Upload::save($_FILES['name'], NULL, UPLOAD_PATH);
            		
            		$document = ORM::factory('document');
            		
            		$document->values($this->request->post());
            		
            		$document->name = basename($filename);
            		
            		$document->time = time();
            		
            		$document->save();
            		
            		$document->add('courses', $this->request->post('course_id'));
            		
            		$document->add('roles', $this->request->post('role'));
            		
            		Request::current()->redirect('document');
            		
            	} else {
            		$this->_errors = $validator->errors('document');
            	}
            }
        }
        
        $courses = Model_Course::courses()->as_array('id', 'name');
        
    	$course_id = Session::instance()->get('course_id');
        //remove the current course from the list
        unset($courses[$course_id]);
        
    	$form = new Stickyform('document/upload', array('enctype'=>"multipart/form-data"), ($submitted ? $this->_errors : array()));
    	
    	$form->default_data = array(
    		'title'		=> '',
    		'user_id'	=> Auth::instance()->get_user()->id,
    		'course_id'	=> 0,
    		'role'		=> 0
    	);
    	
    	$form->posted_data = $submitted ? $this->request->post() : array();
    	
    	$form->append('Title', 'title', 'text');
    	$form->append('Access To', 'role', 'text');
    	$form->append('User', 'user_id', 'hidden');
    	$form->append('File', 'name', 'file');
    	$form->append('Also add to', 'course_id', 'select', array('options' => $courses, 'attributes' => array('multiple' => 'multiple', 'name' => 'course_id[]')));
    	$form->append('Upload', 'save', 'submit', array('attributes' => array('class' => 'button')));
    	
        $form->process();    	
    	
    	$course = ORM::factory('course', $course_id);
    	
    	$roles = ORM::factory('role')->find_all()->as_array('id', 'name');

    	$view = View::factory('document/form')
    					->bind('form', $form)
    					->bind('course', $course)
    					->bind('roles', $roles);
    	
        Breadcrumbs::add(array(
            'Courses', Url::site('course')
        ));
        
        Breadcrumbs::add(array(
            'Documents', Url::site('document')
        ));
    					
        Breadcrumbs::add(array(
            'Upload', Url::site('document/upload')
        ));
    					
        $this->content = $view;
    }
    
    public function action_delete() {
    	
    	$id = $this->request->param('id');
    	
    	if(Acl::instance()->is_allowed('document_delete')){
    		
    		ORM::factory('document', $id)->delete();
    		
    		$json = array(
    			'success'	=> 1,
    			'msg'	=> array('Document is deleted successfully')
    		);
    	} else {
    		$json = array(
    			'success'	=> 0,
    			'reason'	=> 'access_denied'
    		);
    	}
    	
    	echo json_encode($json);
    	exit;
    }
    
    public function action_edit() {
    	
        if($this->request->method() === 'POST' && $this->request->post()){
            $document = ORM::factory('document', $this->request->post('document_id'));
            $validator = $document->validator($this->request->post(), FALSE);
            
            if ($validator->check()) {
                
            	$document->title = $this->request->post('title');
                
            	$document->remove('roles');
                $document->add('roles', $this->request->post('role'));
                
                $document->save();
                
                $json = array(
                    'success'   => 1,
                    'msg'   => array('Document is edited successfully')
            	);
            } else {
            	$json = array(
                    'success'   => 0,
                    'errors'    => array_values($validator->errors('document'))
            	);
                
            }
            echo json_encode($json);
            exit;
        }
    	
        $id = $this->request->param('id');
    	
    	$document = ORM::factory('document', $id);
    	
    	$title = $document->title;
    	
    	$roles_access = $document->roles->find_all()->as_array(Null, 'id');
    	
    	$roles = ORM::factory('role')->find_all()->as_array('id', 'name');
    	
    	$view = View::factory('document/edit')
    					->bind('title', $title)
    					->bind('roles', $roles)
    					->bind('id', $id)
    					->bind('roles_access', $roles_access);
    	
    	echo json_encode(array(
            'success' => 1,
            'html' => $view->render(),
        ));
        exit;
    }
}
