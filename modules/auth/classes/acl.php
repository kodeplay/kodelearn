<?php defined('SYSPATH') or die('No direct access allowed.');

class Acl {

    private static $_instance = null;

    private $_config;    
    
    private $_user;

    private $_permissions;

    private $_user_permissions;

    public static function instance() {
        if (self::$_instance === null) {
            self::$_instance = new Acl();
        }
        return self::$_instance;
    }

    public function __construct() {
        $this->_config = Acl_Config::instance();
        $this->_user = Auth::instance()->get_user();
        $this->load();
    }

    private function load() {
        $role = ORM::factory('role', $this->_user->roles->find());
        $permissions = $role->permissions && $role->permissions !== NULL ? unserialize($permissions) : array();
        $config_acl = $this->_config->acl();        
        foreach ($config_acl as $resource=>$levels) {
            $this->_permissions[$resource] = array();
            foreach ($levels as $level) {
                $key = $this->_repr_key($resource, $level);
                $this->_permissions[$resource][$level] = in_array($key, $permissions);
            }
        }
    }

    /**
     * 
     */
    public function user_permissions_ui() {
        $arr = array();
        foreach ($this->_permissions as $resource=>$levels) {
            $arr[$resource] = array();
            $text_resource = Kohana::message('acl', $resource);
            foreach ($levels as $level=>$permission) {
                $arr[$resource][$level] = array(
                    'resource' => $text_resource,
                    'level' => Inflector::humanize($level),
                    'permission' => $permission,
                    'repr_key' => $this->_repr_key($resource, $level),
                );
            }
        }
        return $arr;
    }

    public function reload() {
        $this->load();
    }

    public function is_allowed($repr_key) {
        list($resource, $action) = explode("_", $repr_key, 2);
        return $this->_permissions[$resource][$action];
    }

    public function permissions($resource = NULL) {
        if ($resource !== NULL) {
            return $this->_repr($resource);
        }
        $permissions = array();
        foreach ($this->_permissions as $resource=>$levels) {
            $permissions = array_merge($permissions, $this->_repr($resource));
        }
        return $permissions;
    }

    private function _repr($resource) {
        $repr = array();
        foreach ($this->_permissions[$resource] as $level=>$flag) {
            $repr[$this->_repr_key($resource, $level)] = $flag;
        }
    }

    private function _repr_key($resource, $level) {
        return $resource . '_' . $level;
    }    
}