<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Event extends Controller_Base {
    
    public function action_edit(){
        
        if($this->request->method() === 'POST' && $this->request->post()){
            $event = ORM::factory('event', $this->request->post('event_id'));
            $validator = $event->validator($this->request->post());
            
            $lecture = ORM::factory('lecture', $this->request->post('lecture_id'));
            
            if ($validator->check()) {
                
                $from = strtotime($this->request->post('date')) + ($this->request->post('from') * 60); 
                $to = strtotime($this->request->post('date')) + ($this->request->post('to') * 60); 

                $event->room_id = $this->request->post('room_id');
            	$event->eventstart = $from;
            	$event->eventend = $to;
            	$event->cancel = (int) $this->request->post('cancel');
            	$event->save();
                
            	$lecture->start_date = $from;
            	$lecture->end_date  = $to;
            	$lecture->save();
            	
            	if($this->request->post('cancel')){
                    $feed = new Feed_Lecture();
                    
                    $feed->set_action('canceled');
                    $feed->set_course_id($event->course_id);
                    $feed->set_respective_id($event->id);
                    $feed->set_actor_id(Auth::instance()->get_user()->id); 
                    $feed->save();
                    $feed->subscribe_users();
            	}
                
                $json = array(
                    'success'   => 1,
                    'message'   => array('Event is edited successfully')
            	);
            } else {
            	$json = array(
                    'success'   => 0,
                    'errors'    => array_values($validator->errors('exam'))
            	);
                
            }
            echo json_encode($json);
            exit;
        }
        
        $id = $this->request->param('id');
        
        $lecture_id = $this->request->param('lectId');
        
        $event = ORM::factory('event', $id);
        
        $form = new Stickyform('', array(), (array()));
        
        $form->default_data = array(
            'date'          => '',
            'room_id'       => '',
            'from'          => '',
            'to'            => '',
            'cancel'        => '1'
        );
        
        $conflict_event = $event->get_conflict_event();
        $event_details = array();
        if($conflict_event){
            $class = 'Event_'.$conflict_event->eventtype;
            $dynamic_object = new $class($conflict_event->id);
            $event_details = $dynamic_object->get_event_details();		
        }

        $form->saved_data = array('date' => date('Y-m-d', $event->eventstart), 'cancel' => $event->cancel);
        
        $form->append('Date', 'date', 'text', array('attributes' => array('class' => 'date')));
        $form->append('Room', 'room_id', 'select', array('options' => array()));
        $form->append('From', 'from', 'hidden', array('attributes' => array('id' => 'slider-range_from')));
        $form->append('To', 'to', 'hidden', array('attributes' => array('id' => 'slider-range_to')));
        $form->append('Cancel', 'cancel', 'checkbox', array('attributes' => array('value' => 1)));
        
        $form->process();

        $slider = array(
            'start' => ($event->eventstart - strtotime(date('Y-m-d', $event->eventstart))) / 60,
            'end' => ($event->eventend - strtotime(date('Y-m-d', $event->eventend))) / 60
        );
        
        $view = View::factory('event/edit')
            ->bind('event', $event)
            ->bind('form', $form)
            ->bind('slider', $slider)
            ->bind('conflict_event', $conflict_event)
            ->bind('event_details', $event_details)
            ->bind('lecture_id', $lecture_id)
            ;
        
        echo json_encode(array(
            'success' => 1,
            'html' => $view->render(),
        ));
        exit;
    }

    public function action_get_avaliable_rooms(){
        
        $from = strtotime($this->request->post('date')) + ($this->request->post('from') * 60); 
        $to = strtotime($this->request->post('date')) + ($this->request->post('to') * 60); 
        
        $event_id = $this->request->post('event_id');
        
        $results = Event_Abstract::get_avaliable_rooms($from, $to, $event_id);
        
        $rooms = array();
        foreach($results as $room){
            $rooms[$room->id] = $room->room_number . ', ' . $room->room_name;
        }
        
        $room_id = 0;
        
        if($event_id){
            $event = ORM::factory('event', $event_id);
            $room = ORM::factory('room', $event->room_id);
            $room_id = $room->id;
        }
        
        $element = Form::select('room_id',$rooms, $room_id);
        
        echo json_encode(array('element' => $element));
        
    }
}
