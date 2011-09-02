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
     * Method to get the teacher associated with this event
     * In case- no teacher is associated, then return 0
     * @return mixed (null|Model_User)
     */
    public function associated_teacher() {
        $event = Event_Abstract::factory($this->eventtype, $this->id);
        if (method_exists($event, 'associated_teacher')) {
            return $event->associated_teacher();
        }
        return null;
    }

    public function is_cancelled() {
        return (bool) $this->cancel;
    }

    /**
     * Method to get all the events in the specified month of the year
     * excluding the cancelled events
     * @param int $month 0 < $month < 12
     * @param int $year > 1970 due to unix time stamp
     * @return Database_MySQL_Result
     */
    public static function monthly_events($month, $year) {
        // first date of the month
        $first = mktime(0, 0, 0, $month, 1, $year);
        // last date of the month
        $last = mktime(0, 0, 0, $month+1, 1, $year);
        // find out the padding days from previous and next months and also consider them
        $padding_days = array(
            'prev' => (int)date('N', $first)%7,
            'next' => 7 - (int) date('N', $last)
        );
        $first = $first - $padding_days['prev'] * (60*60*24);
        $last = $last + $padding_days['next'] * (60*60*24);
        $user = Acl::instance()->relevant_user();
        if ($user instanceof Model_User) {
            $courses = $user->courses->find_all()->as_array(null, 'id');
            $event = ORM::factory('event')
                ->where('eventstart', 'BETWEEN', array($first, $last))
                ->where('events.course_id', 'IN', DB::expr('(' . implode(", ", $courses) . ')'))
                ->where('events.cancel', ' = ', 0)
                ->find_all();
        } else {
            $event = ORM::factory('event')
                ->where('eventstart', 'BETWEEN', array($first, $last))
                ->where('events.cancel', ' = ', 0)
                ->find_all();
        }
        return $event;
    }

    /**
     * Method to get all the events happening on a date
     * including the cancelled events and indicate if its cancelled
     * @param date format: 'YYYY-mm-dd'
     * @return Database_MySQL_Result
     */
    public static function daily_events($date) {
        $user = Acl::instance()->relevant_user();
        if ($user instanceof Model_User) {
            $courses = $user->courses->find_all()->as_array(null, 'id');
            $event = ORM::factory('event')
                ->where(DB::expr('DATE(FROM_UNIXTIME(eventstart))'), ' = ', $date)
                ->where('events.course_id', 'IN', DB::expr('(' . implode(", ", $courses) . ')'))
                ->order_by('eventstart', 'ASC')
                ->find_all();
        } else {
            $event = ORM::factory('event')
                ->where(DB::expr('DATE(FROM_UNIXTIME(eventstart))'), ' = ', $date)
                ->order_by('eventstart', 'ASC')
                ->find_all();
        }
        return $event;
    }
    
    public function get_Attendance(){
        $user = Auth::instance()->get_user();
        $attendance = ORM::factory('attendance');
        $attendance->where('attendances.user_id','=',$user->id)
                   ->where('attendances.event_id','=',$this->id)     ;
        $attendances = $attendance->find();
        return $attendances;
    }
    
}
