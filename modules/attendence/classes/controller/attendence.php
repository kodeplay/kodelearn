<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Attendence extends Controller_Base {
    
    public function action_index(){
        
        $relevant_user = Acl::instance()->relevant_user();
        
        if($relevant_user){
            $this->get_single_attendence();
        } else {
            $this->get_attendence_list();
        }
    }
    
    private function get_attendence_list() {
        $date = date('Y-m-d');
        $lecture_exam_data_all = $this->get_event_data($date);
        
        $users = View::factory('attendence/events')
            ->bind('lecture_exam_data_all', $lecture_exam_data_all)
            ;
        $view = View::factory('attendence/list')
            ->bind('users', $users)
            ->bind('date', $date);
        
        Breadcrumbs::add(array(
            'Attendence', Url::site('attendence')
        ));
            
        $this->content = $view;
    }
    
    public function action_get_events() {
        $date = $this->request->post('date');
        $lecture_exam_data_all = $this->get_event_data($date);
        $view = View::factory('attendence/events')
            ->bind('lecture_exam_data_all', $lecture_exam_data_all)
            ;
        $response = $this->response->body($view)->body();
        echo json_encode(array('response' => $response));
    }
    
    private function get_event_data($date){
        $dstring = strtotime($date);
        $end_dstring = $dstring + 86400;
        $event = ORM::factory('event');
        $event->where('eventstart', 'BETWEEN', array($dstring,$end_dstring));
        $events = $event->find_all();
        $exam_id = array();
        $lecture_id = array();
        foreach($events as $event_data){
            if($event_data->eventtype == 'exam'){
                $exam_id[] = $event_data->id;   
            } else if($event_data->eventtype == 'lecture'){
                $lecture_id[] = $event_data->id; 
            }
        }
        
        $exams ="";
        if($exam_id){
            $exam = ORM::factory('exam');
            $exam->select('events.eventstart','events.eventend','events.eventtype');
            $exam->join('events','left')
                 ->on('events.id','=','event_id');
            $exam->where('event_id', 'IN', $exam_id);
            $exams = $exam->find_all();
        }
        $lectures="";
        if($lecture_id){    
            $lecture = ORM::factory('lecture');
            $lecture->select('events.eventstart','events.eventend','events.eventtype');
            $lecture->join('lectures_events','left')
                    ->on('id','=','lectures_events.lecture_id')
                    ->join('events','left')
                    ->on('events.id','=','lectures_events.event_id');
            $lecture->where('lectures_events.event_id', 'IN', $lecture_id);
            $lectures = $lecture->find_all();
        }
        $lecture_exam_data_all = array();
        
        if($exams && (count($exams)>0)){ 
            foreach($exams as $exam_data){
                $lecture_exam_data = array();
                $lecture_exam_data['name'] = $exam_data->name;
                $lecture_exam_data['eventstart'] = $exam_data->eventstart;
                $lecture_exam_data['eventend'] = $exam_data->eventend;
                $lecture_exam_data['eventtype'] = $exam_data->eventtype;
                $lecture_exam_data['id'] = $exam_data->id;
                $lecture_exam_data_all[] = $lecture_exam_data;
            }
        }
        if($lectures && (count($lectures)>0)){ 
            foreach($lectures as $lecture_data){
                $lecture_exam_data = array();
                $lecture_exam_data['name'] = $lecture_data->name;
                $lecture_exam_data['eventstart'] = $lecture_data->eventstart;
                $lecture_exam_data['eventend'] = $lecture_data->eventend;
                $lecture_exam_data['eventtype'] = $lecture_data->eventtype;
                $lecture_exam_data['id'] = $lecture_data->id;
                $lecture_exam_data_all[] = $lecture_exam_data;
            }
        }
        return $lecture_exam_data_all;
    }
    
    public function action_add(){
        if($this->request->method() === 'POST' && $this->request->post('selected')){
            $event_id = $this->request->post('id');
            $course_id = $this->request->post('course_id');
            $user = ORM::factory('user');
            $user->join('courses_users','left')
                 ->on('courses_users.user_id','=','id');
            $user->where('courses_users.course_id','=',$course_id); 
            $users = $user->find_all();
            DB::delete('attendences')->where('event_id', '=', $event_id)
                       ->execute(Database::instance());
            foreach($users as $user){
               $attendence = ORM::factory('attendence');
                if(in_array($user->id, $this->request->post('selected'))){
                   $attendence->user_id = $user->id;
                   $attendence->event_id = $event_id;
                   $attendence->present = '1';
                   $attendence->save();
                }else{
                   $attendence->user_id = $user->id;
                   $attendence->event_id = $event_id;
                   $attendence->present = '0';
                   $attendence->save();
                }
            }
        }
        $id = $this->request->param('id');
        $type = $this->request->param('type');
        if(!$id || !$type){
            Request::current()->redirect('attendence');
        }
        
        if($type == 'exam'){
            $exam = ORM::factory('exam', $id);
            $cid = $exam->course_id;
            $event = $exam->name;
        }
        if($type == 'lecture'){
            $lecture = ORM::factory('lecture', $id);
            $cid = $lecture->course_id;
            $event = $lecture->name;
        }
        
        $user = ORM::factory('user');
        $user->join('courses_users','left')
             ->on('courses_users.user_id','=','id');
        $user->where('courses_users.course_id','=',$cid); 
        $users = $user->find_all();
        
        $page_title = Kohana::message('page_title', 'attendence_add.title');
        
        $page_title = str_replace('{event}', $event, $page_title);
        $assigned_attendence = ORM::factory('attendence');
        $assigned_attendence->where('event_id', '=', $id);
        $assigned_attendences = $assigned_attendence->find_all()->as_array('user_id','present');
        
        $data = array(
            'add'       => URL::site('/attendence/add'),
            'id'        => $id,
            'course_id' => $cid
        );
        $view = View::factory('attendence/form')
            ->bind('users', $users)
            ->bind('page_title', $page_title)
            ->bind('assigned_attendences', $assigned_attendences)
            ->bind('data', $data)
            ;
        
        Breadcrumbs::add(array(
            'Attendence', Url::site('attendence')
        ));
            
        $this->content = $view;
        
    }
}