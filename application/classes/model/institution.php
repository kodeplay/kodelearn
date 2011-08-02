<?php defined('SYSPATH') or die('No direct script access.');

class Model_Institution extends ORM {

    public function validator($data) {
        return Validation::factory($data)
            ->rule('name', 'not_empty');
            
    }
}