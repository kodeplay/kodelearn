<?php defined('SYSPATH') or die('No direct script access.');

include(DOCROOT.'vendor/simple_html_dom.php');

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
    	    $link = "";
    	    $link_share = $this->request->post('link_share');
            
    	    if($link_share == '1') {
                $link = 'link';
            }
            
    	    $video_share = $this->request->post('video_share');
            
            if($video_share == '1') {
                $link = 'video';
            }
            
    	    $post = ORM::factory('post');            
            $post->message = $this->request->post('post');
            $post->link = $link;
            $post->user_id = Auth::instance()->get_user()->id;
            $post->save();
            if($link_share == '1') {
                $query = DB::insert('post_meta', array('post_id' ,'key', 'value'));
                $query->values(array($post->id, 'image', $this->request->post('post_img')), 
                               array($post->id, 'title', $this->request->post('post_title')),
                               array($post->id, 'text', $this->request->post('post_text')),
                               array($post->id, 'link', $this->request->post('post_link')));
                $query->execute();  
            }
    	    if($video_share == '1') {
                $code = $this->parse_youtube_url($this->request->post('post_link'));
    	        $query = DB::insert('post_meta', array('post_id' ,'key', 'value'));
                $query->values(array($post->id, 'code', $code), 
                               array($post->id, 'title', $this->request->post('post_title')),
                               array($post->id, 'text', $this->request->post('post_text')),
                               array($post->id, 'link', $this->request->post('post_link')));
                $query->execute();  
            }
            
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
    
    public function action_deletecomment() {
        $id = $this->request->param('id');
        ORM::factory('feedcomment', $id)->delete();
        
    }
    
    public function action_dataFromLink() {
        $orig = $this->request->post('post');
        
        $urlregex = '~(?:https?)://[a-z0-9+$_-]+(?:\\.[a-z0-9+$_-]+)*' .
            '(?:/(?:[a-z0-9+$_-]\\.?)+)*/?(?:\\?[a-z+&$_.-][a-z0-9;:@/&%=+$_.-]*)?'.
            '(?:#[a-z_.-][a-z0-9+$_.-]*)?~i';
        if (preg_match($urlregex, $orig, $matches)) {
            $html = file_get_html($matches[0]);
            
        } else { //no array found
            die("oops");
        }
        
        $youtube = substr($matches[0], 0, 15); // returns "d"
        if($youtube == "http://www.yout" || $youtube == "http://youtu.be") {
            $img_j = $this->parse_youtube_url($matches[0],'thumb');
            
            $title_text = array();
            foreach($html->find('title') as $title) { 
                   $title_text[] = $title->plaintext;
            }
            $title_j = "";
            
            if($title_text) {
                $title_j = $title_text[0];
            }
            
            $description = $html->find('p[id=eow-description]', 0)->plaintext;
            $description = substr($description, 0, 255);
            $json = array(
            'img' => $img_j,
            'title' => $title_j,
            'text'=> $description,
            'link' => $matches[0],
            'error' => 0,
            'video_share' => 1
            );
            echo  json_encode($json);
            exit;
        }
        
        
        if($html) {
            $temp = array();
            // Find all images 
            foreach($html->find('img') as $element) { 
                   $temp[] = $element->src;
            }
            $temp_text = array();
            foreach($html->find('p') as $text) { 
                   $temp_text[] = $text->plaintext;
            }
            $title_text = array();
            foreach($html->find('title') as $title) { 
                   $title_text[] = $title->plaintext;
            }
            
            $img_j = "";
            $text_j = "";
            $title_j = "";
            if($temp) {
                $img_j = $temp;
            }
            if($temp_text) {
                $text_j = $temp_text[0];
            }
            if($title_text) {
                $title_j = $title_text[0];
            }
            
            $json = array(
            'img' => $img_j,
            'text'=> $text_j,
            'title' => $title_j,
            'link' => $matches[0],
            'error' => 0,
            'link_share' => 1
            );
        
            
        } else {
            $json = array(
            'error' => 1
            );
        }
        
        echo  json_encode($json);
        exit;
        
        
    }
    
    public function parse_youtube_url($url,$return='',$width='',$height='',$rel=0){ 
        $urls = parse_url($url); 
         
        //expect url is http://youtu.be/abcd, where abcd is video iD
        if($urls['host'] == 'youtu.be'){  
            $id = ltrim($urls['path'],'/'); 
        } 
        //expect  url is http://www.youtube.com/embed/abcd 
        else if(strpos($urls['path'],'embed') == 1){  
            $id = end(explode('/',$urls['path'])); 
        } 
         //expect url is abcd only 
        else if(strpos($url,'/')===false){ 
            $id = $url; 
        } 
        //expect url is http://www.youtube.com/watch?v=abcd 
        else{ 
            parse_str($urls['query']); 
            $id = $v; 
        } 
        //return embed iframe 
        if($return == 'embed'){ 
            return '<iframe width="'.($width?$width:560).'" height="'.($height?$height:349).'" src="http://www.youtube.com/embed/'.$id.'?rel='.$rel.'" frameborder="0" allowfullscreen>'; 
        } 
        //return normal thumb 
        else if($return == 'thumb'){ 
            return 'http://i1.ytimg.com/vi/'.$id.'/default.jpg'; 
        } 
        //return hqthumb 
        else if($return == 'hqthumb'){ 
            return 'http://i1.ytimg.com/vi/'.$id.'/hqdefault.jpg'; 
        } 
        // else return id 
        else{ 
            return $id; 
        } 
    } 
    
}