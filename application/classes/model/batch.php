<?php defined('SYSPATH') or die('No direct script access.');

class Model_Batch extends ORM {
    
    public function validator($data) {
        return Validation::factory($data)
            ->rule('name', 'not_empty')
            ->rule('name', 'min_length', array(':value', 3))
            ->rule('description', 'not_empty');
    }

    protected $_has_many = array(
        'users' => array(
            'model'   => 'user',
            'through' => 'batches_users',
        ),
    );    
}
