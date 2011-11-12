<?php defined('SYSPATH') or die('No direct script access.');

class Model_Question extends ORM {

    public static $TYPES = array(
        'choice', 'matching', 'open', 'ordering' // grouped is disabled for now
    );

    protected $_has_many = array(
        'attributes' => array('model' => 'questionattribute'),
        'hints' => array('model' => 'questionhint')
    );

    public function validator($data) {
        return Validation::factory($data)
            ->rule('question', 'not_empty');
    }

    /**
     * Method to get the questions as per the criteria
     * @param Array $criteria
     * @return Database_MySQL_Result
     */
    public static function get_questions($criteria) {
        $questions = ORM::factory('question');
        if (!empty($criteria['filter_type'])) {
            $questions->where('type', ' = ', $criteria['filter_type']);
        }
        if (!empty($criteria['limit'])) {
            $questions->limit($criteria['limit'])
                ->offset(Arr::get($criteria, 'offset', 0));            
        }
        return $questions->find_all();
    }

    /**
     * Method to get the total number of questions as per the criteria
     * @param Array $criteria
     * @return int 
     */
    public static function get_total_question_count($criteria) {
        $questions = ORM::factory('question');
        if (!empty($criteria['filter_type'])) {
            $questions->where('type', ' = ', $criteria['filter_type']);
        }
        return $questions->count_all();
    }

    /**
     * Method to add multiple hints at a time
     * @return Model_Question $this
     */
    public function add_hints($hints) {
        if ($hints) {
            foreach ($hints as $h) {
                $h['question_id'] = $this->id;
                $hint = ORM::factory('questionhint');
                $hint->values($h);
                $hint->save();
            }
        }
        return $this;
    }
    
    /**
     * Method to delete all the hints for this question
     * @return Model_Question $this
     */
    public function delete_all_hints() {
        $hints = $this->hints->find_all();
        foreach ($hints as $hint) {
            if ($hint !== null) {
                $hint->delete();
            }
        }
        return $this;
    }

    /**
     * Method to add multiple attributes at a time
     * @return Model_Question $this
     */
    public function add_attributes($attributes) {
        if ($attributes) {
            foreach ($attributes as $attr) {
                $attr['question_id'] = $this->id;
                $attribute = ORM::factory('questionattribute');
                $attribute->values($attr);
                $attribute->save();
            }
        }
        return $this;
    }

    /**
     * Method to delete all the attributes for this question
     * We dont have primary key here so cant use ORM for deletion
     * @return Model_Question $this
     */
    public function delete_all_attributes() {
        DB::delete('questionattributes')
            ->where('question_id', ' = ', $this->id)
            ->execute();
        return $this;
    }

    public function hints_as_array() {
        $hints = array();
        $hints_arr = $this->hints->find_all()->as_array();
        if ($hints_arr) {
            foreach ($hints_arr as $h) {
                $hints[] = $h->as_array();
            }
        }
        return $hints;
    }

    public function attributes_as_array() {
        $attributes = array();
        $attributes_arr = $this->attributes->find_all()->as_array();
        if ($attributes_arr) {
            foreach ($attributes_arr as $h) {
                $attributes[] = $h->as_array();
            }
        }
        return $attributes;
    }
}
