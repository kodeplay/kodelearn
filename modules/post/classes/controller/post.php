<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Post extends Controller_Base {

    /**
     * Action to display the form for adding posts
     */
    public function action_form() {
        $view = View::factory('post/form')
            ->bind('visibility_options', $visibility_options)
            ->bind('roles', $roles)
            ->bind('courses', $courses)
            ->bind('batches', $batches);            
        $visibility_options = array(
            'everyone' => __('Everyone'),
            'batch' => __('Only a specific Batch'),
            'course' => __('Only a specific Course'),
            'role'  => __('Only some roles'),
        );
        $roles = ORM::factory('role')->find_all()->as_array('id', 'name');
        $batches = ORM::factory('batch')->find_all()->as_array('id', 'name');
        $courses = ORM::factory('course')->find_all()->as_array('id', 'name');
        $this->content = $view;
    }

    /**
     * Action for adding the post to database
     */
    public function action_add() {
    	
    	$post = ORM::factory('post');
    	
    	$post->message = $this->request->post('message');
    	$post->link = $this->request->post('link');
    	$post->user_id = Auth::instance()->get_user()->id;
    	$post->save();
    	
    	$data = array(
            'course_id' => $this->request->post('course_id'),
            'batch_id' => $this->request->post('batch_id'),
            'role_id' => $this->request->post('role_id'),
    	    'post_id' => $post->id
    	);
    	
    	$this->add_feed($data);

    	exit;
    }
    
    private function add_feed($data){
    	
        $feed = new Feed_Post();
        

        $feed->set_action('add');
        $feed->set_respective_id($data['post_id']);
        $feed->set_actor_id(Auth::instance()->get_user()->id); 
        $feed->save();
    	
        if($data['course_id']){
        	
        	$course = ORM::factory('course', $data['course_id']);
        	
        	$users = Model_Course::get_users($course, ORM::factory('role', $data['role_id'])->name);
        	
	        $feed->set_course_id($this->request->post('course_id'));
	        $feed->subscribe_users($users);
    		
    	} else if ($data['batch_id']) {
    		$users = Model_Course::get_users($data['batch_id'], ORM::factory('role', $data['role_id'])->name);
            
            $feed->subscribe_users($users);
    	} else {
    		if($data['role_id'] == 0){
    			$users = ORM::factory('user')->find_all();
    		} else {
    			$users = Model_Role::get_users(ORM::factory('role', $data['role_id'])->name);
    		}
    		$feed->subscribe_users($users);
    	}
    }
}