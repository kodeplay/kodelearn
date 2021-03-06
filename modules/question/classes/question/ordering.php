<?php defined('SYSPATH') or die('No direct script access.');

class Question_Ordering extends Question {    

    protected $_type = 'ordering';

    public function render_form($postdata=array()) {
        $view = View::factory('question/ordering/partial_form')
            ->set('error_ordered_items', $this->validation_errors('attributes'))
            ->bind('attribute', $attribute);
        $post_attr = Arr::get($postdata, 'attributes', array());
        $saved_attributes = $this->_orm !== null ? $this->_orm->attributes_as_array() : array();
        if ($post_attr) {
            $attributes = $this->process_attrs($post_attr);
            $attribute = $attribute[0];
        } elseif ($saved_attributes) {
            $attribute = $saved_attributes[0];
        } else {
            $attribute = array(
                'attribute_name' => 'ordered_items',
                'attribute_value' => serialize(array()),
                'explanation' => '',
            );
        }        
        $attribute['items'] = unserialize($attribute['attribute_value']);
        return $view->render();
    }

    public function process_attrs($data) {
        $valid_items = array_filter($data['items']);
        $ordered_items = serialize($valid_items);
        $attribute = array(
            'attribute_name' => 'ordered_items',
            'attribute_value' => $ordered_items,
            'correctness' => 1,
            'explanation' => $data['explain']
        );
        return array($attribute);
    }

    public function solution_tab() {
        return __('Ordered Items');
    }

    public function validate_attributes(array $attributes) {
        $valid_items = array_filter($attributes['items']);
        if (count($valid_items) < 2) {
            $this->_validation_errors['attributes'] = Kohana::message('question', 'ordering.atleast_two');
            return false;
        }
        return true;
    }

    public function render_answer_partial() {
        $view = View::factory('question/ordering/partial_view')
            ->bind('items', $items);
        $attributes = $this->_orm !== null ? $this->_orm->attributes_as_array() : array();
        $attribute = $attributes[0];
        $items = unserialize($attribute['attribute_value']);        
        shuffle($items);
        return $view->render();
    }

    /**
     * HEre the answer is stored in the form of
     * serialized array of ordered elements
     * hence we serialize the submitted answer and compare
     */
    public function check_answer($answer) {
        $attrs = $this->_orm->attributes_as_array();
        $answer_attr = $attrs[0];
        $expected_answer = $answer_attr['attribute_value'];
        return serialize($answer) == $expected_answer;
        return false;
    }

    public function answer_review($submitted_answer) {
        $view = View::factory('question/ordering/answer_review')
            ->bind('answer', $answer);
        $attrs = $this->_orm->attributes_as_array();
        $answer = array(
            'submitted_order' => $submitted_answer,
            'correct_order' => unserialize($attrs[0]['attribute_value']),
            'explanation' => $attrs[0]['explanation']
        );
        return $view->render();
    }
}

