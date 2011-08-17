<?php defined('SYSPATH') or die('No direct script access.');

class Model_Batch extends ORM {
    
    public function validator($data) {
        return Validation::factory($data)
            ->rule('name', 'not_empty')
            ->rule('name', 'min_length', array(':value', 3))
            ->rule('description', 'not_empty');
    }

    protected $_has_many = array(
        'users' => array(
            'model'   => 'user',
            'through' => 'batches_users',
        ),
    );

    /**
     * Method to get the students assigned to this batch
     * ie from all users assigned to this batch, get only those that have
     * 'student' as their role.
     * @param mixed $course (int/Model_Batch)
     * @param Database_MySQL_Result $students
     */
    public static function get_students($batch) {
        $batch = $batch instanceof Model_Batch ? $batch : ORM::factory('batch', (int)$batch);
        if (is_int($batch)) {
            $batch = ORM::factory('batch', $batch);
        }
        $role = Model_Role::from_name('student');
        $students = $batch->users
            ->join('roles_users', 'INNER')
            ->on('users.id', ' = ', 'roles_users.user_id')
            ->where('roles_users.role_id', ' = ', $role->id)            
            ->find_all();
        return $students;
    }
}
