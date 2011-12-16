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
            $content_search = Video::search($search_raw);
            $content = $content_search->getSearchResults();
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
    
    public function action_dataFromLink() {
        $orig = $this->request->post('post');
        
        $urlregex = '~(?:https?)://[a-z0-9+$_-]+(?:\\.[a-z0-9+$_-]+)*' .
            '(?:/(?:[a-z0-9+$_-]\\.?)+)*/?(?:\\?[a-z+&$_.-][a-z0-9;:@/&%=+$_.-]*)?'.
            '(?:#[a-z_.-][a-z0-9+$_.-]*)?~i';
        if (preg_match($urlregex, $orig, $matches)) {
            $url = $matches[0];
        } else { //no array found
            die("oops");
        }
        
        $video_embed = Video::embed($url);

        $video_result_json = $video_embed->getDataFromLink();
        
        echo  json_encode($video_result_json);
        exit;
    
    }
    
}