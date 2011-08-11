<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Examresult extends Controller_Base {

    private $_invalid_rows = array();

    public function action_index() {
        
    }
    
    /**
     * @action csv upload page
     * @view examresult/upload
     */
    public function action_upload() {
        $view = View::factory('examresult/upload')
            ->bind('form', $form)
            ->bind('success', $success)
            ->bind('warning', $warning);
        $errors = array();
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $examgroup_id = $this->request->post('examgroup_id');
            $exams = Model_Examgroup::get_exams($examgroup_id);
            $students = Model_Examgroup::get_students($examgroup_id);
            $csv = new Examresult_Csv($_FILES['csv_file'], $exams, $students);
            if ($csv->validate()) {
                $datasets = $csv->datasets();
                Model_Examresult::save_results($datasets);
                $success = 'Results uploaded successfully. Click here to view them';
            } else {
                $errors = array('csv_file' => $csv->errors('invalid_extension'));
                $warning = $csv->errors('warning');
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
     * @action download csv
     * @view None!
     * Create the csv for entering the results for the examgroup 
     * and force download of the csv file.
     * @param GET int examgroup_id
     */
    public function action_download_csv() {
        $examgroup_id = $this->request->param('examgroup_id');
        $examgroup = ORM::factory('examgroup', $examgroup_id);
        // get all the exams in this exam group
        $exams = Model_Examgroup::get_exams($examgroup_id)
            ->as_array('id', 'name');
        if (!count($exams)) {
            Session::instance()->set('examgroup_nil_exams', array(
                'examgroup_id' => $examgroup_id,
                'back_url' => Url::site('examresult/upload'),
            ));
            Request::current()->redirect('examgroup/nil_exams');
            exit;
        }
        // get all students in this examgroup
        $students = Model_Examgroup::get_students($examgroup_id);
        // var_dump($students); exit;
        $examresults = ORM::factory('examresult')
            ->where('exam_id', ' IN ', array_keys($exams))
            ->find_all();
        $results = array();
        if ($examresults) {
            foreach ($examresults as $modelobj) {
                $user_id = $modelobj->user_id;
                $exam_id = $modelobj->exam_id;
                $marks = $modelobj->marks;
                if (!isset($results[$user_id])) {
                    $results[$user_id] = array();
                }
                $results[$user_id][$exam_id] = $marks;
            }
        }        
        $matrix = Examresult_Csv::matrix($students, $exams, $results);
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
            ->bind('edit_form_action', $action)
            ->bind('csv_import', $csv_import)
            ->bind('success', $success)
            ->bind('warning', $warning);
        if ($this->request->method() === 'POST' && $this->request->post()) {
            $examresults = $this->request->post('result');
            $examgroup_id = $this->request->post('examgroup_id');
            $result_sets = $this->result_sets($examgroup_id, $examresults);
            if (!$this->_invalid_rows) {
                Model_Examresult::save_results($result_sets);
                $success = 'Results updated successfully.';
            } else {
                $warning = 'Marks scored must be less than total marks for the exam. Please check your input';
            }
        }
        $examgroup_id = $this->request->param('examgroup_id');
        $action = Url::site('examresult/edit/examgroup_id/'.$examgroup_id);
        $csv_import = Url::site('examresult/upload/examgroup_id/'.$examgroup_id);
        $examgroup = ORM::factory('examgroup', $examgroup_id);
        // get all the exams in this exam group
        $exams = Model_Examgroup::get_exams($examgroup_id);
        if (!count($exams->as_array())) {
            Session::instance()->set('examgroup_nil_exams', array(
                'examgroup_id' => $examgroup_id,
                'back_url' => Url::site('examresult/upload'),
            ));
            Request::current()->redirect('examgroup/nil_exams');
        }
        $results = $this->form($examgroup_id, $exams);
        $this->content = $view;
    }

    /**
     * Method to return an array suitable to be shown in the browser edit form
     * for examresults in the edit action
     * @param int $examgroup_id current examgroup_id
     * @param Database_Mysql_Result $exams
     * @return array $results
     */
    private function form($examgroup_id, $exams) {
        $results = array();
        // get all students in this examgroup
        $students = Model_Examgroup::get_students($examgroup_id);
        // get exam results
        $examresults = ORM::factory('examresult')
            ->where('exam_id', ' IN ', array_keys($exams->as_array('id','name')))
            ->find_all();
        $default_marks = array_fill_keys(array_keys($exams->as_array('id')), 0);
        $post_data = $this->request->post('result');
        $post_data = $post_data === null ? array() : $post_data;
        foreach ($students as $user_id=>$name) {
            $marks = $default_marks;
            foreach ($examresults as $examresult) {
                if ($examresult->user_id != $user_id) continue;
                $exam_id = $examresult->exam_id;
                $marks[$exam_id] = isset($post_data[$exam_id][$user_id]) ? $post_data[$exam_id][$user_id] :$examresult->marks;
            }
            $results[] = array(
                'user_id' => $user_id,
                'name' => $name,
                'marks' => $marks,
                'invalid' => in_array($user_id, $this->_invalid_rows),
            );
        }
        return $results;
    }

    /**
     * Method to get the result sets from the post data submitted
     * @param array $results (keys = exam_id, values = array ( keys = student_id, values = marks scored)
     * @return array $results array keys (exam_id, user_id, marks)
     */
    private function result_sets($examgroup_id, $examresults) {
        if (!$examresults) {
            return array();
        }
        // get all the exams in this exam group
        $exams = Model_Examgroup::get_exams($examgroup_id)
            ->as_array('id', 'total_marks');
        $sets = array();
        foreach ($examresults as $exam_id=>$results) {
            foreach ($results as $user_id=>$marks) {
                if ($marks > $exams[$exam_id]) {
                    $this->_invalid_rows[] = $user_id;
                }
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
