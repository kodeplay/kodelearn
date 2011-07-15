<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * @author Team Kodeplay
 * Class to load the Acl config from the file and process it into
 * a usable array
 */
class Acl_Config {

    private static $_instance;

    public static function instance() {
        if (self::$_instance === null) {
            self::$_instance = new Acl_Config();
        }
        return self::$_instance;
    }

    /**
     * The raw config array as it is in the config file
     */
    private $_config = array();

    /**
     * The processed acl array
     */
    private $_acl = array();

    /**
     * Array of default access levels which all resources will inherit
     */
    private $_default = array();    

    /**
     * @param String $file (optional) The filename of the config file to load config from
     */
    public function __construct($file = 'acl') {
        $this->_config = Kohana::config('acl');
        $this->_acl = $this->_config->getArrayCopy();
        $this->_default = array_shift($this->_acl);
        foreach ($this->_acl as $resource=>$levels) {
            $this->merge_levels($resource, $levels);
        }
    }
    
    /**
     * Method to merge the default access levels with the resource
     * specific access levels
     * @param String $resource
     * @param mixed (string|array) $levels 
     * @throws Acl_Exception if resource not found in config
     */
    public function merge_levels($resource, $levels) {
        if (!isset($this->_acl[$resource])) {
            throw new Acl_Exception('Resource ' . $resource . ' not found in config file');
        }
        if (is_array($levels)) {
            $this->_acl[$resource] = array_merge($this->_default, $levels);
        } else {
            $this->_acl[$resource][] = $levels;
        }
    }

    /**
     * Getter for $_default
     * @return array 
     */
    public function get_default() {
        return $this->_default;
    }
    
    /**
     * Getter for $_config
     * @return array 
     */
    public function config() {
        return $this->_config;
    }

    /**
     * Getter for $_acl
     * @param String $resource (optional)
     * @return array 
     * @throws Acl_Exception if resource not found in config
     */
    public function acl($resource = null) {
        if ($resource !== null) {
            if (isset($this->_acl[$resource])) {
                return $this->_acl[$resource];
            } else {
                throw new Acl_Exception('Resource ' . $resource . ' not found in config file');
            }
        }
        return $this->_acl;
    }
}