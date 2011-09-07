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
            ->rule('firstname', 'not_empty')
            ->rule('lastname', 'not_empty');
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
        $parent = ORM::factory('user', $this->parent_user_id);
        $forgot_password_string = md5($parent->email.time());
        $parent->forgot_password_string = $forgot_password_string;
        $parent->save(); 
        
        $subject = "Parent email";
        $message  = "<b>Dear ". $parent->firstname ." ". $parent->lastname .",<br><br>";
        $message .= "Your child '". $this->firstname ." ". $this->lastname ."' has registered on Kodelearn. <br>The link to access your account is ".Url::site("auth")." <br>";
        $message .= "User name : ". $parent->email ."<br>"; 
        $message .= "Set password first : ". Url::site("auth/changepassword/u/".$forgot_password_string); 

        $message .=  "<br><br>Thanks,<br> Kodelearn team";
        $html = true;
        Email::send_mail($parent->email, $subject, $message, $html);
    }

    
    public function send_user_email(){
        $user = ORM::factory('user', $this->id);
        if($user->status == '1'){
            $forgot_password_string = md5($user->email.time());
            $user->forgot_password_string = $forgot_password_string;
            $user->save(); 
            
            $message  = "<b>Dear ". $user->firstname ." ". $user->lastname .",<br><br>";
            $message .= "Your account has been created on Kodelearn. <br>The link to access your account is ".Url::site("auth")." <br>";
            $message .= "User name : ". $user->email ."<br>"; 
            $message .= "Set password first : ". Url::site("auth/changepassword/u/".$forgot_password_string); 
        } else {
            $message  = "<b>Dear ". $user->firstname ." ". $user->lastname .",<br><br>";
            $message .= "Your account has been created on Kodelearn. <br>But it is waiting for admin approval <br>";
            
        }
        $subject = "User registration email";
        $message .=  "<br><br>Thanks,<br> Kodelearn team";
        $html = true;
        Email::send_mail($user->email, $subject, $message, $html);
    }    


    public function send_child_email(){
        $child = ORM::factory('user')->where('parent_user_id', '=', $this->id);
        $forgot_password_string = md5($child->email.time());
        $child->forgot_password_string = $forgot_password_string;
        $child->save(); 
        
        $subject = "Child email";
        $message  = "<b>Dear ". $child->firstname ." ". $child->lastname .",<br><br>";
        $message .= "Your parent '". $this->firstname ." ". $this->lastname ."' has registered on Kodelearn. <br>The link to access your account is ".Url::site("auth")." <br>";
        $message .= "User name : ". $child->email ."<br>"; 
        $message .= "Set password first : ". Url::site("auth/changepassword/u/".$forgot_password_string); 

        $message .=  "<br><br>Thanks,<br> Kodelearn team";
        $html = true;
        Email::send_mail($child->email, $subject, $message, $html);

    }
}