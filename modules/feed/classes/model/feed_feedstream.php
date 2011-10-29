<?php defined('SYSPATH') or die('No direct script access.');

class Model_Feed_Feedstream extends ORM {

    protected $_belongs_to = array(
        'feed_id' => array(
            'model' => 'feed',
            'foreign_key' => 'id'
        ),
        'feedstream_id' => array(
            'model' => 'feedstream',
            'foreign_key' => 'id'
        )
    );

}
