<?php defined('SYSPATH') or die('No direct script access.');

include(DOCROOT.'vendor/simple_html_dom.php');

class Controller_Link extends Controller_Base {
	
    protected $_errors = array();

    protected function breadcrumbs() {
        parent::breadcrumbs();
        $course = ORM::factory('course', Session::instance()->get('course_id'));
        if (!$this->request->is_ajax() && $this->request->is_initial()) {
            Breadcrumbs::add(array('Courses', Url::site('course')));
            Breadcrumbs::add(array(sprintf($course->name), Url::site('course/summary/id/'.$course->id)));        
            Breadcrumbs::add(array('Link', Url::site('link')));
        }
    }
    
    public function action_index() {
        $sort = $this->request->param('sort', 'title');        
        $order = $this->request->param('order', 'ASC');
        
        //Session::instance()->delete('course_id');    
        
        $criteria = array(
            'filters' => array(
                'title' => $this->request->param('filter_title'),
                'description' => $this->request->param('filter_description'),
            ),
        );
        
        $total = Model_Link::link_total($criteria);
         
        $pagination = Pagination::factory(array(
            'total_items'    => $total,
            'items_per_page' => 5,
        ));
       
        $criteria = array_merge($criteria, array(
            'sort' => $sort,
            'order' => $order,
            'limit' => $pagination->items_per_page,
            'offset' => $pagination->offset            
        ));
        
        $links = Model_Link::links($criteria);
       
        $sorting = new Sort(array(
            'Title'            => 'title',
            'Description'       => 'description',
            'No Of Questions'   => '',
            'Actions'           => '',
        ));
        
        $url = ('link/index');
        
        if($this->request->param('filter_title')){
            $url .= '/filter_title/'.$this->request->param('filter_title');
            $filter = $this->request->param('filter_title');
            $filter_select = 'filter_title';
        }
        
        if($this->request->param('filter_description')){
            $url .= '/filter_description/'.$this->request->param('filter_description');
            $filter = $this->request->param('filter_description');
            $filter_select = 'filter_description';
        }
        
        $sorting->set_link($url);        
        $sorting->set_order($order);
        $sorting->set_sort($sort);
        $heading = $sorting->render();
        
        // Render the pagination links
        $pagination = $pagination->render();
        
        $links_old = array(
            'delete'      => URL::site('/link/delete/'),
            'edit'        => URL::site('/link/edit/')  
        );
        
        $table = array('data' => $links);
        
        $filter_title = $this->request->param('filter_title');
        $filter_description = $this->request->param('filter_description');
        
        $filter_url = URL::site('link/index');        
        
        $success = Session::instance()->get('success');
        Session::instance()->delete('success');        
        
        $view = View::factory('link/list')
            ->bind('table', $table)
            ->bind('count', $total)
            ->bind('links_old', $links_old)
            ->bind('pagination', $pagination)
            ->bind('filter', $filter)
            ->bind('filter_select', $filter_select)
            ->bind('filter_url', $filter_url)
            ->bind('success', $success)
            ;
        
        $this->content = $view;
        
    }
    
    public function action_add() {
        
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $link = ORM::factory('link');
            $safepost = Arr::map('Security::xss_clean', $this->request->post());
            
                $link->title = $this->request->post('title');
                $link->description = $this->request->post('description');
                $link->image = $this->request->post('image');
                $link->url  = $this->request->post('url');
                $link->course_id = Session::instance()->get('course_id');
                
                $link->save();
                
                echo $link->id;
                /*
                $feed = new Feed_Link();
                
                $feed->set_action('add');
                $feed->set_course_id(Session::instance()->get('course_id'));
                $feed->set_respective_id($link->id);
                $feed->set_actor_id(Auth::instance()->get_user()->id); 
                $feed->streams(array(
                    'course_id' => (int)Session::instance()->get('course_id'),                        
                ));
                $feed->save();
                */
                exit;
            
        
        }
        
    }

    private function form($action, $submitted = false, $saved_data = array(), $image='') {

        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'title'       => '',
            'description' => '',
            'url'         => '',
            'image'       => ''   
        );

        $form->saved_data = $saved_data;
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Title', 'title', 'textarea', array('attributes' => array('class' => 'link_text_area')));
        $form->append('Description', 'description', 'textarea', array('attributes' => array('class' => 'link_text_area')));
        $form->append('Url', 'url', 'text', array('attributes' => array('class' => 'link_text')));
        $form->append('', 'image', 'hidden');
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();

        $id = $this->request->param('id');
        
        $links_old = array(
            'cancel' => Html::anchor('/link/', 'or cancel')
        );

        $action = $this->request->action();
        $upload_url = URL::site('link/uploadlinkimg');
        
        $view = View::factory('link/form')
            ->bind('links', $links)
            ->bind('form', $form)
            ->bind('action', $action)
            ->bind('id', $id)
            ->bind('image', $image)
            ->bind('upload_url', $upload_url)
            ;
        
        $this->content = $view;

    }

    public function action_edit() {
        $submitted = false;

        $id = $this->request->param('id');
        if (!$id) {
            Request::current()->redirect('link');
        }

        $link = ORM::factory('link',$id);

        if ($this->request->method() === 'POST' && $this->request->post()) {
            if (Arr::get($this->request->post(), 'save') !== null) {
                $submitted = true;
                $safepost = Arr::map('Security::xss_clean', $this->request->post());
                $validator = $link->validator($safepost);
                if ($validator->check()) {
                    $link->title = Arr::get($safepost, 'title');
                    $link->description = Arr::get($safepost, 'description');
                    $link->image = Arr::get($safepost, 'image');
                    $link->url  = Arr::get($safepost, 'url');
                    $link->course_id = Session::instance()->get('course_id');
                    $link->save();
                    
                    Session::instance()->set('success', 'Link edited successfully.');
                    Request::current()->redirect('link');
                    exit;
                } else {
                    $this->_errors = $validator->errors('link');
                }
            }
        }

        Breadcrumbs::add(array(
            'Edit', Url::site('link/edit/id/'.$id )
        ));
        
        $this->form('link/edit/id/'.$id ,$submitted, array('title' => $link->title, 'description' => $link->description, 'url' => $link->url, 'image' => $link->image), $link->image);
    }

    public function action_delete() {
        if ($this->request->method() === 'POST' && $this->request->post('selected')) {
            foreach($this->request->post('selected') as $link_id) {
                ORM::factory('link', $link_id)->delete();
            }
        }
        Session::instance()->set('success', 'Link(s) deleted successfully.');
        Request::current()->redirect('link');
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
    
    public function action_uploadlinkimg(){
        
        $filename = 'link_'.time() . '_' . $_FILES['image']['name'];
                
        $file_validation = new Validation($_FILES);
        $file_validation->rule('image','upload::valid');
        $file_validation->rule('image', 'upload::type', array(':value', array('jpg', 'png', 'gif', 'jpeg')));
        
        if ($file_validation->check()){
            
            if($path = Upload::save($_FILES['image'], $filename, DIR_IMAGE)){
                
                $images = CacheImage::instance();;
                $src = $images->resize($filename, 400, 200);
                
                $json = array(
                   'success'   => 1,
                   'image'     => $src,
                   'filename'  => $filename 
                );
            } else {
                $json = array(
                   'success'  => 0,
                   'errors'   => array('image' => 'The file is not a valid Image')
                );
            }
        } else {
            $json = array(
                 'success'   => 0,
                 'errors'    => (array) $file_validation->errors('profile')
            );
        }
        
         
        echo json_encode($json);
        exit;
        
    }
}