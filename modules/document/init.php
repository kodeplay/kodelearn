<?php defined('SYSPATH') or die('No direct script access.');

DynamicMenu::extend(array(
    'coursemenu' => array(
        array('document', 'Documents', 5, array()),
    ),
));

define('UPLOAD_PATH', MODPATH . 'document/upload/');