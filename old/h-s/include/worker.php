<?php
include('dir.php');
$page_name="index";
$token=hourly_token();
?>
<html>
<head>
<title>Worker</title>
<meta charset="utf-8"/>
<meta http-equiv="Content-Type" content="text/html"/>
<meta http-equiv="refresh" content="30"/>
</head>
<body>
<?php






//Precious Worker!
//Email Queue processing, Notification processing, Abandoned Session Processing...
//Delete Abandoned attachment and session
//Reminder for admin to review discussion, submitted quizzes




//Email Limit is 200 per hour per domain
$email_limit=180; //just so we are not too close
$cut_off=$k['epoch']-(60*60); //this is the last 1 hour.... all emails sent at time>cut_off must not be up to 200, else yawa don gas
$sql="SELECT `id` FROM `email` WHERE `epoch_sent`>='$cut_off' && `sent`='1' LIMIT 0,".$email_limit." ";
$result=query_sql($sql);
$left_to_send=$email_limit-(mysqli_num_rows($result));
if($left_to_send>0){
	//We can now send out emails if any is left unattended to
	if($left_to_send>5){ $left_to_send=5; } //limiting maximum emails that can be sent out at once to 5 to avoid server overload
	$sql="SELECT * FROM `email` WHERE `sent`='0' ORDER BY `priority` DESC, `epoch_submitted` ASC LIMIT 0,".$left_to_send." ";
	$result=query_sql($sql);
	while($f=mysqli_fetch_assoc($result)){ //time to send out email.... and update email
		
		sending_email($f['email'],retransform_quote($f['subject']),retransform_quote($f['content']),retransform_quote($f['footer']));
		$uql="UPDATE `email` SET `sent`='1',`epoch_sent`='".$k['epoch']."' WHERE `id`='".$f['id']."' ";
		$uesult=query_sql($uql);
		
	}	
}







?>
</body>
</html>