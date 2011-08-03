<?php defined('SYSPATH') or die('No direct script access.');

class Examresult_Csv {

    /*
     * Method to get the matrix which will be finally put into the css
     * @param array $students keys = student_ids, values = Student Names
     * @param array $exams keys = exam_ids, values = Exam Names
     * @param array $results optional 
     *           eg. array(
     *                 'student_id' => array('exam_id' => marks)
     *               )
     */
    public static function matrix($students, $exams, $results=array()) {
        $matrix = array();
        // the first header line
        $matrix[0] = array_values($exams);
        array_unshift($matrix[0], "Student Id", "Student Name");
        // print_r($matrix[0]); exit;
        foreach ($students as $student_id=>$student_name) {
            $line = array(
                $student_id,
                $student_name                
            );
            foreach ($exams as $exam_id=>$exam_name) {
                if ($results && isset($results[$student_id])) {
                    $line[] = Arr::get($results[$student_id], $exam_id, '');
                } else {
                    $line[] = '';
                }
            }
            $matrix[] = $line;           
        }
        return $matrix;
    }
}
