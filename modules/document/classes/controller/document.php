<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Document extends Controller_Base {
	
	private $_errors = array();
	
    public function action_index() {
    	
    	$documents = ORM::factory('document')->find_all();
        
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

    	/**
    	 * Removed for demo
    	
    	if(!$document->is_allowed()){
    		Request::current()->redirect('error/access_denied');
    	}
    	 */
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
            		
            		Request::current()->redirect('document');
            		
            	} else {
            		$this->_errors = $validator->errors('document');
            	}
            }
        }
        
        $courses = Model_Course::courses()->as_array('id', 'name');
        
        $courses = array_merge(array('Global'), $courses);
        
    	$form = new Stickyform('document/upload', array('enctype'=>"multipart/form-data"), ($submitted ? $this->_errors : array()));
    	
    	$form->default_data = array(
    		'title'		=> '',
    		'user_id'	=> Auth::instance()->get_user()->id,
    		'course_id'	=> 0,
    	);
    	
    	$form->posted_data = $submitted ? $this->request->post() : array();
    	
    	$form->append('Title', 'title', 'text');
    	$form->append('User', 'user_id', 'hidden');
    	$form->append('File', 'name', 'file');
    	$form->append('Course', 'course_id', 'select', array('options' => $courses));
    	$form->append('Upload', 'save', 'submit', array('attributes' => array('class' => 'button')));
    	
        $form->process();    	
    	
    	$view = View::factory('document/form')
    					->bind('form', $form);
    	
    	$this->content = $view;
    }
}
