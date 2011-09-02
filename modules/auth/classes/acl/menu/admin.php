<?php defined('SYSPATH') or die('No direct access allowed.');

class Acl_Menu_Admin extends Acl_Menu {

    public function __construct() {
        DynamicMenu_Filter::add(new Acl_Menu_Filter());
        $topmenu = DynamicMenu::factory('topmenu');
        $topmenu->add_link('feed', 'Home')
            ->add_link('account', 'Profile')
            ->add_link('inbox', 'Inbox')
            ->add_link('auth/logout', 'Logout');
        $sidemenu = DynamicMenu::factory('sidemenu');
        $sidemenu->add_link('user', 'Users', 0)
            ->add_link('batch', 'Batches', 1)
            ->add_link('system', 'System', 2)
            ->add_link('course', 'Courses', 3);
        $myaccount = DynamicMenu::factory('myaccount');
        $myaccount->add_link('system', 'Setting', 0)
            ->add_link('account', 'Account', 1)
            ->add_link('auth/logout', 'Logout', 2);
        $this->set('topmenu', $topmenu)
            ->set('sidemenu', $sidemenu)
            ->set('myaccount', $myaccount);
    }
}
