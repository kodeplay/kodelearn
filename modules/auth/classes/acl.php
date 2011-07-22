<?php defined('SYSPATH') or die('No direct access allowed.');

class Acl {

    /**
     * Acl Singleton instance
     */
    private static $_instance = null;

    /**
     * Array of permissions as follows
     * array(
     *     'r1' => array('level1', ....),
     *     'r2' => ...
     * )
     */
    private $_permissions = array();

    private static $REPR_SEPARATOR = '_';

    /**
     * @return Acl
     */
    public static function instance() {
        if (self::$_instance === null) {
            self::$_instance = new Acl();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->load();
    }

    /**
     * Method will load the permissions for the current user from its
     * role and store it in the $_permissions array. If the user is not 
     * logged in, just return
     */
    private function load() {
        $user = Auth::instance()->get_user();
        if ($user === NULL) {
            return;
        }
        $role = ORM::factory('role', $user->roles->find());
        $permissions = $role->permissions && $role->permissions !== NULL ? unserialize($role->permissions) : array();
        $this->_permissions = self::acl_array($permissions);
    }

    /**
     * A normal getter for the permissions
     * @return Array 
     */
    public function permissions() {
        return $this->_permissions;
    }

    /**
     * Method to reload the permissions data from the db
     */
    public function reload() {
        $this->load();
    }

    /**
     * @param String $repr_key of type resource_action viz. user_create
     * @return Boolean whether the current user has the permission to 
     * carry out the action on the resource.
     */
    public function is_allowed($repr_key) {
        list($resource, $action) = self::split_repr_key($repr_key);
        return $this->_permissions[$resource][$action];
    }

    /**
     * @param String $resource
     * Check whether the given resource can be accessed by the user for 
     * atleast one level. Return false if the user cannot access that page
     * for any of the level
     */
    public function has_access($resource) {
        if (Acl_Config::is_resource_ignored($resource)) {
            return true;
        }
        $levels = $this->_permissions[$resource];
        foreach ($levels as $level=>$permit) {
            // if atleast one is permitted then allow access
            if ($permit) {
                return true;
            }
        }
        return false;
    }

    /**
     * Method to get the array representation of permissions
     * key will be of pattern <resource>_<action> and value will be boolean
     * @param mixed $resource = NULL (optional) if specified, permissions array for 
     * only this resource will be returned else permissions for all the resources
     * will be returned
     * @return Array 
     */
    public function as_array($resource = NULL) {
        if ($resource !== NULL) {
            return $this->_repr($resource);
        }
        $permissions = array();
        foreach ($this->_permissions as $resource=>$levels) {
            $permissions = array_merge($permissions, self::repr_key($resource));
        }
        return $permissions;
    }

    /**
     * For a resource, create a representational array from the $_permissions
     * array
     * @param String $resource
     * @param Array $repr
     */
    private function _repr($resource) {
        $repr = array();
        foreach ($this->_permissions[$resource] as $level=>$flag) {
            $repr[self::repr_key($resource, $level)] = $flag;
        }
        return $repr;
    }
    
    /**
     * @param String $resource
     * @param String #level
     * @return String representational key for this resource level combination
     * eg. resource = batch, level = update, repr_key = batch_update
     */
    public static function repr_key($resource, $level) {
        return $resource . self::$REPR_SEPARATOR . $level;
    }

    /**
     * Converts the representational key back to an array of resource and action
     * @param String $repr_key eg. user_create
     * @return Array array(<resource>, <action>)
     */
    public static function split_repr_key($repr_key) {
        return explode(self::$REPR_SEPARATOR, $repr_key, 2);        
    }

    /**
     * convert the permissions array stored in the database (unserialized) into
     * a config array with resource > level depth
     * @return Array $arr
     */
    public static function acl_array($permissions) {
        $config_acl = Acl_Config::instance()->acl();
        $arr = array();
        foreach ($config_acl as $resource=>$levels) {
            $arr[$resource] = array();
            foreach ($levels as $level) {
                $key = self::repr_key($resource, $level);
                $arr[$resource][$level] = array_key_exists($key, $permissions);
            }
        }
        return $arr;
    }
}