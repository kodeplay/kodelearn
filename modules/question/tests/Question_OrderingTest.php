<?php defined('SYSPATH') or die('No direct access allowed.');

class Question_OrderingTest extends Kohana_UnitTest_TestCase {

    public function test_check_answer() {
        $ques = ORM::factory('question', 8);        
        $question = Question::factory($ques);
        $submitted = array(
            'twelve',
            'sixteen',
            'twenty five',
            'thirty five'
        );
        $this->assertTrue($question->check_answer($submitted));
        $ques = ORM::factory('question', 7);        
        $question = Question::factory($ques);
        $submitted = array(
            'Router',
            'Controller',
            'Model',
            'View'
        );
        $this->assertTrue($question->check_answer($submitted));
    }
}
