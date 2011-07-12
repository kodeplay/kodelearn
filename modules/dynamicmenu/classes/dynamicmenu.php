<?php defined('SYSPATH') or die('No direct script access.');

class DynamicMenu {

    private static $collection;

    public function __construct() {
        
    }

    public static function factory($position) {
        if (Arr::get(self::$collection, $position) !== null) {
            return Arr::get(self::$collection, $position);
        } else {
            return new DynamicMenu_Menu($position);
        }        
    }
}