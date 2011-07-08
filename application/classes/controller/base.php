<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller_Template {

    protected $content;

    protected $view;
    
      public function before()
      {
          parent::before();
  
        if ($this->auto_render)
        {
            // Initialize empty values
            $this->template->title   = 'Kode Learn';
            $this->template->content = '';
            
	        $this->template->styles = array(
	            'media/css/reset.css' => 'reset',
	            'media/css/components.css' => 'components',
	            'media/css/kodelearn.css' => 'kodelearn'
	        );
	        $this->template->scripts = array();
                    
          }
      }
	
	public function action_index()
	{
		$this->response->body('hello, world!');
	}
    
	public function after() {
        if (!$this->request->is_ajax()) {
            $this->view = View::factory('template/template');
        } else {
            $this->view = View::factory('template/content');
        }
        $this->view->set('content', $this->content);
        $this->view->set('styles', $this->template->styles);
        $this->view->set('scripts', $this->template->scripts);
        $this->response->body($this->view);
    }
	
} // End Welcome
