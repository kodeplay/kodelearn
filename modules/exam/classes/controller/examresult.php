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
        $examresult = new Examgroup_Examresult($examgroup_id);
        $examgroup = $examresult->examgroup();
        // get all the exams in this exam group
        $exams = $examresult->exams();
        $exams_arr = $examresult->exams_arr();
        // if no exams found, redirect to nil exams page
        if (!count($exams_arr)) {
            Session::instance()->set('examgroup_nil_exams', array(
                'examgroup_id' => $examgroup_id,
                'back_url' => Url::site('examresult/upload'),
            ));
            Request::current()->redirect('examgroup/nil_exams');
            exit;
        }
        // get all students in this examgroup
        $students = $examresult->students();
        // get saved results
        $results = $examresult->results();
        // get an array of default marks for a user-exam combination
        $csv_default_values = $this->csv_default_values($examresult);
        // create a final results array by merging the default array and saved data
        foreach ($csv_default_values as $user_id=>$marks) {
            $results[$user_id] = Arr::get($results, $user_id, array()) + $marks;
        }
        // get the matrix array 
        $matrix = Examresult_Csv::matrix($students, $exams_arr, $results);
        // var_dump($matrix); exit; 
        $filename = Inflector::underscore($examgroup->name) . '_results.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename='.$filename);
        $fp = fopen('php://output', 'w');
        foreach ($matrix as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);
        exit;
    }

    /**
     * Method to get the default values to be dislayed in the csv
     * It will take into account whether a student is applicable for an exam and if not,
     * will show a dash '-' in the csv for it.
     * @param Examgroup_Examresult $examresult
     * @param array default_values array(user_id => exam_id => marks)
     */
    private function csv_default_values($examresult) {
        $default_values = array();
        $exams = $examresult->exams();
        $students = $examresult->students();
        foreach ($students as $user_id=>$name) {
            foreach ($exams as $exam) {
                if (!$examresult->student_takes_exam($user_id, $exam->id)) {
                    $default_values[$user_id][$exam->id] = '-';
                    continue;
                }
                $default_values[$user_id][$exam->id] = 0;
            }
        }
        return $default_values;
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
        $examresult = new Examgroup_Examresult($examgroup_id);
        $examgroup = $examresult->examgroup();
        // get all the exams in this exam group
        $exams = $examresult->exams();
        if (!count($exams->as_array())) {
            Session::instance()->set('examgroup_nil_exams', array(
                'examgroup_id' => $examgroup_id,
                'back_url' => Url::site('examresult/upload'),
            ));
            Request::current()->redirect('examgroup/nil_exams');
        }
        $results = $this->form($examresult);
        $this->content = $view;
    }

    /**
     * Method to return an array suitable to be shown in the browser edit form
     * @param Examgroup_Examresult $examresult_obj
     * @return array $results
     */
    private function form($examresult_obj) {
        $results = array();
        $students = $examresult_obj->students();
        $exams = $examresult_obj->exams();
        $examresults = $examresult_obj->results();
        $default_exam_marks = $this->edit_default_values($examresult_obj); 
        $post_data = $this->request->post('result');
        $post_data = $post_data === null ? array() : $post_data;
        foreach ($students as $user_id=>$name) {
            $exam_marks = $default_exam_marks[$user_id];
            $saved_marks = $examresults[$user_id];
            foreach ($exams as $exam) {
                $exam_id = $exam->id;
                // posted value if present else saved value
                $marks = isset($post_data[$exam_id][$user_id]) ? $post_data[$exam_id][$user_id] : $saved_marks[$exam_id];
                $exam_marks[$exam_id]['marks'] = $marks;
            }
            $results[] = array(
                'user_id' => $user_id,
                'name' => $name,
                'exam_marks' => $exam_marks,
                'invalid' => in_array($user_id, $this->_invalid_rows),
            );
        }
        return $results;
    }

    /**
     * Method to get the default values that any cell will come filled in 
     * if the examresults for the exam_id and user_id combination is not yet entered
     * @param Examgroup_Examresult $examresult_obj
     * @return array 
     *            user_id >
     *                     exam_id > 
     *                               0 > marks, student_applicable
     */
    private function edit_default_values($examresult) {
        $default_values = array();
        $students = $examresult->students();
        $exams = $examresult->exams();
        foreach ($students as $user_id=>$name) {
            foreach ($exams as $exam) {
                $default_values[$user_id][$exam->id] = array(
                    'marks' => '',
                    'student_applicable' => $examresult->student_takes_exam($user_id, $exam->id),
                );
            }
        }
        return $default_values;
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
