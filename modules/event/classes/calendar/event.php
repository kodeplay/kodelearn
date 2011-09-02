<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Event Calendar Helper class
 * If for any event, a class extending this one is not found, 
 * this class will be used as the fall back. 
 * This is behaviour is implemented in static factory function
 * 
 */
class Calendar_Event {

    protected $_instance = null;

    public static function factory($type) {
        $file = MODPATH . $type . '/classes/calendar/' . $type . '.php';
        if(file_exists($file)){
            $class = 'Calendar' . '_' . ucfirst($type);
            return new $class($type);
        } else {
            $type = 'event';
            return new Calendar_Event($type);
        }
    }

    public function __construct($type) {
        $this->_type = $type;
    }

    /**
     * Method to get the event_data and bind it to the appropriate view object
     * This will work even for the subclasses as it will set the view variable 
     * correctly as per the array returned by the event_data method so,
     * only the event_data method will have to be overriden
     * @param mixed (int|Model_Event) $event_id or $event object
     * @return String html
     */
    public function day_event($event) {
        $data = $this->event_data($event);
        $partial = sprintf('calendar/partial_%s', $this->_type);
        $view = View::factory($partial);
        foreach ($data as $key=>$value) {
            $view->set($key, $value);
        }
        return $view->render();
    }

    /**
     * Method to get data array to be bound to the view
     * All Subclasses are expected to override this method 
     * merging any other event type specific data required in the view
     * to the array and return the relevant array
     * @param mixed (int|Model_Event) $event_id or $event object
     * @return Array 
     */
    protected function event_data($event) {
        if (!$event instanceof Model_Event) {
            $event = ORM::factory('event', (int)$event);
        }
        $time = sprintf('%s to %s', date('g:i A', $event->eventstart), date('g:i A', $event->eventend));
        $event_arr = $event->as_array();
        $data = array(
            'event' => $event,
            'timing' => $time,
            'room' => ORM::factory('room', $event->room_id),
        );
        return $data;
    }
}
