<?php defined('SYSPATH') or die('No direct access allowed.');

class Acl_Menu_Filter extends DynamicMenu_Filter {

    /**
     * In the add link filter we check if the role of the current user
     * can access this url
     * @param String url
     * @param String title
     * @return Boolean 
     */
    protected function filter_add_link($args) {
        $url = $args[0];
        $controller = explode("/", $url);
        if ($url === 'auth/logout') {
            return True;
        }
        return Acl::instance()->has_access($controller[0]);
    }
}