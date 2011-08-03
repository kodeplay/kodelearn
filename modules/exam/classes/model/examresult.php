<?php defined('SYSPATH') or die('No direct script access.');

class Model_Examresult extends ORM {

    protected $_belongs_to = array(
        'users' => array(),
        'exams' => array(),
    );

    /**
     * Method to import data from csv file to database
     * @param array $data array of comma exploded arrays of each line in csv
     *        does not include the heading (first) line of the csv
     * @param array $exams {keys = Exam Name, values = Exam Id}
     */
    public static function csv_import($data, $exams) {
        // order in which the values in the value sets will be specifie in the DB::insert query
        $db_keys = array(
            'exam_id', 'user_id', 'marks'
        );
        foreach ($data as $row) {
            $user_id = $row[0];
            $marks = array_slice($row, 2);
            $value_sets = array();
            foreach ($marks as $k=>$m) {
                $exam_id = $exams[$k];
                // delete all examresults for this user first
                DB::delete('examresults')
                    ->where('user_id', ' = ', $user_id)
                    ->and_where('exam_id', ' = ', $exam_id)
                    ->execute();
                // append to the values array to be added later
                $value_sets[] = array(
                    $exam_id,
                    $user_id,
                    $m
                );
            }
            $query = DB::insert('examresults', $db_keys);
            foreach ($value_sets as $values) {
                $query->values($values);
            }
            $query->execute();
        }
    }
}

