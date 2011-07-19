<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package   Modules
 * @category  Cache_Image
 * @uses      Image Module
 * 
 */
 
return array
(
    // How long before the browser checks the server for a new version of the modified image (Default: 1 Week)
    'image_dir' => 'media/image/data/', 
    
    // Path to the image cache directory you would like to use (Default: 'media/imagecache/')
    // Dont forget the trailing slash!
    'cache_dir' => 'cache',

    //default filename will be used if not filename is specified
    'default_filename' => 'no_image.jpg',
    
);