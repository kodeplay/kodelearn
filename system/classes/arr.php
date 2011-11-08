<?php defined('SYSPATH') or die('No direct script access.');

class Arr extends Kohana_Arr {

    /**
     * Function similar to python's zip
     * copied from here [[http://stackoverflow.com/questions/2815162/is-there-a-php-function-like-pythons-zip]]
     */
    public static function zip() 
    {
        $args = func_get_args();
        $zipped = array();
        $n = count($args);
        for ($i=0; $i<$n; ++$i) 
        {
            reset($args[$i]);
        }
        while ($n) 
        {
            $tmp = array();
            for ($i=0; $i<$n; ++$i) 
            {
                if (key($args[$i]) === null) 
                {
                    break 2;
                }
                $tmp[] = current($args[$i]);
                next($args[$i]);
            }
            $zipped[] = $tmp;
        }
        return $zipped;
    }
}