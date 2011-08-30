<?php defined('SYSPATH') or die('No direct access allowed.');

class Acl_Menu_Student extends Acl_Menu {

    public function __construct() {
        $topmenu = DynamicMenu::factory('topmenu');
        $topmenu->add_link('home', 'Home')
            ->add_link('account', 'Profile')
            ->add_link('inbox', 'Inbox')
            ->add_link('auth/logout', 'Logout');
        $sidemenu = DynamicMenu::factory('sidemenu');
        $sidemenu->add_link('course', 'Courses', 1)
            ->add_link('attendence', 'Attendence', 3)
            ->add_link('calendar', 'Calendar', 4);
        $myaccount = DynamicMenu::factory('myaccount');
        $myaccount->add_link('account', 'Account', 0)
            ->add_link('auth/logout', 'Logout', 1);
        $this->set('topmenu', $topmenu)
            ->set('sidemenu', $sidemenu)
            ->set('myaccount', $myaccount);
    }
}
