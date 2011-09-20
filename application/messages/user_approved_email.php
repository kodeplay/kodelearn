<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'from' => "info@kodelearn.com",
    'subject' => "Kodelearn User Registration confirmation",
    'html' => "<b>Dear {user_name},</b><br><br>
              Your account has been created on Kodelearn. <br>The link to access your account is {url} <br>  
              User name : {user_email}<br>
              Set password first : {password_url}
              <br><br>Thanks,<br> Kodelearn team 
              "   
);