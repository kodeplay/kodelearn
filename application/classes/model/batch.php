<?php defined('SYSPATH') or die('No direct script access.');

class Model_Batch extends ORM {
	
    public function validator($data) {
        return Validation::factory($data)
            ->rule('name', 'not_empty')
            ->rule('name', 'min_length', array(':value', 3))
            ->rule('description', 'not_empty');
    }

    protected $_has_many = array(
       'user' => array ('model' => 'user', 'foreign_key' => 'batch_id' )
    );
}
