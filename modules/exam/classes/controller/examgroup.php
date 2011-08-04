<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Examgroup extends Controller_Base {
    
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
        
        $examgroup = ORM::factory('examgroup');
        
        if($this->request->param('filter_name')){
            $examgroup->where('name', 'LIKE', '%' . $this->request->param('filter_name') . '%');
        }
        
        $count = $examgroup->count_all();

        $pagination = Pagination::factory(array(
            'total_items'    => $count,
            'items_per_page' => 5,
        ));
        

        $examgroup->select('name');
                        
        if($this->request->param('filter_name')){
            $examgroup->where('name', 'LIKE', '%' . $this->request->param('filter_name') . '%');
        }
                        
        $examgroup->group_by('id')
                ->order_by($sort, $order)
                ->limit($pagination->items_per_page)
                ->offset($pagination->offset)
                ;
        $examgroups = $examgroup->find_all();



        $sorting = new Sort(array(
                'Name'          => 'name',
                'Action'        => ''
        ));
        
        $url = ('examgroup/index');
        
        if($this->request->param('filter_name')){
            $url .= '/filter_name/'.$this->request->param('filter_name');
        }
        
        $sorting->set_link($url);
        
        $sorting->set_order($order);
        $sorting->set_sort($sort);
        $heading = $sorting->render();
        
        $links = array(
            'add_examgroup' => Html::anchor('/examgroup/add/', 'Create a Grading Period', array('class' => 'createButton l')),
            'delete'      => URL::site('/examgroup/delete/')
        );
        
        $table = array('heading' => $heading, 'data' => $examgroups);
        
        // Render the pagination links
        $pagination = $pagination->render();
        
        $filter_name = $this->request->param('filter_name');
        $filter_url = URL::site('examgroup/index');
        
        $view = View::factory('examgroup/list')
                    ->bind('links', $links)        
                    ->bind('table', $table)
                    ->bind('count', $count)
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
                $examgroup = ORM::factory('examgroup');
                $validator = $examgroup->validator($this->request->post());
                if ($validator->check()) {
                    
                    $examgroup->name = $this->request->post('name');
                    
                    $examgroup->save();
                    Request::current()->redirect('examgroup');
                    exit;
                } else {
                    $this->_errors = $validator->errors('examgroup');
                }
            }
         }
                
        $form = $this->form('examgroup/add', $submitted);
        
        $links = array(
            'cancel' => Html::anchor('/examgroup/', 'or cancel')
        );
        
        $view = View::factory('examgroup/form')
                  ->bind('links', $links)
                  ->bind('form', $form);
        $this->content = $view;
    }
    
    private function form($action, $submitted = false, $saved_data = array()){
        
        $locations = array();
        
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'name' => '',
            
        );
        
        $form->saved_data = $saved_data;
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Name', 'name', 'text');
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        return $form;
        
    }
    
    public function action_edit(){
        $submitted = false;
        
        $id = $this->request->param('id');
        if(!$id)
            Request::current()->redirect('examgroup');
            
        $examgroup = ORM::factory('examgroup',$id);
        
         if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $validator = $examgroup->validator($this->request->post());
                if ($validator->check()) {
                    $examgroup->name = $this->request->post('name');
                    $examgroup->save();
                    Request::current()->redirect('examgroup');
                    exit;
                } else {
                    $this->_errors = $validator->errors('examgroup');
                }
            }
         }
        
        $form = $this->form('examgroup/edit/id/'.$id ,$submitted, array('name' => $examgroup->name));
        
        
        $links = array(
            'cancel' => Html::anchor('/examgroup/', 'or cancel')
        );
        
        $view = View::factory('examgroup/form')
                  ->bind('links', $links)
                  ->bind('form', $form);
        $this->content = $view;
        
        
    }
    
    public function action_delete(){
        if($this->request->method() === 'POST' && $this->request->post('selected')){
            foreach($this->request->post('selected') as $id){
                ORM::factory('examgroup', $id)->delete();
            }
        }
        Request::current()->redirect('examgroup');
    }
}
