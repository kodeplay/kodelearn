<?php defined('SYSPATH') or die('No direct script access.');

class Model_Document extends ORM {
	
    protected $_has_many = array(
        'roles' => array(
            'model'   => 'role',
            'through' => 'documents_roles',
        ),
        'courses' => array(
            'model'   => 'course',
            'through' => 'documents_courses',
        )
        );      
	
	public function toLink(){
		return HTML::anchor('document/download/id/'. $this->id, (string) $this->title);
	}
	
	public function toString() {
		return $this->title;
	}
	
	public function is_allowed() {
		$role = Auth::instance()->get_user()->role();

		return ($this->has('roles', $role));
    	
	}
	
	public function time() {
		return date('d-m-Y', ($this->time)? $this->time : time());
	}
	
	public function user() {
		$user = ORM::factory('user', $this->user_id);
		
		return $user->fullname();
	}
	
	public function validator($data, $validate_file = TRUE){
        $validator =  Validation::factory($data)
        	->rule('title', 'not_empty')
        	->rule('role', 'not_empty');
        	
            if($validate_file){
	        	$validator->rules(
	                'name',
	                array(
	                    array('Upload::not_empty', NULL),
	                    array('Upload::valid' , NULL),
	                    array('Upload::size', array(':value','5M')),
	                    array('Upload::type' , array(
	                        ':value',
	                        array('jpg', 'png', 'gif', 'jpeg', 'pdf', 'doc', 'odt', 'txt', 'xls', 'rtf', 'bmp', 'ppt', 'docx', 'pptx')
	                    )),
	                )
            	
	            );
            }
            
    	return $validator;
	}
	
	public static function documents(array $data = array()){
		
		if($data){
			$document = ORM::factory('document')
							->join('documents_courses')
							->on('documents.id', '=', 'documents_courses.document_id')
							->join('documents_roles')
							->on('documents.id', '=', 'documents_roles.document_id');
			
			if(isset($data['course'])){
				$course = $data['course'] instanceof Model_Course ? $data['course'] : ORM::factory('course', (int)$data['course']);
				$document->where('documents_courses.course_id', '=', $course->id); 
			}
			
			if(isset($data['role'])){
				$role = $data['role'] instanceof Model_Role ? $data['role'] : ORM::factory('role', (int)$data['role']);
				$document->where('documents_roles.role_id', '=', $role->id); 
			}
			
			$document->group_by('documents.id');
			
			return $document->find_all();
			
		} else {
			return ORM::factory('document')->find_all();
		}
		
	}
	
	public function extension() {
		$path_parts = pathinfo($this->name);

		return $path_parts['extension'];
	
	}
	
	public function deleteLink() {
		
		if (Acl::instance()->is_allowed('document_delete')) {
			return '[<a href="#" onclick="KODELEARN.modules.get(\'document\').del(' . $this->id . ')"> Delete </a>]'; //send link if permission is there
		}
		
		return '';
		
	} 
	
	public function editLink() {

		if (Acl::instance()->is_allowed('document_edit')) {
			return '[<a href="#" onclick="KODELEARN.modules.get(\'document\').edit(' . $this->id . ')"> Edit </a>]'; //send link if permission is there
		}
		
		return '';
	}
	
}