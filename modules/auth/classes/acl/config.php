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

    private static $ignoredControllers = array(
        'auth',
        'base',
        'home',
        'rest',
        'template',
        'unittest',
        'welcome',
        'error',
        'purifer',
    );

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
        $this->_default = $this->_acl['default'];
        unset($this->_acl['default']);
        $this->merge_ignored()
            ->merge_resources()
            ->merge_default_levels();
    }

    public function merge_ignored() {
        foreach ($this->_config as $resource=>$config) {
            if (!empty($config['ignore'])) {
                self::$ignoredControllers[] = $resource;
                // remove this resource from the $this->_acl array
                unset($this->_acl[$resource]);
            }
        }
        return $this;
    }

    /**
     * Method to merge resources
     * It finds out all the controllers and adds the basenames to the acl config array
     * as resources only if the key doesnot already exists
     */
    private function merge_resources() {
        $controllers = Kohana::list_files('classes/controller');
        // controllers can also be nested, so just flatten the array
        $controllers = Arr::flatten($controllers);
        foreach ($controllers as $controller) {            
            $resource = basename($controller, '.php');
            if (self::is_resource_ignored($resource) || array_key_exists($resource, $this->_acl)) {
                continue;
            }
            $this->_acl[$resource] = array();
        }
        ksort($this->_acl);
        return $this;
    }

    /**
     * Method to merge the default levels into all the resources
     * Hence it must be called after merging resources
     * in cas e the inherit_defaults flag exists and set to false, defaults will not be merged
     */
    public function merge_default_levels() {
        foreach ($this->_acl as $resource=>$config) {
            $levels = Arr::get($config, 'levels', array());
            $inherit_default = Arr::get($config, 'inherit_default', true);
            if (!$inherit_default) {
                $this->_acl[$resource] = $levels;
                continue;
            }
            $this->_acl[$resource] = array_merge($this->_default, $levels);
        }
        return $this;
    }
    
    /**
     * Method to merge other access levels with the already existing access levels
     * for a resource on the fly
     * @param String $resource
     * @param mixed (string|array) $levels 
     * @throws Acl_Exception if resource not found in config
     */
    public function merge_levels($resource, $levels) {
        if (!isset($this->_acl[$resource])) {
            throw new Acl_Exception('Resource ' . $resource . ' not found in config file');
        }
        if (is_array($levels)) {
            $this->_acl[$resource] = array_merge($this->_acl[$resource], $levels);
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

    public static function is_resource_ignored($resource) {
        return in_array($resource, self::$ignoredControllers);
    }
}