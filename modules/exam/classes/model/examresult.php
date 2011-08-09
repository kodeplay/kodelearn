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

    /**
     * Method to delete a row from the examresults table.
     * @param int $user_id
     * @param int $exam_id
     */
    public static function delete_row($user_id, $exam_id) {
        DB::delete('examresults')
            ->where('user_id', ' = ', $user_id)
            ->and_where('exam_id', ' = ', $exam_id)
            ->execute();
    }

    /**
     * Method to save the marks of students in the store_user table for an exam
     * @param int $exam_id
     * @param $results (key = user_id, value = marks scored in the exam identified by $exam_id)
     * @return null
     */
    public static function save_results($result_sets) {
        if (!$result_sets) {
            return;
        }
        $db_keys = array_keys($result_sets[0]);
        $query = DB::insert('examresults', $db_keys);
        foreach ($result_sets as $result) {
            self::delete_row($result['user_id'], $result['exam_id']);
            $query->values(array_values($result));
        }
        $query->execute();
    }
}

