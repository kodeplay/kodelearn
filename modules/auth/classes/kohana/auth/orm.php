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
    protected function _login($email, $password, $remember=FALSE) {
        $user = ORM::factory('user');
        $user->where('email', ' = ', $email)
            ->and_where('password', ' = ', $password)
            ->find();
        // TODO remember to be done
        if ($user !== null) {
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

} // End Auth File