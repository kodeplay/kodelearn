<?php defined('SYSPATH') or die('No direct access allowed.');

abstract class Acl_Menu {

    public static function factory($role) {
        $class = 'Acl_Menu_' . ucfirst($role);
        return new $class();
    }

    protected $role;

    protected $menu_collection = array();

    public function has_menu($name) {
        return (isset($this->menu_collection[$name]) && $this->menu_collection[$name] instanceof Acl_Menu);
    }

    public function get($name) {
        $menu = Arr::get($this->menu_collection, $name);
        $menu->extend_links(Arr::get(DynamicMenu::$extended, $name, array()));
        return $menu;
    }

    public function set($name, DynamicMenu_Menu $menu) {
        $this->menu_collection[$name] = $menu;
        return $this;
    }
}