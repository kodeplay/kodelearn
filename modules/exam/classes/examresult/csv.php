<?php defined('SYSPATH') or die('No direct script access.');

class Examresult_Csv {

    private $file;

    /**
     * @param array $files_arr eg. $_FILES['csv']
     */
    public function __construct($files_arr) {
        $this->file = $files_arr;
    }

    /**
     * Method to validate the file uploaded. 
     * @return boolean if its a csv file
     */
    public function validate() {
        $filename = $this->file['name'];
        $extension = explode(".",$filename);
        return (isset($extension[1]) && strtolower($extension[1]) === "csv");
    }

    /**
     * Method to read the csv file uploaded and return the content
     * @return array $filedata
     */
    public function content() {
        $filename = $this->file['tmp_name'];
        $handle = fopen($filename, "r");        
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE){
            $filedata[] = $data;
        }
        return $filedata;
    }

    /*
     * Method to get the matrix which will be finally put into the css
     * @param array $students keys = student_ids, values = Student Names
     * @param array $exams {keys = exam_ids, values = Exam Names}
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

    /**
     * Method to get the ordered list of exam_ids from the first line 
     * of the csv 
     * @param array $csv_headings First line of the csv file
     * @param array $exams {keys = Exam Names, values = Exam Ids}
     * @return array of exam_ids in the order in which they appear in the 
     */
    public static function ordered_exams($csv_headings, $exams) {
        // remove the first two headings and get only exam headings
        $exam_names = array_slice($csv_headings, 2);
        $ordered_exams = array();
        foreach ($exam_names as $exam_name) {
            $ordered_exams[] = $exams[$exam_name];
        }
        return $ordered_exams;
    }
}
