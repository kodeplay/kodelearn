<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'from' => "info@kodelearn.com",
    'subject' => "Your Kodelearn Account Details",
    'html' => "<b>Dear {user_name},</b><br><br>
              Your account has been created on Kodelearn successfully.<br/>
              Please use the following details to login to your account <br/> <br/>
              Email: {email}, <br/>
              Password: {password} <br/> 
              <br><br>Thanks,<br> Kodelearn team  
              "   
);
