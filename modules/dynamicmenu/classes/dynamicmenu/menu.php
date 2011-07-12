<?php defined('SYSPATH') or die('No direct script access.');

class DynamicMenu_Menu {

    private $position;

    private $links = array();

    /**
     * These will be used as the html attributes for all 
     * anchor tags for this link
     */
    private $attributes = array();

    /**
     * @param String $position will be used to identify the menu
     */
    public function __construct($position) {
        $this->position = $position;
    }

    /**
     * Method for adding a link to the menu
     * @param String $url - url that the link points to
     * @param String $title - title that appears
     * @param int $sort_order - order at which the link should appear in menu
     * @param array $attributes - html attributes for this link only.\
     * the global attributes specified by the instance variable will be overridden by this
     */
    public function add_link($url, $title, $sort_order=NULL, $attributes=NULL) {
        $attributes = array_merge($this->attributes, $attributes);
        $anchor = Html::anchor($url, $title, $attributes);
        $this->links[$title] = array(
            'html' => $anchor,
            'title' => $title,
            'sort_order' => (int) $sort_order,
        );
    }

    public function set_attributes($attributes) {
        $this->attributes = $attributes;
    }

    /**
     * Return the links in the menu as an array
     * @return Array 
     */
    public function as_array() {
        return uasort($this->links, 'DyanamicMenu_Menu::sort_by');
    }

    private static function sort_by($a, $b) {
        if ($a['sort_order'] === $b['sort_order']) {
            return 0;
        }
        return ($a['sort_order'] < $b['sort_order']) ? -1 : 1;
    }

    public function __get($key) {
        return $this->links[$key]['html'];
    }
}