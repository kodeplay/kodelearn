<?php defined('SYSPATH') or die('No direct script access.');

class Cookie extends Kohana_Cookie {

    public static $salt = 'authautologin';
    public static $expiration = '1209600';
    
}
