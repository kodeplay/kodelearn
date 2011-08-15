<?php defined('SYSPATH') or die('No direct script access.');

class Model_Role extends ORM {
	
    protected $_has_many = array(
        'users' => array(
            'model'   => 'user',
            'through' => 'roles_users',
        ),
    );
    
    public function validator($data) {
        return Validation::factory($data)
            ->rule('name', 'not_empty');            
    }

    /**
     * Method to get the role object from its name
     * @param String $name
     * @return Model_Role $role
     */
    public static function from_name($name) {
        $role = ORM::factory('role')
            ->where('name', ' = ', $name)
            ->find();
        return $role;
    }
}