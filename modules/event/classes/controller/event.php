<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Event extends Controller_Base {
	
	public function action_edit(){
		
		if($this->request->method() === 'POST' && $this->request->post()){
			$event = ORM::factory('event', $this->request->post('event_id'));
            $validator = $event->validator($this->request->post());
            
            if ($validator->check()) {
            	
                $from = strtotime($this->request->post('date')) + ($this->request->post('from') * 60); 
                $to = strtotime($this->request->post('date')) + ($this->request->post('to') * 60); 

                $event->room_id = $this->request->post('room_id');
            	$event->eventstart = $from;
            	$event->eventend = $to;
            	$event->save();
            	
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
		
		$event = ORM::factory('event', $id);
		
        $form = new Stickyform('', array(), (array()));
		
		$form->default_data = array(
            'date'          => '',
		    'room_id'       => '',
            'from'          => '',
            'to'            => '',
		);

        $form->saved_data = array('date' => date('Y-m-d', $event->eventstart));
        
        $form->append('Date', 'date', 'text', array('attributes' => array('class' => 'date')));
        $form->append('Room', 'room_id', 'select', array('options' => array()));
        $form->append('From', 'from', 'hidden', array('attributes' => array('id' => 'slider-range_from')));
        $form->append('To', 'to', 'hidden', array('attributes' => array('id' => 'slider-range_to')));
        
        $form->process();
        
        $slider = array(
            'start' => ($event->eventstart - strtotime(date('Y-m-d', $event->eventstart))) / 60,
            'end' => ($event->eventend - strtotime(date('Y-m-d', $event->eventend))) / 60
        );
        
        $view = View::factory('event/edit')
		               ->bind('event', $event)
		               ->bind('form', $form)
		               ->bind('slider', $slider);
		
		$this->content = $view;
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
