<?php
include('dir.php');
$page_name="index"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<!-- Default Template -->

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
<head>
<title>Username Confirmation</title>
</head>
<body>

<?php

if(isset($_GET['q']) && !(isset($_SESSION[$k['id-token']]))){
$email=sn_dt($_GET['q']);
print "<b>".$email."</b>";

if(this_email_exists($email)){print" <span class='red'>is already in use. <a href='".$k['full_dir']."user/recover-password' target='_blank'>
				Please click here to get a new password if the email belongs to you</a> </span>";} 
else if(validate_email($email)){print" <span class='green'>is available </span>";}
else{ print" <span class='red'>is not valid </span>"; }
}




if(isset($_GET['q']) && isset($_SESSION[$k['id-token']])){
$email=sn_dt($_GET['q']);
print "<b>".$email."</b>";

if(validate_email($email) && !(this_email_exists($email)))
{print" <span class='green'>is available </span>";} 
else{
	
	if($m_info['email']==$email)
	{ print" <span class='red'>already belongs to you </span>";}else{
	print" <span class='red'>is not available </span>"; } }
}


?>




</body>
</html>