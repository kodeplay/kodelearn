<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'from' => "info@kodelearn.com",
    'subject' => "Exam reminder",
    'html' => "<b>Dear {user_name},</b><br><br>
              This is a reminder for your {exam_name} exam scheduled on {date} at {time}<br>
              Prepare well and all the best
              <br><br>Thanks,<br> Kodelearn team  
              "   
);
