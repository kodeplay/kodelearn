<?php defined('SYSPATH') or die('No direct script access.');

class DynamicMenu_Menu {

    private $position;

    private $links = array();

    private $attributes = array();

    public function __construct($position, $link_attributes = array()) {
        $this->position = $position;
        $this->attributes = $link_attributes;
    }

    public function add_link($url, $title, $sort_order=NULL, $attributes=NULL) {
        $attributes = array_merge($this->attributes, $attributes);
        $anchor = Html::anchor($url, $title, $attributes);
        if ($sort_order === NULL) {
            $this->links[$title] = array(
                'html' => $anchor,
                'title' => $title,
                'sort_order' => $sort_order,
            );
        }
    }

    /**
     * 
     */
    public function get_links_as_array() {

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