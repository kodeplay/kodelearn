<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Play extends Controller {
    
    public function action_index(){
        $page = $this->request->param('id', 'designComponents');
        $view = View::factory('play/' . $page);
        $styles = array(
            'media/css/reset.css' => 'screen',
            'media/css/components.css' => 'screen',
            'media/css/kodelearn.css' => 'screen',
            'scripts/dropkick/dropkick.css' => 'screen',
        );
        $scripts = array(
            'media/javascript/jquery-1.6.2.min.js',
            'media/javascript/common.js',
        );
        $view->set('styles', $styles);
        $view->set('scripts', $scripts);
        $this->response->body($view);
    }
}