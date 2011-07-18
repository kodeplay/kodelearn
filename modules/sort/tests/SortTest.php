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
    
    public function test_render(){
    	
    	$sorting = new Sort(array(
            'Column1'   => ''    	
    	));
    	
    	$sorting->set_order('ASC');
    	
        //testing with checkbox column true
        $html = '<tr><th><input type="checkbox" onclick="$(\'.selected\').attr(\'checked\', this.checked);"/></th><th>Column1</th></tr>';
        $this->assertEquals($html, $sorting->render());
        
        //testing with checkbox column false
        $sorting->set_check_box_column(FALSE);
        $html = '<tr><th>Column1</th></tr>';
        $this->assertEquals($html, $sorting->render());
       
        
    }
}