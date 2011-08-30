<?php defined('SYSPATH') or die('No direct script access.');

abstract class DynamicMenu_Filter {

    protected static $filters = array();

    protected static $types = array(
        'add_link',        
    );

    public static function add(DynamicMenu_Filter $filter) {
        self::$filters[] = $filter;
    }

    public static function apply_filters($type, $args) {
        if (!in_array($type, self::$types)) {
            throw new Exception('Filter of type ' . $type . ' not supported in DynamicMenu_Filter');
        }
        if (self::$filters) {
            foreach (self::$filters as $filter) {
                $flag = $filter->{'filter_'.$type}($args);
                if (!$flag) {
                    return False;
                }
            }
        }
        return True;
    }

    public function __construct() {
        
    }

    /**
     * @param String resource
     * @return Boolean true if link to be added false if not
     */
    abstract protected function filter_add_link($args);
}