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
}