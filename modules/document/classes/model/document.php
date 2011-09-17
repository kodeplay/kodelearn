<?php defined('SYSPATH') or die('No direct script access.');

class Model_Document extends ORM {
	
    protected $_has_many = array(
        'roles' => array(
            'model'   => 'role',
            'through' => 'documents_roles',
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
	
	public function validator($data){
        return Validation::factory($data)
        	->rule('title', 'not_empty')
            ->rules(
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
}