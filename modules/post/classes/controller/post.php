<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Post extends Controller_Base {

    protected $_errors = array();
    
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

    	if($this->validate()){
            $post = ORM::factory('post');            
            $post->message = $this->request->post('post');
            $post->link = $this->request->post('link');
            $post->user_id = Auth::instance()->get_user()->id;
            $post->save();

            $course_id = Arr::get($this->request->post(), 'course', 0);
            $batch_id = Arr::get($this->request->post(),'batch', 0);
            $role_id = Arr::get($this->request->post(), 'selected_roles', 0); // yes, default 0 and not array; 0 = all roles

            $feed = new Feed_Post();        
            $feed->set_action('add');
            $feed->set_respective_id($post->id);
            $feed->set_course_id($course_id);
            $feed->set_actor_id(Auth::instance()->get_user()->id); 
            $stream_data = array(
                'course_id'     => $course_id,
                'batch_id'      => $batch_id,
                'role_id'       => $role_id,
            );
            $feed->streams($stream_data);
            $feed->save();
            
            $html = Request::factory('feed/feed/feed_id/'.$feed->get_id())
                ->method(Request::GET)
                ->execute()
                ->body();
            
            $json = array(
                'success'   => 1,
                'html'      => $html
            );
            
    	} else {
            $json = array(
                'success' => 0,
                'errors'  => $this->_errors
            );
    	}
        
    	echo  json_encode($json);
    	exit;
    }
    
    private function validate() {
        
    	if(($this->request->post('post_setting') == 'role') AND (!$this->request->post('selected_roles'))){
            $this->_errors[] = 'Please select atleast one role';
    	}
        
    	if($this->request->post('post') == ''){
            $this->_errors[] = 'Please enter some message';
    	}
        
    	if(!$this->_errors){
            return true;
    	} else {
            return false;
    	}
    }
    
    
    /* this function will delete the self posts
     * to delete others posts the function is below
     *  */
    
    public function action_selfDelete() {
        
        $id = $this->request->param('id');
        ORM::factory('post', $id)->delete();
        
        Model_Post::delPosts($id);
    }
    
    public function action_delete() {
        
        $id = $this->request->param('id');
        ORM::factory('post', $id)->delete();
        
        Model_Post::delPosts($id);
    }
    
    public function action_comment() {
        
        $feed_id = $this->request->post('id');
        $data = $this->request->post('data');
        $comment = ORM::factory('feedcomment');
        $comment->comment = $data;
        $comment->feed_id = $feed_id;
        $comment->date = strtotime(date('d-m-Y G:i:s'));
        $comment->user_id = Auth::instance()->get_user()->id;
        $comment->save();
        
        $image = CacheImage::instance();
        $curr_user = Auth::instance()->get_user();
        $curr_avatar = $image->resize($curr_user->avatar, 40, 40);
       
        $span = Date::fuzzy_span($comment->date);
        
        $json = array(
                'name'          => $curr_user->firstname." ".$curr_user->lastname, 
                'img'           => $curr_avatar,
                'text'          => Html::chars($comment->comment),
                'time'          => $span,
                'comment_id'    => $comment->id
            );

        echo  json_encode($json);
        exit;
        
    }
    
    public function action_selfdelete_comment() {
        $id = $this->request->param('id');
        ORM::factory('feedcomment', $id)->delete();
        
    }
    
    
}