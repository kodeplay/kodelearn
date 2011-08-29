<?php defined('SYSPATH') or die('No direct script access.');

class DynamicMenu {

    private static $collection;

    public static $extended = array();

    public function __construct() {
        
    }

    public static function factory($position) {
        if (Arr::get(self::$collection, $position) !== null) {
            return Arr::get(self::$collection, $position);
        } else {
            return new DynamicMenu_Menu($position);
        }        
    }

    /**
     * Methods for modules to extend the menus
     * This should be called from the init.php of the module
     * @param Array in following order of elements
     *        eg. array('sidemenu' => array('<url>', '<title>', '<sort_order>', '<attributes>'));
     * @return None
     */
    public static function extend($arr) {
        self::$extended = array_merge(self::$extended, $arr);
    }
}