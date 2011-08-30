<?php defined('SYSPATH') or die('No direct access allowed!'); 

class DynamicMenuTest extends Kohana_UnitTest_TestCase {
    
    /**
     * Test whether factory static method returns an object of 
     * type DynamicMenu_Menu
     */
    public function test_factory() {
        $sidebar = DynamicMenu::factory('sidebar');
        $this->assertInstanceOf('DynamicMenu_Menu', $sidebar);
    }

    public function test_extend() {
        $count = count(DynamicMenu::$extended);
        DynamicMenu::extend(array(
            'someothermenu' => array(
                array('http://google.com', 'Google', 1, array()),
            ),
        ));
        $this->assertEquals($count+1, count(DynamicMenu::$extended));
        $count_someothermenu = count(DynamicMenu::$extended['someothermenu']);
        DynamicMenu::extend(array(
            'someothermenu' => array(
                array('http://facebook.com', 'Facebook', 2, array('id' => 'facebook-link')),
                array('http://twitter.com', 'Twitter', 3, array('id' => 'twitter-link')),
            ),
        ));
        $this->assertEquals($count_someothermenu+2, count(DynamicMenu::$extended['someothermenu']));
    }
}