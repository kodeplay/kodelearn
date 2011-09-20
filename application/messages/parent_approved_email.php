<?php defined('SYSPATH') or die('No direct script access.');

return array(
    'from' => "info@kodelearn.com",
    'subject' => "Kodelearn Parent Registration confirmation",
    'html' => "<b>Dear {parent_name},</b><br><br>
              Your child '{child_name}' has registered on Kodelearn. <br>The link to access your account is {url} <br>  
              User name : {parent_email}<br>
              Set password first : {password_url}
              <br><br>Thanks,<br> Kodelearn team 
              "   
);
