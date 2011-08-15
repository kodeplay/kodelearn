<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Exammarksheet extends Controller_Base {

    public static $action_acl_map = array(
        'view' => 'index',
    );

    /** 
     * View the marksheet of a student by passing a user_id in get
     * so will be accessible only to the admin and teacher
     * if no user is passed, a filter will be applied to check if 
     * its the current user trying to view his/her own marksheet or 
     * if its the parant trying to view the marksheet of their pupil
     */
    public function action_index() {
    	$relevant_user = Acl::instance()->relevant_user();
        if (!$relevant_user) {
            echo 'Not allowed';
            exit;
        }
        
    	$user = Auth::instance()->get_user();
        
        $course_ids = $user->courses->find_all()->as_array(NULL, 'id');
        if($course_ids){
            $exams = ORM::factory('exam');
            $exams->where('course_id', 'IN', $course_ids)->group_by('examgroup_id');
            $exams = $exams->find_all()->as_array(NULL, 'examgroup_id');
            
            if($exams){
                $examgroups = ORM::factory('examgroup');
                $examgroups->where('id', 'IN', $exams)->group_by('id');
                $examgroups = $examgroups->find_all();
            }else{
                $examgroups="";
            }
        }else{
           $examgroups="";
        }
        
    	$view = View::factory('examresult/index')
    	               ->bind('examgroup', $examgroups);
    	
    	$this->content = $view;
    	
    }
    
    public function action_details() {
         $relevant_user = Acl::instance()->relevant_user();
        // check if admin in which _case_ a user_id in the get param is required
        if (!$relevant_user) {
            $user_id = $this->request->param('user_id');
            $relevant_user = ORM::factory('user', $user_id);
           
        }
        if (!$relevant_user) {
            echo 'Not allowed';
            exit;
        }
       
        $user_id = $relevant_user->id;
        $examgroup_id = $this->request->param('examgroup_id');
        $marksheet = ORM::factory('exam');
        $marksheet->select('marks')
             ->join('examresults','left')
             ->on('examresults.exam_id', '=', 'id');
        $marksheet->and_where_open()
                  ->where('examresults.user_id', '=', $user_id)
                  ->or_where('examresults.user_id', 'IS', NULL)
                  ->and_where_close()
                  ->and_where_open()
                  ->and_where('exams.examgroup_id', '=', $examgroup_id)
                  ->and_where_close();
                  
        $marksheet = $marksheet->find_all();
        $flg = 0;
        foreach($marksheet as $mark) {
            if($mark->marks != NULL){
               $flg++;
            } 
            //echo "<br>";
        }
        $view = View::factory('examresult/exammarksheet')
                    ->bind('marksheets', $marksheet)
                    ->bind('flg', $flg)
                    ->bind('relevant_user', $relevant_user);
        
        $this->content = $view; 
    }
    // @todo
    public function action_pdf() {
        

    }

    // @todo
    public function action_print() {



    }
}
