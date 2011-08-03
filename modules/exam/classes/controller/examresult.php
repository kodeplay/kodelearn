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
        $examgroup = ORM::factory('examgroup', $examgroup_id);
        // get all students in this examgroup
        $students = Model_Examgroup::get_students($examgroup_id);
        // var_dump($students); exit;
        // get all the exams in this exam group
        $exams = Model_Examgroup::get_exams($examgroup_id)
            ->as_array('id', 'name');
        $matrix = Examresult_Csv::matrix($students, $exams, array());
        // var_dump($matrix); exit; 
        $filename = Inflector::underscore($examgroup->name) . '_results.csv';
        header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment;filename='.$filename);
        $fp = fopen('php://output', 'w');
        foreach ($matrix as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
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
