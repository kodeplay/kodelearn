<?php defined('SYSPATH') or die('No direct script access.');

/**
 * This class has been modified by Kodeplay to override the 
 * behavious of the Kohana_Config_Database class
 */
class Config_Database extends Kohana_Config_Database {

    /**
     * Using a different database name "setting" instead of "config"
     */
    protected $_database_table = 'setting';

    public function __construct(array $config = NULL) {
        parent::__construct($config);
    }

    /**
     * Query the configuration table for all values for this group and
     * get the values. 
     * Here the values are not serialized.
     *
     * @param   string  group name
     * @param   array   configuration array
     * @return  $this   clone of the current object
     */
    public function load($group, array $config = NULL)
    {
        if ($config === NULL AND $group !== 'database')
            {
                // Load all of the configuration values for this group
                $query = DB::select('config_key', 'config_value')
                    ->from($this->_database_table)
                    ->where('group_name', '=', $group)
                    ->execute($this->_database_instance);

                if (count($query) > 0)
                    {
                        $config = $query->as_array('config_key', 'config_value');
                    }
            }

        return parent::load($group, $config);
    }

    /**
     * Overload setting offsets to insert or update the database values as
     * changes occur.
     *
     * @param   string   array key
     * @param   mixed    new value
     * @return  mixed
     */
    public function offsetSet($key, $value)
    {
        if ( ! $this->offsetExists($key))
            {
                // Insert a new value
                DB::insert($this->_database_table, array('group_name', 'config_key', 'config_value'))
                    ->values(array($this->_configuration_group, $key, $value))
                    ->execute($this->_database_instance);
            }
        elseif ($this->offsetGet($key) !== $value)
            {
                // Update the value
                DB::update($this->_database_table)
                    ->value('config_value', $value)
                    ->where('group_name', '=', $this->_configuration_group)
                    ->where('config_key', '=', $key)
                    ->execute($this->_database_instance);
            }
    }

    /**
     * Extended instance method to store many offsets at a time
     * internally calls the offsetSet method in a loop
     * @param Array $settings
     */
    public function setMany($settings) {
        foreach ($settings as $key=>$value) {
            $this->offsetSet($key, $value);
        }
    }
}
