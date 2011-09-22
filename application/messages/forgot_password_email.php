<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'from' => "info@kodelearn.com",
    'subject' => "Change password",
    'html' => "<b>Dear {user_name},</b><br><br>
              Please follow the link to change your password <br>
              {password_url}
              <br><br>Thanks,<br> Kodelearn team  
              "   
);
