<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class to handle the sending of notices to students etc
 * Notices will be sent through the media - email and sms
 * 
 */
class Notice {

    protected $_handlers;

    private static $_instance;

    public static function instance() {
        if (null == self::$_instance) {
            self::$_instance = new Notice();
        }
    }

    public function init() {
        $config = Notice_Config::instance()->config();
    }
}
