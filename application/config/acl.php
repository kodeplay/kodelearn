<?php defined('SYSPATH') or die('No direct access allowed.');

return array(    
    'default' => array(
        'view',
        'create',
        'edit',
        'delete'
    ),

    'user' => array(
        'levels' => array(
            'upload_csv',
        )
    ),
    
    'course' => array(
        'levels' => array(
            'join',
        )
    ),
    
    'role' => array(
        'levels' => array(
            'set_permission',
        )
    ),

    'play' => array(
        'ignore' => true,
    ),
    
    'post' => array(
        'levels' => array(
            'deletecomment',
        )
    ),
    
    
);