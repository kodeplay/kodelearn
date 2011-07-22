<?php defined('SYSPATH') or die('No direct access allowed.');

class AclTest extends Kohana_UnitTest_TestCase {

    protected $_acl;

    public function setUp() {
        $this->_acl = Acl::instance();
    }

    public function tearDown() {
        unset($this->_acl);
    }

    public function test_instance() {
        $this->assertInstanceOf('Acl', $this->_acl);
    }

    public function test_repr_key() {
        $this->assertEquals('user_create', Acl::repr_key('user', 'create'));
        $this->assertEquals('role_permissions', Acl::repr_key('role', 'permissions'));
    }

    public function test_split_repr_key() {
        list($resource, $action) = Acl::split_repr_key('batch_create');
        $this->assertEquals('batch', $resource);
        $this->assertEquals('create', $action);
        list($resource, $action) = Acl::split_repr_key('exam_add_results');
        $this->assertEquals('exam', $resource);
        $this->assertEquals('add_results', $action);
        // Please note the following c_ase will not work. 
        // ie Acl doesnot support controller with an underscrore
        // if the need arrises, we can just change the separator to colon (:)
        list($resource, $action) = Acl::split_repr_key('controller_with_underscore_action');
        $this->assertFalse('controller_with_underscore' === $resource);
        $this->assertFalse('action' === $action);
    }

}
