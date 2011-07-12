<?php defined('SYSPATH') or die('No direct access allowed!');

class DynamicMenu_MenuTest extends Kohana_UnitTest_TestCase {

    public function test_init() {
        $menu = new DynamicMenu_Menu('sidebar');
        $this->assertInstanceOf('DynamicMenu_Menu', $menu);
        // test that links is an empty array initially
        $this->assertEquals(0, count($menu->get_links()));
        // test that attributes are empty
        $this->assertEquals(0, count($menu->get_attributes()));
    }

    public function test_set_attributes() {
        $menu = new DynamicMenu_Menu('sidebar');
        $attributes = array(
            'class' => 'dlink he'
        );
        $menu->set_attributes($attributes);
        $this->assertEquals($attributes, $menu->get_attributes());
    }

    public function test_add_link() {
        $menu = new DynamicMenu_Menu('sidebar');
        $attributes = array(
            'class' => 'dlink he'
        );
        $menu->set_attributes($attributes);
        $url = 'http://www.google.com';
        $title = 'google';
        $sort_order = 2;
        $attributes = array('class' => 'internal-link');
        $instance = $menu->add_link($url, $title, $sort_order, $attributes);
        // Test if the add_link method returns the same instance
        $this->assertSame($menu, $instance);
        $links = $menu->get_links();
        $added = $links['google'];
        $this->assertEquals(Html::anchor($url, $title, $attributes), $added['html']);
        $this->assertEquals('google', $added['title']);
        $this->assertEquals(2, $added['sort_order']);
    }

    public function test_as_array() {
        $menu = new DynamicMenu_Menu('sidebar');
        $menu->add_link('http://kodeplay.com', 'kodeplay', 3, array());
        $menu->add_link('http://vineetnaik.me', 'vineet\'s blog', 1, array());
        $menu->add_link('http://github.com', 'Github', 2, array());
        $links = $menu->as_array();
        $ls = array('vineets_blog', 'github', 'kodeplay');
        $i = 0;
        foreach ($links as $k=>$link) {
            $this->assertEquals($ls[$i++],$k);             
        }        
    }
}