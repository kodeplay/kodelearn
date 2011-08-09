<?php defined('SYSPATH') or die('No direct script access.');

class Model_Examresult extends ORM {

    protected $_belongs_to = array(
        'users' => array(),
        'exams' => array(),
    );

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

