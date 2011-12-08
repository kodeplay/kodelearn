<?php defined('SYSPATH') or die('No direct script access.');

include(DOCROOT.'vendor/simple_html_dom.php');

class Controller_Video extends Controller_Base {
	
    protected $_errors = array();

    protected function breadcrumbs() {
        parent::breadcrumbs();
        $course = ORM::factory('course', Session::instance()->get('course_id'));
        if (!$this->request->is_ajax() && $this->request->is_initial()) {
            Breadcrumbs::add(array('Courses', Url::site('course')));
            Breadcrumbs::add(array(sprintf($course->name), Url::site('course/summary/id/'.$course->id)));        
            Breadcrumbs::add(array('Video', Url::site('video')));
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
        
        $total = Model_Video::video_total($criteria);
         
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
        
        $videos = Model_Video::videos($criteria);
       
        $sorting = new Sort(array(
            'Title'            => 'title',
            'Description'       => 'description',
        ));
        
        $url = ('video/index');
        
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
            'delete'      => URL::site('/video/delete/'),
            'add'         => URL::site('/video/add/'),
            'search'      => URL::site('/video/search/')
        );
        
        $table = array('data' => $videos);
        
        $filter_title = $this->request->param('filter_title');
        $filter_description = $this->request->param('filter_description');
        
        $filter_url = URL::site('video/index');        
        
        $success = Session::instance()->get('success');
        Session::instance()->delete('success');        
        
        $view = View::factory('video/list')
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
            $video = ORM::factory('video');
            
            
                $video->title = $this->request->post('title');
                $video->description = $this->request->post('description');
                $video->code = $this->request->post('code');
                $video->course_id = Session::instance()->get('course_id');
                
                $video->save();
                
                echo $video->id;
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
        $view = View::factory('video/form');
        Breadcrumbs::add(array(
            'Add', Url::site('video/add' )
        ));
        $this->content = $view;
    }

    public function action_delete() {
        if ($this->request->method() === 'POST' && $this->request->post('selected')) {
            foreach($this->request->post('selected') as $video_id) {
                ORM::factory('video', $video_id)->delete();
            }
        }
        Session::instance()->set('success', 'Video(s) deleted successfully.');
        Request::current()->redirect('video');
    }
    
    public function action_search() {
        
        if ($this->request->method() === 'POST' && $this->request->post('selected')) {
            
            foreach($this->request->post('selected') as $code) {
                $video = ORM::factory('video');

                $video->title = $_POST['videos'][$code]['title'];
                $video->description = $_POST['videos'][$code]['description'];
                $video->code = $_POST['videos'][$code]['code'];
                $video->course_id = Session::instance()->get('course_id');
                
                $video->save();
            }
            Session::instance()->set('success', 'Videos(s) added successfully.');
            Request::current()->redirect('video');
        }
        
        $content = array();
        $search_raw = '';
        if ($this->request->method() === 'POST' && $this->request->post('search')) {
            $search_raw = $this->request->post('search');
            $search = str_replace(" ", "+", $search_raw);
            
            $url = 'https://gdata.youtube.com/feeds/api/videos?q='.$search.'&orderby=relevance&start-index=1&max-results=10&v=2&format=5&safeSearch=strict&alt=json';
            $result = $this->curl_request_youtube($url);
            if(isset($result->feed->entry)) {
                foreach($result->feed->entry as $data) {
                    $title = (array)$data->title;
                    $common = (array)$data;
                    $common = (array)$common['media$group'];
                    $description = (array)$common['media$description'];
                    $code = (array)$common['yt$videoid'];
                    $content[] = array(
                        'title'         => $title['$t'],
                        'description'   => $description['$t'],
                        'code'          => $code['$t']
                    );
                }
            }
        }
        
        $links_old = array(
            'search'      => URL::site('/video/search/') 
        );
        
        $view = View::factory('video/search')
                ->bind('contents', $content)
                ->bind('links_old', $links_old)
                ->bind('search', $search_raw)
                ;
                
        Breadcrumbs::add(array(
            'Search', Url::site('video/search' )
        ));
        $this->content = $view;
        
    }
    
    private function curl_request_youtube($url){

       if (!function_exists('curl_init')) {
               return "";
       }

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

       $result = curl_exec($ch);
       curl_close ($ch);
       return json_decode($result);
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
            $code_j = $this->parse_youtube_url($matches[0]);
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
            'video_share' => 1,
            'code' => $code_j,
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