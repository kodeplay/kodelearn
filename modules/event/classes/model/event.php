<?php defined('SYSPATH') or die('No direct script access.');

class Model_Event extends ORM {

    protected $_has_many = array(
        'lectures' => array(
            'model'   => 'lecture',
            'through' => 'lectures_events',
        ),
    );
    
    protected $_belongs_to = array(
        'room' => array(
            'model' => 'room', 
            'foreign_key' => 'room_id'
        )
    );

    public function validator($data) {
        return Validation::factory($data)
            ->rule('date', 'date')
            ->rule('date', 'not_empty')
            ->rule('from', 'not_empty')
            ->rule('to', 'not_empty');
    }

    /**
     * Method to get all the events in the specified month of the year
     * @param int $month 0 < $month < 12
     * @param int $year > 1970 due to unix time stamp
     * @return Database_MySQL_Result
     */
    public static function monthly_events($month, $year) {
        // first date of the month
        $first = date("M-d-Y", mktime(0, 0, 0, $month, 1, $year));
        // last date of the month
        $last = date("M-d-Y", mktime(0, 0, 0, $month+1, 1, $year));
        // get the events having startdate in this month
        $event = ORM::factory('event')
            ->where('eventstart', 'BETWEEN', array(strtotime($first), strtotime($last)))
            ->find_all();
        return $event;
    }

    /**
     * Method to get all the events happening on a date
     * @param date format: 'YYYY-mm-dd'
     * @return Database_MySQL_Result
     */
    public static function daily_events($date) {
        $event = ORM::factory('event')
            ->where(DB::expr('DATE(FROM_UNIXTIME(eventstart))'), ' = ', $date)
            ->find_all();
        return $event;
    }
}
