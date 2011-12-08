<?php defined('SYSPATH') or die('No direct script access.');

class Notice_Exam {

    /**
     * Generic function just to keep the code DRY
     */
    public static function notice_exam_email($exam, $subject, $template) {
        $users = Model_Course::get_users($exam->course_id);
        $recipients = Notice::email_recipients($users);
        $view = View::factory($template)
            ->set('exam', $exam);
        $body = $view->render();
        $subject = 'Kodelearn Exam Notice: ' . $subject;
        Notice::email($recipients, $subject, $body);
    }

    /**
     * Callback function when exam create event is dispatched
     */
    public static function email_create($exam, $event) {
        $subject = 'New Exam scheduled for students of ' . $exam->course->name;
        self::notice_exam_email($exam, $subject, 'notice/email/exam_create');
    }     

    /**
     * Callback function when exam_rechedule event is dispatched
     */
    public static function email_reschedule($exam, $event) {
        $subject = 'Exam ' . $exam->name . ' has been rescheduled to ' . $exam->format_scheduled_date() . ' at ' . $exam->format_starttime();
        self::notice_exam_email($exam, $subject, 'notice/email/exam_reschedule');
    }

    /**
     * Callback function when exam_relocate event is dispatched
     */
    public static function email_relocate($exam, $event) {
        $subject = 'Exam ' . $exam->name . ' has been relocated to ' . $exam->location();
        self::notice_exam_email($exam, $subject, 'notice/email/exam_relocate');
    }

    public static function email_reminder($exam, $event) {
        
    }
}

