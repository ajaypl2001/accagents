<?php
$body_msg3 = 'hello 33';

$subject3 = 'Email Template1 Pushpa';
$headers3 = "MIME-Version: 1.0" . "\r\n";
$headers3 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers3 .= 'From: Testing<no-reply@aoltorontoagents.ca>' . "\r\n";
$headers3 .= 'Cc: pushpa.ess@yahoo.com' . "\r\n";
// $headers3 .= 'Cc: pushpa@essglobal.com' . "\r\n";
// $headers3 .= 'Cc: sanjiv@essglobal.com' . "\r\n";

$to3 = 'jassi14@live.in';	
mail ($to3,$subject3,$body_msg3,$headers3);
?>