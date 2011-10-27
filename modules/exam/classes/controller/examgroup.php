<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Examgroup extends Controller_Base {
    
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
        
        $success = Session::instance()->get('success');
        Session::instance()->delete('success');        
        
        $view = View::factory('examgroup/list')
                    ->bind('links', $links)        
                    ->bind('table', $table)
                    ->bind('count', $count)
                    ->bind('pagination', $pagination)
                    ->bind('filter_name', $filter_name)
                    ->bind('filter_url', $filter_url)
                    ->bind('msg', $msg)
                    ->bind('success', $success)
                    ;
        
        Breadcrumbs::add(array(
            'Exams', Url::site('exam')
        ));
            
        Breadcrumbs::add(array(
            'Grading Period', Url::site('examgroup')
        ));
                    
        $this->content = $view; 
    }
    
    public function action_add(){
         $submitted = false;
         
         if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $examgroup = ORM::factory('examgroup');
                $safepost = Arr::map('Security::xss_clean', $this->request->post());
                $validator = $examgroup->validator($safepost);
                if ($validator->check()) {                    
                    $examgroup->name = Arr::get($safepost, 'name');
                    $examgroup->save();
                    Session::instance()->set('success', 'Grading Period added successfully.');
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
        
        Breadcrumbs::add(array(
            'Exams', Url::site('exam')
        ));
        
        Breadcrumbs::add(array(
            'Grading Period', Url::site('examgroup')
        ));
        
        Breadcrumbs::add(array(
            'Create', Url::site('examgroup/add')
        ));
        
        $this->content = $view;
    }
    
    private function form($action, $submitted = false, $saved_data = array()){
        
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
                $safepost = Arr::map('Security::xss_clean', $this->request->post());
                $validator = $examgroup->validator($safepost);
                if ($validator->check()) {
                    $examgroup->name = Arr::get($safepost, 'name');
                    $examgroup->save();
                    Session::instance()->set('success', 'Grading Period edited successfully.');
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
        
        Breadcrumbs::add(array(
            'Exams', Url::site('exam')
        ));
        
        Breadcrumbs::add(array(
            'Grading Period', Url::site('examgroup')
        ));
        
        Breadcrumbs::add(array(
            'Edit', Url::site('examgroup/edit/id/'.$id)
        ));        
    }
    
    public function action_delete(){
        if($this->request->method() === 'POST' && $this->request->post('selected')){
            foreach($this->request->post('selected') as $id){
                $exam = ORM::factory('exam');
                $exam->where('examgroup_id', '=', $id);
                $count = $exam->count_all();
                if($count > 0){
                   $msg = 1;
                } else {
                    ORM::factory('examgroup', $id)->delete();
                    $msg = 0;
                }
            }
            Request::current()->redirect('examgroup/index/msg/'.$msg);
        } else {
            Request::current()->redirect('examgroup/index/');
        }
    }

    public function action_nil_exams() {
        $view = View::factory('examgroup/nil_exams')
            ->bind('examgroup', $examgroup)
            ->bind('back_url', $back_url)
            ->bind('create_exam', $create_exam);
        $session = Session::instance();
        $session_data = $session->get('examgroup_nil_exams');
        if (!$session_data) {
            Request::current()->redirect('examgroup/index');
        }
        $examgroup_id = $session_data['examgroup_id'];
        $back_url = $session_data['back_url'];
        $create_exam = Url::site('exam/add');
        // session data is not longer required
        $session->delete('examgroup_nil_exams');
        $examgroup = ORM::factory('examgroup', $examgroup_id);
        $this->content = $view;
    }
}
