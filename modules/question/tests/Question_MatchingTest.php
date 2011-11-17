<?php defined('SYSPATH') or die('No direct access allowed.');

class Question_MatchingTest extends Kohana_UnitTest_TestCase {

    public function test_check_answer() {
        $ques = ORM::factory('question', 10);        
        $question = Question::factory($ques);
        $submitted = array(
            0 => array(
                0 => "s dasda s",
                1 => "asd asd",
            ),
            1 => array(
                0 => "asd asdasdasd",
                1 => "asda sasdasd",
            ),
            2 => array(
                0 => "dsf dsdfsdfsdf",
                1 => "sa asasd assad",
            ),
        );
        $this->assertTrue($question->check_answer($submitted));        
    }
}