<?php defined('SYSPATH') or die('No direct access allowed!');

class SortTest extends Kohana_UnitTest_TestCase {

    public function test_init() {
        $sort = new Sort();
        $this->assertInstanceOf('Sort', $sort);
    }
    
    public function test_set_order(){
    	$sort = new Sort();
        //test with switch true
        $sort->set_order('ASC');
        $this->assertEquals('DESC',$sort->get_order());
       
        //test without switch
        $sort->set_order('ASC', FAlSE);
        $this->assertEquals('ASC',$sort->get_order());
    }
}