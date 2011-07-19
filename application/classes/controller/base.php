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
        $this->acl_filter();
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
        if (!Auth::instance()->logged_in()) {
            $this->template = 'template/template';
        } else {
            $this->template = 'template/logged_template';
        }
    }    

    protected function acl_filter() {
        $resource = $this->request->controller(); 
        $acl = Acl::instance();
        if (!$acl->has_access($resource)) {
            Request::current()->redirect('accessdenied');
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
            'media/javascript/common.js',
            'media/javascript/ajaxupload.js',
        
        );
        $this->view->set('content', $this->content);
        $this->view->set('styles', $styles);
        $this->view->set('scripts', $scripts);
        $this->menu_init();
        $this->response->body($this->view);
    }

    protected function menu_init() {
        // Adding the top menu
        if (!Auth::instance()->logged_in()) {
            $this->view->bind('topmenu', $topmenu);
            $topmenu = DynamicMenu::factory('topmenu');
            $topmenu->add_link('index', 'Home')
                ->add_link('page/about', 'About')
                ->add_link('page/features', 'Features')            
                ->add_link('auth', 'Signup/Login');
        } else {
            $this->view->bind('topmenu', $topmenu)
                ->bind('sidemenu', $sidemenu);
            $topmenu = DynamicMenu::factory('topmenu');
            $topmenu->add_link('home', 'Home')
                ->add_link('account', 'Profile')
                ->add_link('inbox', 'Inbox');
            $sidemenu = DynamicMenu::factory('sidemenu');
            $sidemenu->add_link('user', 'Users', 0)
                ->add_link('batch', 'Batches', 1)
                ->add_link('system', 'System', 2)
                ->add_link('course', 'Courses', 3)
                ->add_link('lecture', 'Lectures', 4)
                ->add_link('exam', 'Exam', 5)
                ->add_link('calender', 'Calender', 6);
        }
    }

} // End Welcome
