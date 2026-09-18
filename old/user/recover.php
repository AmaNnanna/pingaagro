<?php 
include('dir.php');
$page_name="recover";
$meta_title="Recover lost password";
$meta_description="If you have forgotten your password, enter your account email to receive a password recovery link";
$meta_keywords="forgot password, recover password, troubleshoot login, login problem";
visitor_only();
include($k['f_dir'].'include/header.php');
?>



<div class='layout-600'>
<h1 class='title-font title'>Recover Password</h1>



<?php
//DATA COLLECTION
if(isset($_POST['recover']) && isset($_POST['token_test'])){
//check for spam first
if(sn_dt($_POST['token_test'])==hourly_token()){
	
//sanitize the data
$email=sn_dt($_POST['email']);
$error_message='';
if(!(validate_email($email))){ $error_message.='<div>The email address is invalid.</div>'; }
if(!(this_email_exists($email))){ $error_message.='<div>This email does not exist. You may register.</div>'; }
if(isset($_SESSION['recover_email'])){if($_SESSION['recover_email']==$email)
{$error_message.='<div>You have already requested for recovery link! Please check your email or try again later</div>';}}

//sanitize done, now time to send link...
if($error_message==''){
	
$account_info=get_user_info($email);
$recovery_token=get_token($email.date('Y-m').$account_info['password']);
$full_url=$k['full_dir'].'user/decoder.php?token='.$recovery_token.'&email='.$email;
$subject=$account_info['name'].", there is a request to change your password";
$footer="You received this message because you or someone requested for a recovery link with ".$email.". You may ignore the message if it is in error.";
$message="<b>Hello ".$account_info['name']."!</b> Here is a link to recover your account.
<p>
Click <a href='".$full_url."'>here</a> 
".$full_url." and choose a new password. It could expire, depending on when you clicked it.
</p>";
//sending_email($email,$subject,$message,$footer);
email_queue($email,$subject,$message,$footer,'1');
$_SESSION['recover_email']=$email;
$recover_success=true;
// alert me now of the success
$success_message="<b>Please check your email to see if a link has been sent. Remember to check your spam/junk folder. 
You need to use a recovery link in that email to complete this process.</b>";
display_s_m($success_message);

display_t_m("<span class='bold'>Did not receive email?</span>
				  <div>
				  <ol>
				  <li>
				  Your email may take up to 10 minutes to arrive (depending on your email service provider), please do not repeat action again.
				  </li>
				  <li>
				  Please check if your mailbox works or if it goes to trash/spam folder or your mail inbox is full.
				  </li>
				  <li>
				  Network anomalies may cause loss of messages, please re-submit request or try again later with different browsers or with browser cookies cleared.
				  </li>
				  <li>
				  Check with your email operator to see if verification code email has been blocked
				  </li>
				  <li>
				  Write us an email from our contact page to help out
				  </li>
				  </ol>
				  </div>"); 



} else { // there were error messages
display_e_m($error_message);
}
}
}
?>








<?php if(!(isset($recover_success))){ ?>

<form action='<?php print $k['full_dir']."user/recover-password"; ?>' method='post'>

<div class='red up-down white-box small'>
If you have forgotten your password, enter your account email to receive a password recovery link. 
From your email, click the link and choose a new password.
</div>

<div class='form-table'>
Email <br/> 
<input type='email' class='input width-full' value='<?php r_f_p('email'); ?>' name='email' required='required' title='Enter a Valid Email'>
<div class='small red'> Password recovery link will be sent to this email, so you must have access to the address</div>
</div>

<input type='text' class='hidden' name='token_test' title='Please enter your last name' value='<?php print hourly_token();  ?>'/>

<div class='form-table'>
<input type='submit' value='Recover password' class='submit' name='recover'>
</div>
</form>



<?php } ?>






</div>
<?php include($k['f_dir'].'include/footer.php'); ?>