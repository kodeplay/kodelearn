<?php defined('SYSPATH') or die('No direct script access.');

class Model_User extends ORM {

    protected $_has_many = array(
        'batches' => array(
            'model'   => 'batch',
            'through' => 'batches_users',
        ),
        'courses' => array(
            'model'   => 'course',
            'through' => 'courses_users',
        ),
        'roles' => array(
            'model'   => 'role',
            'through' => 'roles_users',
        ),
    );

    /**
     * Method to get the fullname of the user
     * @return String fullname
     */
    public function fullname() {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getstatus() {
        if($this->status == "1"){
            return "Yes";
        } else {
            return "No";
        }
    }

    /**
     * Method to get the role of the user
     * @return Model_Role
     */
    public function role() {
        return $this->roles->find();
    }

    /**
     * Method to get all the batches to which this user belongs
     * @return Database_MySQL_Result $batches
     */
    public function batches() {
        return $this->batches->find_all();
    }

    /**
     * Method to get all the courses to which this user has access
     * @return Database_MySQL_Result $courses
     */
    public function courses() {
        return $this->courses->find_all();
    }

    /**
     * Method to confirm the role of the user
     * @param String $role_name - Name of the role to confirm
     * @return Boolean Whether the role is correct
     */
    public function is_role($role_name) {
        return strtolower($this->role()->name) === strtolower($role_name);
    }

    public function __toString() {
        return $this->fullname();
    }

    /**
     * Method to check that the user is currently logged in user
     */
    public function is_current() {
        $current = Auth::instance()->get_user();
        return $this->id === $current->id;
    }

    public function validator_login($data) {
        return Validation::factory($data)
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('password', 'not_empty');
    }

    public static function validate_parent_email($parent_email, $email){
    	return ($parent_email !== $email);
    }

    public function validator_register($data) {
        return Validation::factory($data)
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('email', 'Model_User::email_unique')
            ->rule('email_parent', 'not_empty')
            ->rule('email_parent', 'Model_User::validate_parent_email', array(':value', ':email'))
            ->rule('email_parent', 'email')
            ->rule('firstname', 'not_empty')
            ->rule('lastname', 'not_empty')
            ->rule('parentname', 'not_empty')
            ->rule('password', 'not_empty')
            ->rule('password', 'min_length', array(':value', 8))
            ->rule('confirm_password', 'matches', array(':validation', ':field', 'password'))
            ->rule('agree', 'not_empty');
    }

    public function validator_register_admin($data) {
        return Validation::factory($data)
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('email', 'Model_User::email_unique')
            ->rule('firstname', 'not_empty')
            ->rule('lastname', 'not_empty')
            ->rule('password', 'not_empty')
            ->rule('password', 'min_length', array(':value', 8))
            ->rule('confirm_password', 'matches', array(':validation', ':field', 'password'))
            ->rule('agree', 'not_empty');
    }

    public function validator_parent_register($data) {
        return Validation::factory($data)
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('email', 'Model_User::email_unique')
            ->rule('email_child', 'not_empty')
            ->rule('email_child', 'Model_User::validate_parent_email', array(':value', ':email'))
            ->rule('email_child', 'email')
            ->rule('firstname', 'not_empty')
            ->rule('lastname', 'not_empty')
            ->rule('childname', 'not_empty')
            ->rule('password', 'not_empty')
            ->rule('password', 'min_length', array(':value', 8))
            ->rule('confirm_password', 'matches', array(':validation', ':field', 'password'))
            ->rule('agree', 'not_empty');
    }

    public function validator_create($data){

    	return Validation::factory($data)
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('email', 'Model_User::email_unique', array(':value',':user'))
            ->rule('firstname', 'not_empty');
    }

    public function validator_profile($data){
    	return Validation::factory($data)
    	   ->rule('email', 'not_empty')
    	   ->rule('email', 'email')
    	   ->rule('email', 'Model_User::email_unique', array(':value',':user'))
    	   ->rule('firstname', 'not_empty')
           ->rule('confirm_password', 'matches', array(':validation', ':field', 'password'))
    	   ->rule('lastname', 'not_empty');
    }

    public static function email_unique($email, $user_object = NULL) {
        $user = ORM::factory('user');

        $user->where('email', ' = ', $email);
        if($user_object !== NULL)
            $user->where('id', '!=', $user_object->id);
        $user->find();
        return ($user->id === null);
    }

    public function validator_forgot_password($data) {

        return Validation::factory($data)
            ->rule('email', 'not_empty')
            ->rule('email', 'email')
            ->rule('email', 'Model_User::email_exist');

    }

    public function validator_changepassword($data) {

        return Validation::factory($data)
            ->rule('password', 'not_empty')
            ->rule('password', 'min_length', array(':value', 8))
            ->rule('confirm_password', 'matches', array(':validation', ':field', 'password'));

    }

    public static function email_exist($email) {
        $user = ORM::factory('user');

        $user->where('email', '=', $email);

        $user->find();

        return ($user->id !== null);
    }

    public function send_parent_email(){
        if (!$this->is_role('student')) {
            throw new Exception('Invalid Role');
        }
        $parent = ORM::factory('user', $this->parent_user_id);
        if($parent->status == '1'){
            $forgot_password_string = md5($parent->email.time());
            $parent->forgot_password_string = $forgot_password_string;
            $parent->save();
            $file = "parent_approved_email";
            $data =array(
                '{parent_name}'  => $parent->firstname ." ". $parent->lastname,
                '{url}'   => Url::site("auth"),
                '{child_name}'   => $this->firstname ." ". $this->lastname,
                '{parent_email}' => $parent->email,
                '{password_url}' => Url::site("auth/changepassword/u/".$forgot_password_string),
            );

        } else {
            $file = "parent_unapproved_email";
            $data =array(
                '{parent_name}'  => $parent->firstname ." ". $parent->lastname,
                '{child_name}'   => $this->firstname ." ". $this->lastname,
                '{parent_email}' => $parent->email,

            );

        }
        Email::send_mail($parent->email, $file, $data);
    }


    public function send_user_email(){
        $user = ORM::factory('user', $this->id);
        if($user->status == '1'){
            $forgot_password_string = md5($user->email.time());
            $user->forgot_password_string = $forgot_password_string;
            $user->save();
            $file = "user_approved_email";
            $data =array(
                '{user_name}'  => $user->firstname ." ". $user->lastname,
                '{url}'   => Url::site("auth"),
                '{user_email}' => $user->email,
                '{password_url}' => Url::site("auth/changepassword/u/".$forgot_password_string),
            );
        } else {
            $file = "user_unapproved_email";
            $data =array(
                '{user_name}'  => $user->firstname ." ". $user->lastname,

            );
        }
        Email::send_mail($user->email, $file, $data);
    }


    public function send_child_email() {
        if (!$this->is_role('parent')) {
            throw new Exception('Invalid Role');
        }
        $child = ORM::factory('user')->where('parent_user_id', '=', $this->id)->find();
        if($child->status == '1'){
            $forgot_password_string = md5($child->email.time());
            $child->forgot_password_string = $forgot_password_string;
            $child->save();
            $file = "child_approved_email";
            $data =array(
                '{child_name}'  => $child->firstname ." ". $child->lastname,
                '{url}'   => Url::site("auth"),
                '{parent_name}'   => $this->firstname ." ". $this->lastname,
                '{child_email}' => $child->email,
                '{password_url}' => Url::site("auth/changepassword/u/".$forgot_password_string),
            );

        } else {
            $file = "child_unapproved_email";
            $data =array(
                '{parent_name}'  => $parent->firstname ." ". $parent->lastname,
                '{child_name}'   => $this->firstname ." ". $this->lastname,
                '{parent_email}' => $parent->email,

            );

        }
        Email::send_mail($child->email, $file, $data);
    }

    public static function users_total($filters=array()) {

        $user = ORM::factory('user');
        if (isset($filters['filter_id'])) {
            $user->where('users.id', '=', (int) $filters['filter_id'] );
        }
        if (isset($filters['filter_name'])) {
            $user->and_where_open()
                ->where('users.firstname', 'LIKE', '%' . $filters['filter_name'] . '%')
                ->or_where('users.lastname', 'LIKE', '%' . $filters['filter_name'] . '%')
                ->and_where_close();
        }
        if (isset($filters['filter_approved'])) {
            $filter_approved = $filters['filter_approved'];
            if($filters['filter_approved'] == "yes" || $filters['filter_approved'] == "Yes" || $filters['filter_approved'] == "YES" || $filters['filter_approved'] == "Y" || $filters['filter_approved'] == "YE" || $filters['filter_approved'] == "y" || $filters['filter_approved'] == "ye")  {
                $filter_approved = '1';
            } else if($filters['filter_approved'] == "no" || $filters['filter_approved'] == "No" || $filters['filter_approved'] == "NO" || $filters['filter_approved'] == "N" || $filters['filter_approved'] == "n") {
                $filter_approved = '0';
            }
            $user->where('users.status', '=', (int) $filter_approved );
        }

        return $user->count_all();
    }

    public static function users($filters=array()) {

        $user = ORM::factory('user');

        if (isset($filters['filter_id'])) {
            $user->where('users.id', '=', (int) $filters['filter_id'] );
        }
        if (isset($filters['filter_name'])) {
            $user->and_where_open()
                ->where('users.firstname', 'LIKE', '%' . $filters['filter_name'] . '%')
                ->or_where('users.lastname', 'LIKE', '%' . $filters['filter_name'] . '%')
                ->and_where_close();
        }
        if (isset($filters['filter_approved'])) {
            $filter_approved = $filters['filter_approved'];
            if($filters['filter_approved'] == "yes" || $filters['filter_approved'] == "Yes" || $filters['filter_approved'] == "YES" || $filters['filter_approved'] == "Y" || $filters['filter_approved'] == "YE" || $filters['filter_approved'] == "y" || $filters['filter_approved'] == "ye")  {
                $filter_approved = '1';
            } else if($filters['filter_approved'] == "no" || $filters['filter_approved'] == "No" || $filters['filter_approved'] == "NO" || $filters['filter_approved'] == "N" || $filters['filter_approved'] == "n") {
                $filter_approved = '0';
            }
            $user->where('users.status', '=', (int) $filter_approved );
        }
        if (isset($filters['sort'])) {
            $user->order_by($filters['sort'], Arr::get($filters, 'order', 'ASC'));
        }
        if (isset($filters['limit'])) {
            $user->limit($filters['limit'])
                ->offset(Arr::get($filters, 'offset', 0));
        }
        return $user->find_all();
    }

    public static function users_total_batch($filters=array()) {

        $user = ORM::factory('user')
            ->join('batches_users','left')
            ->on('batches_users.user_id','=','users.id')
            ->join('batches','left')
            ->on('batches_users.batch_id','=','batches.id');
        $user->where('batches.name', 'like', '%'. $filters['filter_batch'].'%' );
        $user->group_by('users.id');

        $users = $user->find_all()->as_array(null,'id');

        return count($users);
    }

    public static function users_batch($filters=array()) {

        $user = ORM::factory('user')
            ->join('batches_users','left')
            ->on('batches_users.user_id','=','users.id')
            ->join('batches','left')
            ->on('batches_users.batch_id','=','batches.id');
        $user->where('batches.name', 'like', '%'. $filters['filter_batch'].'%' );
        $user->group_by('users.id');
        if (isset($filters['sort'])) {
            $user->order_by($filters['sort'], Arr::get($filters, 'order', 'ASC'));
        }
        if (isset($filters['limit'])) {
            $user->limit($filters['limit'])
                ->offset(Arr::get($filters, 'offset', 0));
        }
        return $user->find_all();
    }

    public static function users_total_course($filters=array()) {

        $user = ORM::factory('user')
            ->join('courses_users','left')
            ->on('courses_users.user_id','=','users.id')
            ->join('courses','left')
            ->on('courses_users.course_id','=','courses.id');
        $user->where('courses.name', 'like', '%'. $filters['filter_course'].'%' );
        $user->group_by('users.id');

        $users = $user->find_all()->as_array(null,'id');

        return count($users);
    }

    public static function users_course($filters=array()) {
        $user = ORM::factory('user')
            ->join('courses_users','left')
            ->on('courses_users.user_id','=','users.id')
            ->join('courses','left')
            ->on('courses_users.course_id','=','courses.id');
        $user->where('courses.name', 'like', '%'. $filters['filter_course'].'%' );
        $user->group_by('users.id');
        if (isset($filters['sort'])) {
            $user->order_by($filters['sort'], Arr::get($filters, 'order', 'ASC'));
        }
        if (isset($filters['limit'])) {
            $user->limit($filters['limit'])
                ->offset(Arr::get($filters, 'offset', 0));
        }
        return $user->find_all();
    }

    public static function users_total_role($filters=array()) {

        $user = ORM::factory('user')
            ->join('roles_users','left')
            ->on('roles_users.user_id','=','users.id')
            ->join('roles','left')
            ->on('roles_users.role_id','=','roles.id');
        $user->where('roles.name', 'like', '%'. $filters['filter_role'].'%' );
        $user->group_by('users.id');

        $users = $user->find_all()->as_array(null,'id');

        return count($users);
    }

    public static function users_role($filters=array()) {

        $user = ORM::factory('user')
            ->join('roles_users','left')
            ->on('roles_users.user_id','=','users.id')
            ->join('roles','left')
            ->on('roles_users.role_id','=','roles.id');
        $user->where('roles.name', 'like', '%'. $filters['filter_role'].'%' );
        $user->group_by('users.id');
        if (isset($filters['sort'])) {
            $user->order_by($filters['sort'], Arr::get($filters, 'order', 'ASC'));
        }
        if (isset($filters['limit'])) {
            $user->limit($filters['limit'])
                ->offset(Arr::get($filters, 'offset', 0));
        }
        return $user->find_all();
    }

    public static function filtered_users($course_id, $batch_id, $roles) {
        $users = ORM::factory('user');
        if ($course_id) {
            $users->join('courses_users', 'INNER')
                ->on('users.id', '=', 'courses_users.user_id');
        }
        if ($batch_id) {
            $users->join('batches_users', 'INNER')
                ->on('users.id', '=', 'batches_users.user_id');
        }
        if ($roles) {
            $users->join('roles_users', 'INNER')
                ->on('users.id', ' = ', 'roles_users.user_id');
        }
        // where clauses for each case
        if ($course_id) {
            $users->where('courses_users.course_id', '=', (int)$course_id);
        }
        if ($batch_id) {
            $users->where('batches_users.batch_id', '=', (int)$batch_id);
        }
        if ($roles) {
            $users->where('roles_users.role_id', ' IN ', $roles);
        }
        return $users->find_all();
    }
}