<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Location extends Controller_Base {

    public $template = 'template/logged_template';
    
    protected $_errors = array();

    
    public function action_index(){
        $msg = $this->request->param('msg');
        
        if($this->request->param('sort')){
            $sort = $this->request->param('sort');
        } else {
            $sort = 'name';
        }
        
        if($this->request->param('order')){
            $order = $this->request->param('order');
        } else {
            $order = 'DESC';
        }
        
        $location = ORM::factory('location');
        
        if($this->request->param('filter_name')){
            $location->where('locations.name', 'LIKE', '%' . $this->request->param('filter_name') . '%');
        }
        
        $count = $location->count_all();

        $pagination = Pagination::factory(array(
            'total_items'    => $count,
            'items_per_page' => 5,
        ));
        

        $location->select(array('count("rooms.location_id")', 'room_count'))
                 ->join('rooms','left')
                 ->on('locations.id','=','rooms.location_id');
              
                        
        if($this->request->param('filter_name')){
            $location->where('locations.name', 'LIKE', '%' . $this->request->param('filter_name') . '%');
        }
                        
        $location->group_by('locations.id')
                ->order_by($sort, $order)
                ->limit($pagination->items_per_page)
                ->offset($pagination->offset)
                ;
        $locations = $location->find_all();
        
        $sorting = new Sort(array(
                'Location'          => 'name',
                'Map'               => '',
                'No of Rooms'             => 'room_count',
                'Actions'           => '',
        ));
        
        $url = ('location/index');
        
        if($this->request->param('filter_name')){
            $url .= '/filter_name/'.$this->request->param('filter_name');
            $filter = $this->request->param('filter_name');
            $filter_select = 'filter_name';
        }
        
        $sorting->set_link($url);
        
        $sorting->set_order($order);
        $sorting->set_sort($sort);
        $heading = $sorting->render();
        
        $links = array(
            'add_location' => Html::anchor('/location/add/', 'Create a location', array('class' => 'createButton l')),
            'rooms' => Html::anchor('/room', 'Rooms', array('class' => 'pageAction l')),
            'delete'      => URL::site('/location/delete/')
        );
        
        $table = array('heading' => $heading, 'data' => $locations);
        
        // Render the pagination links
        $pagination = $pagination->render();
        
        $filter_name = $this->request->param('filter_name');
        $filter_url = URL::site('location/index');
        
        $view = View::factory('location/list')
                    ->bind('links', $links)        
                    ->bind('table', $table)
                    ->bind('count', $count)
                    ->bind('pagination', $pagination)
                    ->bind('filter', $filter)
                    ->bind('filter_select', $filter_select)
                    ->bind('filter_url', $filter_url)
                    ->bind('msg', $msg)
                    ;
        
        Breadcrumbs::add(array(
            'System', Url::site('system')
        ));
        Breadcrumbs::add(array(
            'Location', Url::site('location')
        ));            
        $this->content = $view; 
    }
    
    public function action_add(){
         $submitted = false;
         $location = ORM::factory('location');
         if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                
                $validator = $location->validator($this->request->post());
                if ($validator->check()) {
                    
                    $location->name = $this->request->post('name');
                    $location->image = $this->request->post('image');
                    $location->save();
                    Request::current()->redirect('location');
                    exit;
                } else {
                    $this->_errors = $validator->errors('location');
                }
            }
         }
                
        $form = $this->form('location/add', $submitted);
        
        $links = array(
            'cancel' => Html::anchor('/location/', 'or cancel')
        );
        
        $upload_url = URL::site('location/uploadmap');

        $images = CacheImage::instance();
        $image = $images->resize($location->image, 400, 200);
        //$image = $location->image;
        
        $view = View::factory('location/form')
                  ->bind('links', $links)
                  ->bind('form', $form)
                  ->bind('image', $image)
                  ->bind('upload_url', $upload_url)
                  ;

        Breadcrumbs::add(array(
            'System', Url::site('system')
        ));
        Breadcrumbs::add(array(
            'Location', Url::site('location')
        ));
        Breadcrumbs::add(array(
            'Create', Url::site('location/add')
        )); 
               
        $this->content = $view;
    }
    
    public function action_uploadmap(){
        
        $filename = 'map_'.time() . '_' . $_FILES['image']['name'];
                
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
    
    private function form($action, $submitted = false, $saved_data = array()){
        
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'name' => '',
            'image' => '',
        );
        
        $form->saved_data = $saved_data;
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Name', 'name', 'text');
        $form->append('', 'image', 'hidden');
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        return $form;
        
    }
    
    public function action_edit(){
        $submitted = false;
        
        $id = $this->request->param('id');
        if(!$id)
            Request::current()->redirect('location');
            
        $location = ORM::factory('location',$id);
        
         if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $validator = $location->validator($this->request->post());
                if ($validator->check()) {
                    $location->name = $this->request->post('name');
                    $location->image = $this->request->post('image');
                    $location->save();
                    Request::current()->redirect('location');
                    exit;
                } else {
                    $this->_errors = $validator->errors('location');
                }
            }
         }
        
        $form = $this->form('location/edit/id/'.$id ,$submitted, array('name' => $location->name, 'image' => $location->image));
        
        
        $links = array(
            'cancel' => Html::anchor('/location/', 'or cancel')
        );
        
        $upload_url = URL::site('location/uploadmap');

        $images = CacheImage::instance();
        $image = $images->resize($location->image, 400, 200);
        //$image = $location->image;
        
        $view = View::factory('location/form')
                  ->bind('links', $links)
                  ->bind('form', $form)
                  ->bind('image', $image)
                  ->bind('upload_url', $upload_url)
                  ;
                  
        Breadcrumbs::add(array(
            'System', Url::site('system')
        ));
        Breadcrumbs::add(array(
            'Location', Url::site('location')
        ));
        Breadcrumbs::add(array(
            'Edit', Url::site('location/edit/id/'.$id)
        ));          
        $this->content = $view;
        
    }
    
    public function action_delete(){
        if($this->request->method() === 'POST' && $this->request->post('selected')){
            $msg = 0;
            foreach($this->request->post('selected') as $location_id){
                $room = ORM::factory('room');
                $room->where('location_id', '=', $location_id);
                $rooms = $room->find();
                if($rooms == ""){
                    ORM::factory('location', $location_id)->delete();
                     
                } else {
                    $msg++ ;
                    
                }
                
            }
        }
        Request::current()->redirect('location/index/msg/'.$msg);
    }
    
}