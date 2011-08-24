<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Event extends Controller_Base {
	
	public function action_edit(){
		
		$id = $this->request->param('id');
		
		$event = ORM::factory('event', $id);
		
        $form = new Stickyform('', array(), (array()));
		
		$form->default_data = array(
            'date'          => '',
        );

        $form->saved_data = array('date' => date('Y-m-d', $event->eventstart));
        
        $form->append('Date', 'date', 'text', array('attributes' => array('class' => 'date')));
        
        $form->process();
        
        $view = View::factory('event/edit')
		               ->bind('event', $event)
		               ->bind('form', $form);
		
		$this->content = $view;
	}

	public function action_get_avaliable_rooms(){
        
        $from = $this->request->post('date') . ' ' . $this->request->post('from');
        if(!(strtotime($from)))
            $from = $this->request->post('date') . ' 00:00';
        
        $to = $this->request->post('date') . ' ' . $this->request->post('to'); 
        if(!(strtotime($to)))
            $to = $this->request->post('date') . ' 00:00';
        
        $from = strtotime($from);
        $to = strtotime($to);
        
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
