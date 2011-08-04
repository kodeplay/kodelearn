<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Exammarksheet extends Controller_Base {

    /** 
     * View the marksheet of a student by passing a user_id in get
     * so will be accessible only to the admin and teacher
     * if no user is passed, a filter will be applied to check if 
     * its the current user trying to view his/her own marksheet or 
     * if its the parant trying to view the marksheet of their pupil
     */
    public function action_index() {
        $relevant_user = Acl::instance()->relevant_user();
        // check if admin in which _case_ a user_id in the get param is required
        if (!$relevant_user) {
            $user_id = $this->request->get('user_id');
            $relevant_user = ORM::factory('user', $user_id);
        }

        if (!$relevant_user) {
            echo 'Not allowed';
            exit;
        }

        


    }

    // @todo
    public function action_pdf() {
        

    }

    // @todo
    public function action_print() {



    }
}
