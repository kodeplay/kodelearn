<?php defined('SYSPATH') or die('No direct script access.');

class DynamicMenu {

    private static $collection;

    /**
     * Array to store the menu link arrays added by the modules
     * in their init.php files.
     */
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
        foreach ($arr as $menu=>$links) {
            if (!isset(self::$extended[$menu])) {
                self::$extended[$menu] = array();
            }
            self::$extended[$menu] = array_merge(self::$extended[$menu], $links);            
        }
    }
}