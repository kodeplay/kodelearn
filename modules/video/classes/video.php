<?php defined('SYSPATH') or die('No direct script access.');

class Video {
    
    public static function search($string) {
        //create search object and do the needfull
        $search = new Video_Youtube_Search($string);
        return $search;
    }
    
    public static function embed($url) {
        //create search object and do the needfull
        $embed = new Video_Youtube_Embed($url);
        return $embed;
    }
}