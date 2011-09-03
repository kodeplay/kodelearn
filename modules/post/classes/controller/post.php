<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Post extends Controller_Base {

    /**
     * Action to display the form for adding posts
     */
    public function action_form() {
        $view = View::factory('post/form')
            ->bind('visibility_options', $visibility_options)
            ->bind('roles', $roles)
            ->bind('courses', $courses)
            ->bind('batches', $batches);            
        $visibility_options = array(
            'everyone' => __('Everyone'),
            'batch' => __('Only a specific Batch'),
            'course' => __('Only a specific Course'),
            'role'  => __('Only some roles'),
        );
        $roles = ORM::factory('role')->find_all()->as_array('id', 'name');
        $batches = ORM::factory('batch')->find_all()->as_array('id', 'name');
        $courses = ORM::factory('course')->find_all()->as_array('id', 'name');
        $this->content = $view;
    }

    /**
     * Action for adding the post to database
     */
    public function action_add() {

    }
}