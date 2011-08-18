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
        $calendar = new Calendar(Arr::get($_GET, 'month', date('m')), Arr::get($_GET, 'year', date('Y')));
        $calendar->attach(
            $calendar->event()
            ->condition('timestamp', time())
            ->output(html::anchor('http://google.de', 'google'))
            ->add_class('today')
        );
        $calendar_markup = $calendar->render();
        Breadcrumbs::add(array(
            'Calendar', Url::site('Calendar')
        ));
        $day_events = Request::factory('calendar/day_events')
            ->method(Request::POST)
            ->post(array('name' => 'vineet'))
            ->execute()
            ->body();
        $this->content = $view;
    }

    public function action_day_events() {
        $view = View::factory('calendar/day_events')
            ->set('name', $this->request->post('name'));
        $this->content = $view;
    }
}
