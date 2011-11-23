<?php defined('SYSPATH') or die('No direct script access.');

class Model_Flashcard extends ORM {
    
    public function validator($data) {
        return Validation::factory($data)
            ->rule('title', 'not_empty')
            ->rule('title', 'min_length', array(':value', 3))
            ->rule('description', 'not_empty');
    }
    
    public static function flashcards($criteria=array()) {
        
        $flashcard = ORM::factory('flashcard');
              
        $filters = Arr::get($criteria, 'filters', array());
        if (isset($filters['title'])) {
           $flashcard->where('flashcards.title', 'LIKE', '%' . $filters['title'] . '%');
        } 
               
        if (isset($filters['description'])) {
            $flashcard->where('flashcards.description', 'LIKE', '%' . $filters['description'] . '%');
        }        
        
        $flashcard->where('flashcards.course_id', '=',  Session::instance()->get('course_id'));
        
        if (isset($criteria['sort'])) {
            $flashcard->order_by("flashcards.".$criteria['sort'], Arr::get($criteria, 'order', 'ASC'));
        }
        
        if (isset($criteria['limit'])) {
            $flashcard->limit($criteria['limit'])
                      ->offset(Arr::get($criteria, 'offset', 0));            
        }
        
        return $flashcard->find_all();
        
    }
    
    public static function flashcard_total($criteria=array()) {
        
        $flashcard = ORM::factory('flashcard');
                
        $filters = Arr::get($criteria, 'filters', array());
        if (isset($filters['title'])) {
            $flashcard->where('flashcards.title', 'LIKE', '%' . $filters['title'] . '%');
        }        
        if (isset($filters['description'])) {
            $flashcard->where('flashcards.description', 'LIKE', '%' . $filters['description'] . '%');
        }        
        $flashcard->where('flashcards.course_id', '=',  Session::instance()->get('course_id'));
        
        return $flashcard->count_all();
    } 
    
    public static function insert_flashcard_question($flashcard_id, $questions_array = array()) {
        DB::delete('flashcards_questions')->where('flashcard_id', '=', $flashcard_id)
                       ->execute();
        foreach($questions_array as $sel_question) {
           
            $query = DB::insert('flashcards_questions', array('flashcard_id' ,'question_id'));
            $query->values(array($flashcard_id, $sel_question));
            $query->execute();  
           
        }
        
    } 
    
    public static function question_count($flashcard_id) {
       $query = DB::select()
                    ->from('flashcards_questions')
                    ->where('flashcard_id', '=', $flashcard_id)
                    ->execute();
       return $query->count();
        
    } 
    
    public static function getQuestions($flashcard_id) {
       $query = DB::select('question_id')
                    ->from('flashcards_questions')
                    ->where('flashcard_id', '=', $flashcard_id)
                    ->execute()->as_array(null,'question_id');
       
       return $query;
        
    }

    public static function getQuestionsAndAnswers($question_id = array()) {
        $questions = ORM::factory('question');    
        $questions->select('questionattributes.*')
                  ->join('questionattributes', 'LEFT')
                  ->on('questions.id', ' = ', 'questionattributes.question_id');
        $questions->where('id', ' IN ', $question_id);
        $questions->where('correctness', ' = ', '1');
        
        return $questions->find_all();
    }
    
    public static function get_questions($course_id) {
        $questions = ORM::factory('question');
        $questions->select('questionattributes.*')
                  ->join('questionattributes', 'LEFT')
                  ->on('questions.id', ' = ', 'questionattributes.question_id');
        $questions->where('course_id', ' = ', $course_id);
        $questions->where('type', ' IN ', array('open','choice'));
        $questions->where('correctness', ' = ', '1');
        
        return $questions->find_all();
    }
}