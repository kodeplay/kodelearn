<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Event Calendar Helper class
 * If for any event, a class extending this one is not found, 
 * this class will be used as the fall back. 
 * This is behaviour is implemented in static factory function
 * 
 */
class Event_Calendar {

    protected $_instance = null;

    public static function factory($type) {
        $file = MODPATH . $type . '/classes/' . $type . '/calendar.php';
        if(file_exists($file)){
            $class = ucfirst($type) . '_Calendar';
            return new $class;
        } else {
            return new Event_Calendar();
        }
    }

    /**
     * Method to get the day_event partial html if any event type doesnt have
     * an explicit calendar partials
     * @param mixed (int|Model_Event) $event_id or $event object
     * @return String html
     */
    public function day_event($event) {
        $data = $this->event_data($event);
        $view = View::factory('calendar/partial_event')
            ->bind('event', $data)
            ->set('room', $data['room']);        
        unset($data['room']);
        return $view->render();
    }

    /**
     * Method to get Calendar related data for an event
     */
    protected function event_data($event) {
        if (!$event instanceof Model_Event) {
            $event = ORM::factory('event', (int)$event);
        }
        $time = sprintf('%s to %s', date('g:i A', $event->eventstart), date('g:i A', $event->eventend));
        $data = array_merge($event->as_array(), array(
            'timings' => $time,
            'room' => ORM::factory('room', $event->room_id),
        ));
        return $data;
    }
}