<?php defined('SYSPATH') or die('No direct script access.');

class Question_Choice extends Question {    

    protected $_type = 'choice';

    /**
     * Possible corrects answers for the question
     * can be unique or multiple
     */
    protected $_choice_type;

    public function render_form($postdata=array()) {
        $view = View::factory('question/choice/partial_form')
            ->set('error_choices', $this->validation_errors('attributes'))
            ->bind('attributes', $attributes);
        $attributes = array();
        $post_attributes = Arr::get($postdata, 'attributes', array());
        $saved_attributes = $this->_orm !== null ? $this->_orm->attributes_as_array() : array();
        if ($post_attributes) {
            $attributes = $this->process_attrs($post_attributes);
        } elseif ($saved_attributes) {
            $attributes = $saved_attributes;
        } else {
            $attributes[] = array(
                'attribute_name' => 'choice',
                'attribute_value' => '',
                'correctness' => 0,
                'explanation' => '',
            );
        }        
        return $view->render();
    }

    public function solution_tab() {
        return __('Choices');
    }

    public function process_attrs($data) {
        $attributes = array();
        $total = count($data['choice']);
        for ($i = 0; $i < $total; $i++) {
            $attributes[] = array(
                'attribute_name' => 'choice',
                'attribute_value' => $data['choice'][$i],
                'correctness' => $data['correct'][$i],
                'explanation' => $data['explain'][$i]
            );
        }
        return $attributes;
    }

    /**
     * Method to find out the possible correct answers
     * for the question
     * @param Array $attributes
     * @return String unique|multiple
     */
    public function choice_type($attributes) {
        $correct_status = Arr::pluck($attributes, 'correctness');
        $only_correct = array_filter($correct_status);
        $num_correct = count($only_correct);
        if ($num_correct > 1) {
            return 'multiple';
        } else if ($num_correct == 1) {
            return 'unique';
        } else {
            throw new Exception('Set of answers without atleast 1 correct answer');
        }
    }

    public function validate_attributes(array $attributes) {
        // check if atleast one answer present
        if (!count($attributes['choice'])) {
            $this->_validation_errors['attributes'] = Kohana::message('question', 'choice.atleast_one');
            return false;
        }
        // check if none of the attributes are empty
        if (!array_filter($attributes['choice'])) {
            $this->_validation_errors['attributes'] = Kohana::message('question', 'choice.not_empty');
            return false;
        }
        // check if atleast one answer is marked correct
        if (!in_array('1', $attributes['correct'])) {
            $this->_validation_errors['attributes'] = Kohana::message('question', 'choice.correct');                
            return false;
        }
        return true;
    }

    public function render_answer_partial() {
        $view = View::factory('question/choice/partial_view')
            ->bind('choices', $choices)
            ->bind('choice_type', $choice_type);
        $choices = $this->_orm !== null ? $this->_orm->attributes_as_array() : array();
        $choice_type = $this->choice_type($choices);
        return $view->render();
    }
}
