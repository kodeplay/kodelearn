<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cron extends Controller_Base {
    
    public function action_sendreminder() {
        $date = strtotime(date('d-m-Y'));
        $reminder = ORM::factory('reminder');
        $reminder->where('reminders.date', '=', $date);
        $reminder = $reminder->find();
        if($reminder->id){
            echo "reminder already sent";
            exit;
        } else {
            $reminder->date = $date;
            $reminder->save();
            Hook::instance()->trigger("send_reminder");    
        }
        
    }
}