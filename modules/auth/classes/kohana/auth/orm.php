<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * File Auth driver.
 * [!!] this Auth driver does not support roles nor autologin.
 *
 * @package    Kohana/Auth
 * @author     Kohana Team
 * @copyright  (c) 2007-2010 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class Kohana_Auth_ORM extends Auth {


    /**
     * Constructor loads the user list into the class.
     */
    public function __construct($config = array()) {
        parent::__construct($config);
    }

    /**
     * Logs a user in.
     *
     * @param   string   email
     * @param   string   password
     * @param   boolean  enable autologin 
     * @return  Model_User user
     */
    protected function _login($email, $password, $remember) {
       
        $user = ORM::factory('user');
        $user->where('email', ' = ', $email)
            ->and_where('password', ' = ', $password)
            ->and_where('status', ' = ', 1)
            ->find();            
        // TODO remember to be done
        if ($user->id !== null) {
            
            if ($remember === TRUE)
                {
                    // Create a new autologin token
                    $token = ORM::factory('user_token');
    
                    // Set token data
                    $token->user_id = $user->id;
                    $token->expires = time() + $this->_config['lifetime'];
                    $token->save();
    
                    // Set the autologin cookie
                   
                    cookie::set('authautologin', $token->token, $this->_config['lifetime']);
                    
                }
            
            
            $this->complete_login($user);
            return true;
        } else {
            return false;
        }
    }

    public function password($email) {

    }

    public function check_password($password) {

    }

    public function can($action) {
        
    }

} // End Auth File