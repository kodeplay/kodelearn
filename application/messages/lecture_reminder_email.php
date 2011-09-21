<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'from' => "info@kodelearn.com",
    'subject' => "Lecture reminder",
    'html' => "<b>Dear {user_name},</b><br><br>
              This is a reminder for your {lecture_name} lecture scheduled tommorow at {time}. <br>
              Please attend.
              <br><br>Thanks,<br> Kodelearn team  
              "   
);
