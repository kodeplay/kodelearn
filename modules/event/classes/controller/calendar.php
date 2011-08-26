<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Calendar extends Controller_Base {

    protected function template_filter() {
        $logged_in = Auth::instance()->logged_in();        
        $this->template = 'template/template_one_column';
    }

    public function action_index() {
        $view = View::factory('calendar/index')
            ->bind('calendar_markup', $calendar_markup)
            ->bind('day_events', $day_events);
        $month = Arr::get($_GET, 'month', date('m'));
        $year = Arr::get($_GET, 'year', date('Y'));
        $calendar = new Calendar($month, $year);
        $calendar->standard('prev-next');
        $event = Model_Event::monthly_events($month, $year);
        $day_events = array();
        // loop though events and group events by day and event types
        foreach ($event as $e) {
            $day = date('j-m', $e->eventstart);
            // echo 'date(\'j\', '. $e->eventstart .') = ' . $day . '=' . date('Y-m-d H:i:s', $e->eventstart) . ' <br/>';
            if (!isset($day_events[$day][$e->eventtype])) {
                $day_events[$day][$e->eventtype] = array();
            }
            $day_events[$day][$e->eventtype][] = array(
                'id' => $e->id,
            );
        }
        if ($day_events) {
            foreach ($day_events as $daymonth=>$types) {
                list($day, $month) = explode("-", $daymonth);                
                $timestamp = mktime(0, 0, 0, $month, (int)$day, $year);
                foreach ($types as $type=>$events) {
                    $count = count($events);
                    $type = $count > 1 ? Inflector::plural($type) : $type;
                    $calendar->attach(
                        $calendar->event()
                        ->condition('timestamp', (int)$timestamp)
                        ->output($count . ' ' . $type)
                    );
                }
            }
        }
        $calendar->attach(
            $calendar->event()
            ->condition('timestamp', time())
            ->add_class('today')
        );
        $calendar_markup = $calendar->render();
        Breadcrumbs::add(array(
            'Calendar', Url::site(sprintf('calendar?month=%s&year=%s', $month, $year))
        ));
        $day_events = Request::factory('calendar/day_events')
            ->method(Request::GET)
            ->execute()
            ->body();
        $this->content = $view;
    }

    public function action_day_events() {
        $year = $this->request->param('year', date('Y'));
        $month = $this->request->param('month', date('m'));
        $day = $this->request->param('day', date('d'));
        $date = date('Y-m-d', mktime(0, 0, 0, (int)$month, (int)$day, $year));
        $events = Model_Event::daily_events($date);
        $day_events = array();
        foreach ($events as $event) {
            $day_events[] = Event_Calendar::factory($event->eventtype)->day_event($event);
        }
        $view = View::factory('calendar/day_events')
            ->set('date', $date)
            ->set('day_events', $day_events);        
        $this->content = $view;
    }
}
