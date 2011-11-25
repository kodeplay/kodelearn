<?php defined('SYSPATH') or die('No direct script access.');

abstract class Question {

    /**
     * @type int
     * A pseudo index or question number that will be given to this question
     * while a test is being taken
     * Its NOT the question_id
     */
    protected $_idx;

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
     * How many marks is will a correct answer to this question give
     * Default value is 1
     * Can be set from outside using a setter function
     */
    protected $_marks = 1;

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
     * Method to get the type of the solution tab name
     * @return String type
     */
    abstract public function solution_tab();

    /**
     * Method to be implemented by subclasses to validate attributes as per
     * the type of the question.
     * @param Array $attributes - These attributes are what is submitted in the form
     * ie non-processed attributes
     */
    abstract public function validate_attributes(array $attributes);

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
     * Combined Setter/Getter Method for the idx of the questions
     * (refer property declaration for more info on what is idx) 
     * It is _not_ equal to the question_id in database
     * @return String idx
     */
    public function idx($idx=null) {
        if ($idx == null) {
            return $this->_idx;
        }
        $this->_idx = $idx;
    }

    /**
     * Combined setter-getter for marks
     */
    public function marks($marks=null) {
        if ($marks == null) {
            return $this->_marks;
        }
        if (is_numeric($marks)) {
            $this->_marks = $marks;
        }
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
        $this->_orm->course_id = Arr::get($data, 'course_id');
        $this->_orm->user_id = Auth::instance()->get_user()->id;
        $this->_orm->type = $this->_type;
        $this->_orm->save();
        $this->_orm->delete_all_hints()
            ->add_hints($hints)
            ->delete_all_attributes()
            ->add_attributes($this->_attributes);
    }

    /**
     * Method to show the question
     * @param bool $preview optional, default=false
     */
    public function render_question($preview=false) {
        $view = View::factory('question/partial_question')
            ->set('preview', $preview)
            ->set('idx', $this->_idx != null ? $this->_idx : '')
            ->bind('question', $question)
            ->bind('has_math_expr', $has_math_expr)
            ->bind('answer_template', $answer_template);
        $question = $this->_orm;
        $hints = $this->_orm->hints_as_array();
        $has_math_expr = $this->_orm->has_math();
        $answer_template = $this->render_answer_partial();
        return $view->render();
    }

    /**
     * Method to get the markup for the answer part of the display
     * Each type of question will have a different template so this
     * method will have to be implemented by all the subclasses
     * @return String html
     */
    abstract public function render_answer_partial();
    
    /**
     * Method to check if the answer to this question is correct
     * This will depend upon the type of question and hence implementation
     * will be in the subclasses
     * @param String $answer
     * @return Boolean $result whether correct or not
     */
    abstract public function check_answer($answer);

    /**
     * Method to show the answer review which will give an idea to the student
     * as to why the answer was correct or wrong and how much marks he/she
     * gained/lost
     * @param String submitted answer
     * @return String Html the view of the answer review in the apt format
     */
    abstract public function answer_review($submitted_answer);
}
