<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Base extends Controller_Template {

    protected $content;

    public $template = 'template/template';

    protected $view;

    /**
     * Override the before method
     * check if ajax and select correct template
     */
    public function before()
    {
        $this->auth_filter();  
        if (!$this->request->is_ajax()) {
            $this->view = View::factory($this->template);
        } else {
            $this->view = View::factory('template/content');
        }
        return parent::before();
    }
	
    public function action_index()
    {
        $this->response->body('hello, world!');
    }

    /**
     * Check whether the user is logged in and set the correct 
     * template to handle both the cases
     */
    protected function auth_filter() {
        $user = Auth::instance()->get_user();
        if (null === $user) {
            $this->template = 'template/template';
        } else {
            $this->template = 'template/logged_template';
        }
    }
    
    public function after() {
        $title   = 'Kode Learn';
        $styles = array(
            'media/css/reset.css' => 'screen',
            'media/css/components.css' => 'screen',
            'media/css/kodelearn.css' => 'screen'
        );
        $scripts = array(
            'media/javascript/jquery-1.6.2.min.js',
        );                
        $this->view->set('content', $this->content);
        $this->view->set('styles', $styles);
        $this->view->set('scripts', $scripts);
        $this->response->body($this->view);
    }

} // End Welcome
