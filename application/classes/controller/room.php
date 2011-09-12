<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Room extends Controller_Base {

    public $template = 'template/logged_template';
    
    protected $_errors = array();

    
    public function action_index(){
        $msg = $this->request->param('msg');
        
        if($this->request->param('sort')){
            $sort = $this->request->param('sort');
        } else {
            $sort = 'room_name';
        }
        
        if($this->request->param('order')){
            $order = $this->request->param('order');
        } else {
            $order = 'DESC';
        }
        
        $room = ORM::factory('room');
        
        if($this->request->param('filter_room_name')){
            $room->where('room_name', 'LIKE', '%' . $this->request->param('filter_room_name') . '%');
        }
        
        $count = $room->count_all();

        $pagination = Pagination::factory(array(
            'total_items'    => $count,
            'items_per_page' => 5,
        ));
        

        $room->select('locations.name','room_number','room_name')
             ->join('locations','left')
             ->on('locations.id','=','location_id');
                        
        if($this->request->param('filter_room_name')){
            $room->where('room_name', 'LIKE', '%' . $this->request->param('filter_room_name') . '%');
        }
                        
        $room->group_by('id')
                ->order_by($sort, $order)
                ->limit($pagination->items_per_page)
                ->offset($pagination->offset)
                ;
        $rooms = $room->find_all();



        $sorting = new Sort(array(
                'Name'          => 'room_name',
                'Number'        => 'room_number',
                'Location'      => 'name',
                'Action'        => ''
        ));
        
        $url = ('room/index');
        
        if($this->request->param('filter_room_name')){
            $url .= '/filter_room_name/'.$this->request->param('filter_room_name');
        }
        
        $sorting->set_link($url);
        
        $sorting->set_order($order);
        $sorting->set_sort($sort);
        $heading = $sorting->render();
        
        $links = array(
            'add_room' => Html::anchor('/room/add/', 'Create a Room', array('class' => 'createButton l')),
            'locations' => Html::anchor('/location', 'Locations', array('class' => 'pageAction l')),
            'delete'      => URL::site('/room/delete/')
        );
        
        $table = array('heading' => $heading, 'data' => $rooms);
        
        // Render the pagination links
        $pagination = $pagination->render();
        
        $filter_room_name = $this->request->param('filter_room_name');
        $filter_url = URL::site('room/index');
        
        
        $view = View::factory('room/list')
                    ->bind('links', $links)        
                    ->bind('table', $table)
                    ->bind('count', $count)
                    ->bind('pagination', $pagination)
                    ->bind('filter_room_name', $filter_room_name)
                    ->bind('filter_url', $filter_url)
                    ->bind('msg', $msg)
                    ;
        
        Breadcrumbs::add(array(
            'System', Url::site('system')
        ));
        Breadcrumbs::add(array(
            'Room', Url::site('room')
        ));            
        $this->content = $view; 
    }
    
    public function action_add(){
         $submitted = false;
         
         if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $room = ORM::factory('room');
                $validator = $room->validator($this->request->post());
                if ($validator->check()) {
                    
                    $room->room_name = $this->request->post('room_name');
                    $room->room_number = $this->request->post('room_number');
                    $room->location_id = $this->request->post('location_id');
                    $room->save();
                    Request::current()->redirect('room');
                    exit;
                } else {
                    $this->_errors = $validator->errors('room');
                }
            }
         }
                
        $form = $this->form('room/add', $submitted);
        
        $links = array(
            'cancel' => Html::anchor('/room/', 'or cancel')
        );
       
        $view = View::factory('room/form')
                  ->bind('links', $links)
                  ->bind('form', $form)
                  ;
        Breadcrumbs::add(array(
            'System', Url::site('system')
        ));
        Breadcrumbs::add(array(
            'Room', Url::site('room')
        )); 
        Breadcrumbs::add(array(
            'Create', Url::site('room/add')
        ));            
        $this->content = $view;
    }
    
    private function form($action, $submitted = false, $saved_data = array()){
        
        $locations = array();
        foreach(ORM::factory('location')->find_all() as $location){
            $locations[$location->id] = $location->name;
        }
        
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'room_name' => '',
            'room_number' => '',
            'location_id' => '',
        );
        
        $form->saved_data = $saved_data;
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Name', 'room_name', 'text');
        $form->append('Number', 'room_number', 'text');
        $form->append('Location', 'location_id', 'select', array('options' => $locations));
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        return $form;
        
    }
    
    public function action_edit(){
        $submitted = false;
        
        $id = $this->request->param('id');
        if(!$id)
            Request::current()->redirect('room');
            
        $room = ORM::factory('room',$id);
        
         if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $validator = $room->validator($this->request->post());
                if ($validator->check()) {
                    $room->room_name = $this->request->post('room_name');
                    $room->room_number = $this->request->post('room_number');
                    $room->location_id = $this->request->post('location_id');
                    $room->save();
                    Request::current()->redirect('room');
                    exit;
                } else {
                    $this->_errors = $validator->errors('room');
                }
            }
         }
        
        $form = $this->form('room/edit/id/'.$id ,$submitted, array('room_name' => $room->room_name, 'room_number' => $room->room_number, 'location_id' => $room->location_id));
        
        
        $links = array(
            'cancel' => Html::anchor('/room/', 'or cancel')
        );
        
        $view = View::factory('room/form')
                  ->bind('links', $links)
                  ->bind('form', $form)
                  ;
        Breadcrumbs::add(array(
            'System', Url::site('system')
        ));
        Breadcrumbs::add(array(
            'Room', Url::site('room')
        )); 
        Breadcrumbs::add(array(
            'Edit', Url::site('room/edit/id/'.$id)
        ));          
        $this->content = $view;
        
        
    }
    
    public function action_delete(){
        if($this->request->method() === 'POST' && $this->request->post('selected')){
            $msg = 0;
            foreach($this->request->post('selected') as $id){
                $event = ORM::factory('event');
                $event->select('exams.id')
                      ->join('exams','inner')
                      ->on('exams.event_id','=','events.id');
                $event->where('room_id', '=', $id);
                $events = $event->find();
                
                if($events == ""){
                     ORM::factory('room', $id)->delete();
                     
                } else {
                    $msg++ ;
                    
                }
            }
            
        }
        Request::current()->redirect('room/index/msg/'.$msg);
    }
    
    public function action_show_map() {
    	
    	$room = ORM::factory('room', $this->request->param('id'));
    	
    	$location = ORM::factory('location', $room->location_id);
    	
    	$images = CacheImage::instance();
        $image = $images->resize($location->image, 400, 200);
    	
        $html = '<img src ="' . $image . '" />';
    	
    	$json = array(
    	   'success'   => 0,
    	   'html'      => $html
    	);
    	
    	echo json_encode($json);
    	exit;
    	
    	
    	
    }
    
}