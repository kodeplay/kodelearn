<?php defined('SYSPATH') or die('No direct access allowed.');

class Acl_ConfigTest extends Kohana_UnitTest_TestCase {

    protected $acl_config;

    public function setUp() {
        $this->acl_config = Acl_config::instance();
    }
    
    public function tearDown() {
        unset($this->acl_config);
    }

    public function test_init() {
        // check instance type
        $this->assertInstanceOf('Acl_Config', $this->acl_config);
        // check singleton
        $this->assertSame(Acl_Config::instance(), $this->acl_config);
    }

    public function test_config() {
        // check if config contains a publicly accessible default array
        $this->assertObjectHasAttribute('default', $this->acl_config->config());
    }

    public function test_get_default() {        
        $default = $this->acl_config->get_default();
        // check if array
        $this->assertTrue(is_array($default));
        // check if not empty (only in the c ase of acl.php as config file
        $this->assertFalse(empty($default));        
    }

    /**
     * @expectedException Acl_Exception
     */
    public function test_acl() {
        // check for String param passed
        $this->assertTrue(is_array($this->acl_config->acl('batch')));
        // check if the entire associative array returned when no param passed
        $acl = $this->acl_config->acl();
        $this->assertTrue(is_array($acl['batch']));
        // check if raises an exception for undefined resource
        $acl = $this->acl_config->acl('guitar');
    }

    public function test_merge_levels() {
        // first check the behavior of merge_levels being invoked
        // internally from construct ie merge default with specified
        $config = $this->acl_config->config()->getArrayCopy();
        // take a resource level other than 'default'
        foreach ($config as $k=>$v) {
            if ($k !== 'default') {
                $resource = $k;
                $levels = $v;                 
            }
        }
        $default = $this->acl_config->get_default();
        // check if merge_levels works when invoked publicly
        $acl = $this->acl_config->acl();
        $merged = array_merge($default, $levels);
        $this->assertEquals($merged, $acl[$resource]);
        // now merge one level into this by passing a string
        $new_level = 'send_email';
        $this->acl_config->merge_levels($resource, $new_level);
        // check if new level has been added to acl
        $acl = $this->acl_config->acl($resource);
        $this->assertEquals($new_level, array_pop($acl));
        //now check if merge_levels works when passed an array
        $more_levels = array(
            'make_call',
            'play_guitar',
            'hack'
        );
        $this->acl_config->merge_levels($resource, $more_levels);
        $acl = $this->acl_config->acl($resource);
        $i = count($more_levels);
        while ($i > 0) {
            $this->assertEquals($more_levels[--$i], array_pop($acl));            
        }
    }

    /**
     * @expectedException Acl_Exception
     */
    public function test_acl_exception_merge_levels() {
        $new_level = 'send_email';
        $this->acl_config->merge_levels('a_non_resource', $new_level);
    }
}