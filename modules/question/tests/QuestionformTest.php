<?php defined('SYSPATH') or die('No direct access allowed.');

class QuestionTest extends Kohana_UnitTest_TestCase {

    public function test_process_hints() {
        $formdata = array(
            'hint' => array(
                'hint1',
                'hint2',
                '',
            ),
            'sort_order' => array(
                '1',
                '2',
                '3'                
            ),
            'deduction' => array(
                '3.2',
                '3.4',
                '5.6'
            )
        );
        $question = Question::factory('choice');
        $hints = $question->process_hints($formdata);
        $this->assertEquals($hints, array(
            0 => array(
                'hint' => 'hint1',
                'sort_order' => 1,
                'deduction' => 3.2,
            ),
            1 => array(
                'hint' => 'hint2',
                'sort_order' => 2,
                'deduction' => 3.4
            )
        ));  
    }
}