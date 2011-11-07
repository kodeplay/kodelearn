<?php defined('SYSPATH') or die('No direct script access.');

abstract class Question {

    /**
     * @type Model_Question
     */
    protected $_orm;

    /**
     * Type of the question
     */
    protected $_type;

    /**
     * Question attributes
     */
    protected $_attributes = array();

    /**
     * Array of error if the submitted form is invalid
     */
    protected $_validation_errors = array();

    /**
     * What the solution tabs will be called
     */
    protected $_solution_tab;

    /**
     * Method to return a new instance of Question or its subclasses
     * @param mixed (int, string, Model_Question) $input
     */
    public static function factory($input) {
        if (is_string($input)) {
            $type = trim($input);
            $class = 'Question_' . ucfirst($type);
            return new $class;
        } elseif (is_int($input)) {
            $question = ORM::factory('question', $input);            
            $class = 'Question_' . ucfirst($question->type);
            return new $class($question);
        } elseif ($input instanceof Model_Question) {
            $class = 'Question_' . ucfirst($input->type);
            return new $class($input);
        } else {
            throw new Exception('unknown type of parameter passed');
        }
    }

    public function __construct($question=null) {
        if ($question instanceof Model_Question) {
            $this->_orm = $question;
        } elseif (is_int($question)) {
            $this->_orm = ORM::factory('question', $question);
        }
    }

    /**
     * Method to get the form html for the solution section of a question
     * @param Array $postdata
     * @return String html
     */
    abstract public function render_form($postdata=array());    

    /**
     * Method to process the attributes coming from the submitted form and
     * process them to the array format as stored in the db
     */
    abstract public function process_attrs($data);

    /**
     * Public getter for $_orm
     */
    public function orm() {
        return $this->_orm;
    }

    /**
     * Method to get the type of the questions
     * @return String type
     */
    public function type() {
        return $this->_type;
    }

    /**
     * Getter for $_validation_errors Array
     * @return Array 
     */
    public function validation_errors($key=null) {
        if ($key === null) {
            return $this->_validation_errors;
        } else {
            return Arr::get($this->_validation_errors, $key, '');
        }
    }

    /**
     * Method to get the type of the solution tab name
     * @return String type
     */
    public function solution_tab() {
        return $this->_solution_tab;
    }

    public function process_hints($hintdata) {
        $hints = array();
        $total = count($hintdata['hint']);
        for ($i = 0; $i < $total; $i++) {
            if (!$hintdata['hint'][$i]) {
                continue;
            }
            $hints[] = array(
                'hint' => $hintdata['hint'][$i],
                'sort_order' => (int) $hintdata['sort_order'][$i],
                'deduction' => (float) $hintdata['deduction'][$i]
            );
        }
        return $hints;
    }

    /**
     * Method to be implemented by subclasses to validate attributes as per
     * the type of the question
     */
    abstract public function validate_attributes(array $attributes);

    /**
     * Method the validate question data before storing in the db
     * This method will contain basic validation for the question model only
     * and will call the validate_attribute method implemented in the subclass
     * @param Array $data
     */
    public function validate($data) {        
        $question = ORM::factory('question');
        $validator = $question->validator($data);
        if (!$validator->check() || !$this->validate_attributes($data['attributes'])) {
            $this->_validation_errors = array_merge($this->_validation_errors, $validator->errors('question'));
            return false;
        } 
        return true;
    }

    /**
     * Method to save the question data in db
     * if the question is loaded it is updated
     * other wise a new question is added
     */
    public function save($data) {
        if (null === $this->_orm) {
            $this->_orm = ORM::factory('question');
        }
        $hints = $this->process_hints($data['hints']);
        $this->_attributes = $this->process_attrs($data['attributes']);
        $this->_orm->question = $data['question'];
        $this->_orm->extra = Arr::get($data, 'extra', '');
        $this->_orm->user_id = Auth::instance()->get_user()->id;
        $this->_orm->type = $this->_type;
        $this->_orm->save();
        $this->_orm->delete_all_hints()
            ->add_hints($hints)
            ->delete_all_attributes()
            ->add_attributes($this->_attributes);
    }
}
