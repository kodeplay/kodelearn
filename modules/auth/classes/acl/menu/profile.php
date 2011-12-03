<?php defined('SYSPATH') or die('No direct access allowed.');

class Acl_Menu_Profile extends Acl_Menu {

    public function __construct() {
        parent::__construct();
        $topmenu = DynamicMenu::factory('topmenu');
        $topmenu->add_link('home', 'Home')
            ->add_link('account', 'Profile')
            ->add_link('auth/logout', 'Logout');
        
        $myaccount = DynamicMenu::factory('myaccount');
        $myaccount->add_link('system', 'Setting', 0)
            ->add_link('account', 'Account', 1)
            ->add_link('auth/logout', 'Logout', 2);
        
        
        $profilemenu = DynamicMenu::factory('profilemenu');
        
                
        $this->set('topmenu', $topmenu)
            ->set('myaccount', $myaccount)
            ->set('profilemenu', $profilemenu);
    }
}
