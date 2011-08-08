<?php defined('SYSPATH') or die('No direct access allowed.');

class Acl_Menu_Guest extends Acl_Menu {

    public function __construct() {
        $topmenu = DynamicMenu::factory('topmenu');
        $topmenu->add_link('index', 'Home')
            ->add_link('page/about', 'About')
            ->add_link('page/features', 'Features')            
            ->add_link('auth', 'Signup/Login');
        $this->set('topmenu', $topmenu);
    }
}