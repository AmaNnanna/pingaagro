<?php 
include('dir.php');
$page_name="recover";
$meta_title="Recover Password";
$meta_description="Recover your account password by using a password recovery link and choosing a new password.";
$meta_keywords="forgot password, recover password, troubleshoot login, login problem";
visitor_only();
include($k['f_dir'].'include/header.php');
?>



<div class='layout-600'>
<h1 class='title-font title'>Recover Lost Password</h1>






<?php
//CONFIRM THIS INVITATION
if(isset($_GET['token']) && isset($_GET['email'])){
//sanitize data
$email=sn_dt($_GET['email']);
$token=sn_dt($_GET['token']);
if((this_email_exists($email))){  
//authenticate token
$account_info=get_user_info($email);
$recovery_token=get_token($email.date('Y-m').$account_info['password']);
if($recovery_token==$token){
//authenticate other data
$token_safe=true;
} else {display_e_m("This Recovery link has expired. Please request a new one or try logging in if you already changed your password.");}
}
}
?>















<?php
//DATA COLLECTION
if(isset($_POST['change']) && isset($_POST['token_test']) && isset($token_safe)){
//check for spam first
if(sn_dt($_POST['token_test'])==hourly_token()){
	
//sanitize the data
$password=sn_dt($_POST['password']);
$password2=sn_dt($_POST['password2']);
$error_message='';
if(!(validate_password($password))){$error_message.='<div>Your password must be longer than 4 characters!</div>';}
if($password2!=$password){$error_message.='<div>The passwords in the two fields did not match!</div>';}
if(isset($_SESSION['change_password'])){if($_SESSION['change_password']==$email)
{$error_message.='<div>You just changed your password! Please try logging in with your account details or try again later</div>';}}

//sanitize done, now time to update...
if($error_message==''){
$pwd=get_pwd_token($password);
	
$sql="UPDATE `account` SET `password`='$pwd',`email_verify`='1' WHERE `id`='".$account_info['id']."' ";
$result=query_sql($sql);
auth_login($account_info['email'],$password,true,true);
	
	
$subject=$account_info['name'].", you just got your password changed";
$footer="You received this message because the account with the email ".$email." just got a change of password. 
You may reply with the shortcode HACKED".$account_info['id']." to block access to this account if you never changed the password.
Note that this action could take days to become effective, though we try our best to take care of security emails such as this on time.";

$message="
<div style='padding:10px;'>
<b>Hello ".$account_info['name']."!</b> we are glad to have you back. 
These 3 tips could be of help:

<ol>
<li>Use a secure password that is difficult to guess, but easy for you to remember</li>
<li>Never disclose your password to anyone</li>
<li>Change your password whenever you think your account is at risk</li>
</ol>

</div>";
//sending_email($email,$subject,$message,$footer);
email_queue($email,$subject,$message,$footer,'1');
$_SESSION['change_password']=$email;
$change_success=true;
// alert me now of the success
$success_message="<div class='padding'><h1 class='h1'>Your password change was successful! Welcome back!</h1></div>";
display_s_m($success_message.$message);

} else { // there were error messages
display_e_m($error_message);
}
}
}
?>








<?php if(!(isset($change_success)) && isset($token_safe)){ ?>

<form action='#' method='post'>

<div class='red up-down white-box small'>
Please choose a password that you can remember. It should be impossible for another person to guess correctly
</div>

<div class='form-table'>
New Password <br/> 
<input type='password' class='input width-full' value='<?php r_f_p('password'); ?>' name='password' required='required' title='Enter a Password'>
<div class='small red'> Your password must be greater than 4 characters</div>
</div>

<div class='form-table'>
New Password Again <br/> 
<input type='password' class='input width-full' value='<?php r_f_p('password2'); ?>' name='password2' required='required' title='Enter a Password Again'>
<div class='small red'> Your password must be greater than 4 characters</div>
</div>



<input type='text' class='hidden' name='token_test' title='Please enter your last name' value='<?php print hourly_token();  ?>'/>

<div class='form-table'>
<input type='submit' value='Make this my new password' class='submit' name='change'>
</div>
</form>





<?php } ?>



<?php 
display_w_m("If the link you clicked is valid, you should see a form to choose a new password from. 
			If you cannot find the form, please try and recover password again from the login link");
?>





</div>
<?php include($k['f_dir'].'include/footer.php'); ?>