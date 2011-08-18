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
        $date = date('2011-8-18');
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
        
        /*
        $lecture = ORM::factory('lecture');
        $lecture->join('lectures_events','left')
                ->on('lectures_events.lecture_id','=','lectures.id');
        $lecture->where('lectures_events.event_id', 'IN', $exam_id);
        $lectures = $lecture->find_all();
       
        foreach($exams as $exam_data){
            echo $exam_data->eventend;
            echo"<br>";
        }exit;
         */
        $users = View::factory('attendence/events')
            ->bind('exams', $exams)
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
            $exam->join('events','inner')
                 ->on('events.id','=','event_id');
            $exam->where('event_id', 'IN', $exam_id);
            $exams = $exam->find_all();
        }
              
        $view = View::factory('attendence/events')
            ->bind('exams', $exams)
            ;
        $response = $this->response->body($view)->body();
        echo json_encode(array('response' => $response));
    }
}