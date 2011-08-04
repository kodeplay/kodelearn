<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Examresult extends Controller_Base {

    public function action_index() {
        
    }
    
    public function action_upload() {
        $view = View::factory('examresult/upload')
            ->bind('form', $form)
            ->bind('success', $success);
        $errors = array();
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $examgroup_id = $this->request->post('examgroup_id');
            $csv = new Examresult_Csv($_FILES['csv_file']);
            if ($csv->validate()) {
                $csv_data = $csv->content();
                // get all the exams in this exam group
                $exams = Model_Examgroup::get_exams($examgroup_id)
                    ->as_array('name', 'id');
                $csv_headings = array_shift($csv_data);
                // get the array of exam_ids in the order they appear in the csv
                $ordered_exams = Examresult_Csv::ordered_exams($csv_headings, $exams);
                Model_Examresult::csv_import($csv_data, $ordered_exams);
                $success = 'Results uploaded successfully. Click here to view them';
            } else {
                $errors = array(
                    'csv_file' => 'CSV file uploaded is invalid',
                );
            }
        }
        $form = new Stickyform('examresult/upload', array('enctype' => 'multipart/form-data'), $errors);
        $form->default_data = array(
            'examgroup_id' => '',
            'csv_file' => '',
        );
        $form->posted_data = $this->request->post();
        $examgroups = ORM::factory('examgroup')->find_all()->as_array('id', 'name');
        $form->append('Select Exam Group:', 'examgroup_id', 'select', array('options' => $examgroups))
            ->append('CSV File:', 'csv_file', 'file')
            ->append('Upload', 'upload', 'submit', array('attributes' => array('class' => 'button')))
            ->process();
        $this->content = $view;
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
}
