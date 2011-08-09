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
        $form->append('Select Exam Group:', 'examgroup_id', 'select', array('options' => $examgroups, 'attributes' => array('id' => 'examgroup_id')))
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
        $view = View::factory('examresult/edit')
            ->bind('results', $results)
            ->bind('exams', $exams)
            ->bind('examgroup', $examgroup)
            ->bind('edit_form_action', $action);
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $examresults = $this->request->post('result');
            $result_sets = self::result_sets($examresults);
            Model_Examresult::save_results($result_sets);
        }
        $action = Url::site('examresult/edit');
        // $examgroup_id = $this->request->param('examgroup_id');
        $examgroup_id = 2;
        $examgroup = ORM::factory('examgroup', $examgroup_id);
        $results = array();
        // get all students in this examgroup
        $students = Model_Examgroup::get_students($examgroup_id);
        // get all the exams in this exam group
        $exams = Model_Examgroup::get_exams($examgroup_id);
        // get the exam results
        $examresults = ORM::factory('examresult')
            ->where('exam_id', ' IN ', array_keys($exams->as_array('id','name')))
            ->find_all();
        foreach ($students as $user_id=>$name) {
            $marks = array();
            foreach ($examresults as $examresult) {
                if ($examresult->user_id != $user_id) {
                    continue;
                }
                $marks[$examresult->exam_id] = $examresult->marks;
            }
            $results[] = array(
                'user_id' => $user_id,
                'name' => $name,
                'marks' => $marks,
            );
        }
        $this->content = $view;
    }

    /**
     * Method to get the result sets from the post data submitted
     * @param array $results (keys = exam_id, values = array ( keys = student_id, values = marks scored)
     * @return array $results array keys (exam_id, user_id, marks)
     */
    private static function result_sets($examresults) {
        if (!$examresults) {
            return array();
        }
        $sets = array();
        foreach ($examresults as $exam_id=>$results) {
            foreach ($results as $user_id=>$marks) {
                $sets[] = array(
                    'exam_id' => $exam_id,
                    'user_id' => $user_id,
                    'marks' => $marks
                );
            }
        }
        return $sets;
    }

    // view results of all users - so typically only the administrator and teacher 
    // will have this permission
    public function action_view() {


    }
}
