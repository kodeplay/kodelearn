<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Batch extends Controller_Base 
{
	
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
        
        $count = ORM::factory('batch')
                        ->count_all()
                        ;

        $pagination = Pagination::factory(array(
            'total_items'    => $count,
            'items_per_page' => 5,
        ));
        

        $batch = ORM::factory('batch')
                        ->select(array('COUNT("batches_users.user_id")', 'users'))
                        ->join('batches_users','left')
                        ->on('batches_users.batch_id','=','batches.id')
                        ->group_by('batches.id')
                        ->order_by($sort, $order)
                        ->limit($pagination->items_per_page)
                        ->offset($pagination->offset)
                        ;
        $batches = $batch->find_all();


        $sorting = new Sort(array(
                'Batch'             => 'name',
                'No. of Students'   => 'users',
                'Actions'           => '',
        ));
        
        $sorting->set_link(('batch/index'));
        
        $sorting->set_order($order);
        $sorting->set_sort($sort);
        $heading = $sorting->render();
        
        $links = array(
            'add_batch' => Html::anchor('/batch/add/', 'Create a batch', array('class' => 'createButton l')),
            'delete'      => URL::site('/batch/delete/')
        );
        
        $table = array('heading' => $heading, 'data' => $batches);
        
        // Render the pagination links
        $pagination = $pagination->render();
        
        $view = View::factory('batch/list')
                    ->bind('links', $links)        
                    ->bind('table', $table)
                    ->bind('pagination', $pagination)
                    ;
        
        $this->content = $view;	
	}
	
	public function action_add(){
		 $submitted = false;
		 
         if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $batch = ORM::factory('batch');
		        $validator = $batch->validator($this->request->post());
		        if ($validator->check()) {
		        	
                    $batch->name = $this->request->post('name');
                    $batch->description = $this->request->post('description');
                    $batch->save();
		            Request::current()->redirect('batch');
		            exit;
		        } else {
		            $this->_errors = $validator->errors('batch');
		        }
            }
         }
                
        $form = $this->form('batch/add', $submitted);
		
        $links = array(
            'cancel' => Html::anchor('/batch/', 'or cancel')
        );
        
        $view = View::factory('batch/form')
                  ->bind('links', $links)
		          ->bind('form', $form);
		$this->content = $view;
	}
	
	private function form($action, $submitted = false, $saved_data = array()){
		
        $form = new Stickyform($action, array(), ($submitted ? $this->_errors : array()));
        $form->default_data = array(
            'name' => '',
            'description' => '',
        );
        
        $form->saved_data = $saved_data;
        $form->posted_data = $submitted ? $this->request->post() : array();
        $form->append('Name', 'name', 'text');
        $form->append('Description', 'description', 'textarea', array('attributes' => array('cols' => 50, 'rows' => 5)));
        $form->append('Save', 'save', 'submit', array('attributes' => array('class' => 'button')));
        $form->process();
        return $form;
        
	}
	
	public function action_edit(){
		$submitted = false;
		
		$id = $this->request->param('id');
		if(!$id)
            Request::current()->redirect('batch');
            
        $batch = ORM::factory('batch',$id);
		
         if($this->request->method() === 'POST' && $this->request->post()){
            if (Arr::get($this->request->post(), 'save') !== null){
                $submitted = true;
                $validator = $batch->validator($this->request->post());
                if ($validator->check()) {
                    $batch->name = $this->request->post('name');
                    $batch->description = $this->request->post('description');
                    $batch->save();
                    Request::current()->redirect('batch');
                    exit;
                } else {
                    $this->_errors = $validator->errors('batch');
                }
            }
         }
        
        $form = $this->form('batch/edit/id/'.$id ,$submitted, array('name' => $batch->name, 'description' => $batch->description));
        
        
        $links = array(
            'cancel' => Html::anchor('/batch/', 'or cancel')
        );
        
        $view = View::factory('batch/form')
                  ->bind('links', $links)
                  ->bind('form', $form);
        $this->content = $view;
		
		
	}
	
	public function action_delete(){
		if($this->request->method() === 'POST' && $this->request->post('selected')){
			foreach($this->request->post('selected') as $batch_id){
				ORM::factory('batch', $batch_id)->delete();
			}
		}
		Request::current()->redirect('batch');
	}
	
}