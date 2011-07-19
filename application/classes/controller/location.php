<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Location extends Controller_Base {

    public $template = 'template/logged_template';
    
    protected $_errors = array();

    
    public function action_index(){
        
        
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
        

        $location->select('name','image');
              
                        
        if($this->request->param('filter_name')){
            $location->where('name', 'LIKE', '%' . $this->request->param('filter_name') . '%');
        }
                        
        $location->group_by('id')
                ->order_by($sort, $order)
                ->limit($pagination->items_per_page)
                ->offset($pagination->offset)
                ;
        $locations = $location->find_all();



        $sorting = new Sort(array(
                'Location'          => 'name',
                'Map'               => 'image',
                'Actions'           => '',
        ));
        
        $url = ('location/index');
        
        if($this->request->param('filter_name')){
            $url .= '/filter_name/'.$this->request->param('filter_name');
        }
        
        $sorting->set_link($url);
        
        $sorting->set_order($order);
        $sorting->set_sort($sort);
        $heading = $sorting->render();
        
        $links = array(
            'add_location' => Html::anchor('/location/add/', 'Create a location', array('class' => 'createButton l')),
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
                    ->bind('pagination', $pagination)
                    ->bind('filter_name', $filter_name)
                    ->bind('filter_url', $filter_url)
                    ;
        
        $this->content = $view; 
    }
    
    public function action_add(){
         $submitted = false;
         
         if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $location = ORM::factory('location');
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
        
        $upload_url = URL::site('account/uploadavatar');

        $image = new CacheImage();
        $avatar = $image->resize($user->avatar, 100, 100);
        
        $view = View::factory('location/form')
                  ->bind('links', $links)
                  ->bind('form', $form)
                  ->bind('avatar', $avatar)
                  ->bind('upload_url', $upload_url);
                  
        $this->content = $view;
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
        $form->append('Map', 'image', 'text');
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
        
        $view = View::factory('location/form')
                  ->bind('links', $links)
                  ->bind('form', $form);
        $this->content = $view;
        
        
    }
    
    public function action_delete(){
        if($this->request->method() === 'POST' && $this->request->post('selected')){
            foreach($this->request->post('selected') as $location_id){
                ORM::factory('location', $location_id)->delete();
            }
        }
        Request::current()->redirect('location');
    }
    
}