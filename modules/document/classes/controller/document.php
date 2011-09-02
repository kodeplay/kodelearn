<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Document extends Controller_Base {

    public function action_index() {
        
        $view = View::factory('document/list')
            ->set('page_title', 'Documents Manager');
        
        $this->content = $view;

    }
}
