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
        $event = Model_Event::monthly_events($month, $year);
        $day_events = array();
        // loop though events and group events by day and event types
        foreach ($event as $e) {
            $day = date('d', $e->eventstart);
            if (!isset($day_events[$day][$e->eventtype])) {
                $day_events[$day][$e->eventtype] = array();
            }
            $day_events[$day][$e->eventtype][] = array(
                'id' => $e->id,
            );
        }
        if ($day_events) {
            foreach ($day_events as $day=>$types) {
                $timestamp = mktime(0, 0, 0, $month, $day, $year);
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
            'Calendar', Url::site('Calendar')
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
        
        $view = View::factory('calendar/day_events')
            ->set('name', $this->request->post('name'));
        $this->content = $view;
    }
}
