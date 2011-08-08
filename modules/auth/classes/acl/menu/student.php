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
            ->add_link('lecture', 'Lectures', 2)
            ->add_link('exam', 'Exam', 3)
            ->add_link('calender', 'Calender', 4);
        $this->set('topmenu', $topmenu)
            ->set('sidemenu', $sidemenu);
    }
}