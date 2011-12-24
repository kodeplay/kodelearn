<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class to handle the sending of notices to students etc
 * Notices will be sent through the media - email and sms
 * 
 */
class Notice {

    private $_preferences = array();

    private $_config = array();

    public static $MEDIA = array('email', 'sms');

    private static $_instance;

    public static function instance() {
        if (null == self::$_instance) {
            self::$_instance = new Notice();
        }
        return self::$_instance;
    }

    public function __construct() {
        $noticesettings = ORM::factory('noticesetting')
            ->where('institution_id' , ' = ', 1)
            ->find();
        $preferences = unserialize($noticesettings->preferences ? $noticesettings->preferences : serialize(array()));
        $this->_preferences['email'] = array_keys(Arr::get($preferences, 'email', array()));
        $this->_preferences['sms'] = array_keys(Arr::get($preferences, 'sms', array()));
        $this->load_config();
    }

    private function load_config() {
        $config = Kohana::config('notices')->as_array();
        foreach ($config as $k=>$v) {
            $this->_config = array_merge($this->_config, array($k => array_keys($v)));
        }
    }

    /**
     * Method to check the preference for a particular action-medium combination
     * @param String $action of type - exam_create
     * @param String $medium = ('email', 'sms')
     * @return Boolean whether to send the notice or not
     */
    public function check_preference($action, $medium='email') {
        return in_array($action, $this->_preferences[$medium]);
    }

    /**
     * Simple getter for preferences array with the optional medium param
     * @param String medium = ('email', 'sms')
     * @return Array
     */
    public function preferences($medium=null) {
        if ($medium !== null) {
            if (!in_array($medium, self::$MEDIA)) {
                throw new Kohana_Exception('unknown medium ' . $medium);
            }
            return Arr::get($this->_preferences, $medium);
        }
        return $this->_preferences;
    }

    /**
     * Method to register a n handler for sending notices
     * Handler is a class in the module with the namespace Notice_
     * @param String $mod
     * @return Notice
     */
    public function register_handler($mod) {
        $class = 'Notice_' . ucfirst($mod);
        $this->register_callbacks($mod, $class);
    }

    /**
     * Method for registering callback methods for a particular action and a particular
     * @param String $action underscore separated string 'exam_add'
     * @param String $handlerClass - Name of the class in which the static callback methods are grouped per module
     * @return Notice $this
     */
    public function register_callbacks($mod, $handlerClass) {
        foreach ($this->_config[$mod] as $conf) {
            $action = $mod . '_' . $conf;
            $event = Event::instance($action);
            foreach (self::$MEDIA as $m) {
                $callback = $m . '_' . $conf;
                if ($this->check_preference($action, $m) && method_exists($handlerClass, $callback)) {
                    $event->callback(array($handlerClass, $callback));
                }
            }            
        }
    }    

    /**
     * Method to return the array of email recipients
     * @param Database_MySQL_Result
     * @return array of firstnames and emails of the recipients
     */
    public static function email_recipients(Database_MySQL_Result $users) {
        $users = $users->as_array();
        $recipients = array();
        if ($users) {
            foreach ($users as $user) {
                $recipients[] = array(
                    'firstname' => $user->firstname,
                    'email' => $user->email,
                );
            }
        }
        return $recipients;        
    }

    public static function email($users, $subject, $body) {
        if ($users instanceof Database_MySQL_Result) {
            $users = self::email_recipients($users);
        }
        $sender = Model_Noticesetting::settings()->sender_email;
        // decoratedmail not used because decorator plugin of swiftmailer is buggy and needs fixing
        // Email::decoratedmail($users, $sender, $subject, $body);
        Email::templatedmail($users, $sender, $subject, $body);
    }    
}
