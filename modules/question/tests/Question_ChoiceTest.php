<?php defined('SYSPATH') or die('No direct access allowed.');

class Question_ChoiceTest extends Kohana_UnitTest_TestCase {

    public function test_process_attrs() {
        // for answers
        $formdata = array(
            'choice' => array(
                'question1',
                'question2'
            ),
            'correct' => array(
                '1',
                '0'
            ),
            'explain' => array(
                'hello world',
                'hello kodelearn'
            )
        );
        $question = Question::factory('choice');
        $attributes = $question->process_attrs($formdata);
        $this->assertEquals($attributes, array(
            0 => array(
                'attribute_name' => 'choice',
                'attribute_value' => 'question1',
                'correctness' => '1',
                'explanation' => 'hello world'
            ),
            1 => array(
                'attribute_name' => 'choice',
                'attribute_value' => 'question2',
                'correctness' => '0',
                'explanation' => 'hello kodelearn'
            )
        ));      
    }

    public function test_subtype() {
        $attributes = array(
            0 => array(
                'attribute_name' => 'choice',
                'attribute_value' => 'question1',
                'correctness' => '1',
                'explanation' => 'hello world'
            ),
            1 => array(
                'attribute_name' => 'choice',
                'attribute_value' => 'question2',
                'correctness' => '0',
                'explanation' => 'hello kodelearn'
            )
        );
        $question = Question::factory('choice');
        $this->assertEquals($question->choice_type($attributes), 'unique');
        $attributes = array(
            0 => array(
                'attribute_name' => 'choice',
                'attribute_value' => 'question1',
                'correctness' => '1',
                'explanation' => 'hello world'
            ),
            1 => array(
                'attribute_name' => 'choice',
                'attribute_value' => 'question2',
                'correctness' => '0',
                'explanation' => 'hello kodelearn'
            ),
            1 => array(
                'attribute_name' => 'choice',
                'attribute_value' => 'question3',
                'correctness' => '1',
                'explanation' => 'hello kodelearn'
            )
        );
        $this->assertEquals($question->choice_type($attributes), 'multiple');
    }    
}

