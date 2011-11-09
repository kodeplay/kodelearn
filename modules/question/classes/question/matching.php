<?php defined('SYSPATH') or die('No direct script access.');

class Question_Matching extends Question {    

    protected $_type = 'matching';
    
        public function render_form($postdata=array()) {
        $view = View::factory('question/matching/partial_form')
            ->set('error_matched_pairs', $this->validation_errors('attributes'))
            ->bind('attribute', $attribute);
        $post_attr = Arr::get($postdata, 'attributes', array());
        $saved_attributes = $this->_orm !== null ? $this->_orm->attributes_as_array() : array();
        if ($post_attr) {
            $attributes = $this->process_attrs($post_attr);
            $attribute = $attributes[0];
        } elseif ($saved_attributes) {
            $attribute = $saved_attributes[0];
        } else {
            $attribute = array(
                'attribute_name' => 'matched_pairs',
                'attribute_value' => serialize(array()),
                'explanation' => '',
            );
        }
        $attribute['pairs'] = unserialize($attribute['attribute_value']);
        return $view->render();
    }

    public function process_attrs($data) {
        $pairs = Arr::zip($data['pairs']['l'], $data['pairs']['r']);
        $matched_pairs = serialize($pairs);
        $attribute = array(
            'attribute_name' => 'matched_pairs',
            'attribute_value' => $matched_pairs,
            'correctness' => 1,
            'explanation' => $data['explain']
        );
        return array($attribute);
    }

    public function solution_tab() {
        return __('Matched Pairs');
    }

    public function validate_attributes(array $attributes) {
        if (count($attributes['pairs']['l']) < 2) {
            $this->_validation_errors['attributes'] = Kohana::message('question', 'matching.atleast_two');
            return false;
        }
        $valid_left = array_filter($attributes['pairs']['l']);
        $valid_right = array_filter($attributes['pairs']['r']);
        // if filtered count of values in left and right arrays don't match, then some value was blank
        if (count($valid_left) !== count($valid_right)) {
            $this->_validation_errors['attributes'] = Kohana::message('question', 'matching.not_empty');
            return false;
        }
        return true;
    }

    public function render_answer_partial() {
        $view = View::factory('question/matching/partial_view')
            ->bind('lefts', $lefts)
            ->bind('rights', $rights);
        $attributes = $this->_orm !== null ? $this->_orm->attributes_as_array() : array();
        $attribute = $attributes[0];
        $pairs = unserialize($attribute['attribute_value']);        
        $lefts = Arr::pluck($pairs, 0);
        $rights = Arr::pluck($pairs, 1);
        shuffle($rights);
        // var_dump($lefts, $rights, $pairs); exit;
        return $view->render();
    }
}
