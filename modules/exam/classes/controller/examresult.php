<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Examresult extends Controller_Base {

    // is this required ?
    public function action_index() {

    }

    
    public function action_upload() {
        
    }

    /**
     * Create the csv for entering the results for the examgroup 
     * and force download of the csv file.
     * @param GET int examgroup_id
     */
    public function action_download_csv() {
        $examgroup_id = $this->request->param('examgroup_id');
        // get all exams whose examgroup_id is passed in get
        $exams = ORM::factory('exam')
            ->where('examgroup_id', ' = ', $examgroup_id)
            ->find_all()->as_array('id');
        var_dump($exams);
        exit;
        
        
        
    }

    // only the administrator and the teacher will be permitted to do this
    public function action_edit() {

    }

    // view results of all users - so typically only the administrator and teacher 
    // will have this permission
    public function action_view() {


    }

    // View the marksheet of a student by passing a user_id in get
    // so will be accessible only to the admin and teacher
    // if no user is passed, a filter will be applied to check if 
    // its the current user trying to view his/her own marksheet or 
    // if its the parant trying to view the marksheet of their pupil
    public function action_marksheet() {


    }




}
