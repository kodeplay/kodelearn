<?php defined('SYSPATH') or die('No direct script access.');

class Question_Open extends Question {    

    protected $_type = 'open';

    public function render_form($postdata=array()) {
        $view = View::factory('question/open/partial_form')
            ->set('error_answer', $this->validation_errors('attributes'))
            ->bind('attribute', $attribute);
        $post_answer = Arr::get($postdata, 'attributes', array());
        $saved_attributes = $this->_orm !== null ? $this->_orm->attributes_as_array() : array();
        if ($post_answer) {
            $attributes = $this->process_attrs($post_answer);
            $attribute = $attribute[0];
        } elseif ($saved_attributes) {
            $attribute = $saved_attributes[0];
        } else {
            $attribute = array(
                'attribute_name' => 'open',
                'attribute_value' => '',
                'explanation' => '',
            );
        }        
        return $view->render();
    }

    public function process_attrs($data) {
        $attribute = array(
            'attribute_name' => 'answer',
            'attribute_value' => $data['answer'],
            'correctness' => 1,
            'explanation' => $data['explain']
        );
        return array($attribute);
    }

    public function solution_tab() {
        return __('Answer');
    }

    public function validate_attributes(array $attribute) {
        if (!$attribute['answer']) {
            $this->_validation_errors['attributes'] = Kohana::message('question', 'open.not_empty');
            return false;
        }
        return true;
    }

    public function render_answer_partial() {
        $view = View::factory('question/open/partial_view');
        return $view->render();
    }

    /**
     * Here we check the answer directly with the question attribute saved
     * Also there may be multiple possible correct forms for answers
     * which we will know by exploding the string with '||'
     */
    public function check_answer($answer) {
        $attrs = $this->_orm->attributes_as_array();
        $answer_attr = $attrs[0];
        $expected_answer = $answer_attr['attribute_value'];
        $multiple_possible = explode('||', $expected_answer);
        if (count($multiple_possible) > 1) {
            return in_array($answer, $multiple_possible);
        } else {
            return $answer == $expected_answer;
        }
    }
}
