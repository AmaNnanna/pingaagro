<?php 
include('dir.php');
$page_name="settings";
$meta_title="Change your password";
$meta_description="Change your account password ";
$meta_img="";
user_only();
$sidebar_exist=true; //remove if you do not want side bar but full blown width
include($k['f_dir'].'include/header.php');
?>

<div class='layout-main'> <!--only used where sidebar exists-->
<div class='layout-full'>
<h1 class='title-font title'>Change Password</h1>






<?php
//DATA COLLECTION
if(isset($_POST['change']) && isset($_POST['token_test']) ){
//check for spam first
if(sn_dt($_POST['token_test'])==hourly_token()){
	
//sanitize the data
$oldpassword=sn_dt($_POST['oldpassword']);
$password=sn_dt($_POST['password']);
$password2=sn_dt($_POST['password2']);
$error_message='';
if(!(validate_password($password))){$error_message.='<div>Your password must be longer than 4 characters!</div>';}
if($password2!=$password){$error_message.='<div>The new passwords in the two fields did not match!</div>';}
if(get_pwd_token($oldpassword)!=$m_info['password']){$error_message.='<div>Your current password must be entered correctly!</div>'; log_incorrect_try(); }

	

//sanitize done, now time to update...
if($error_message==''){
$pwd=get_pwd_token($password);
$sql="UPDATE `account` SET `password`='$pwd' WHERE `id`='".$m_info['id']."' ";
$result=query_sql($sql);
if(isset($_COOKIE[$k['id-token']])){$remember=true;}else{$remember=false;}
auth_login($m_info['email'],$password,true,$remember);
	

// alert me now of the success
$success_message="Your password has been changed successfully!";
display_s_m($success_message);

} else { // there were error messages
display_e_m($error_message);
}
}
}
?>













<div class='white-box up-down'>
<form action='#' method='post'>


<div class='form-table'>
<div class='form-field'>
Old Password
</div>
<div class='form-value'>
<input type='password' name='oldpassword' required='required' title='Enter your old Password' placeholder='Type old password' class='input width-full'>
<div class='small red'> Enter your current account's password</div>
</div>
</div>



<div class='form-table'>
<div class='form-field'>
New Password
</div>
<div class='form-value'>
<input type='password' name='password' required='required' title='Enter new Password' placeholder='Type new password' class='input width-full'>
<div class='small red'> Your new password must be greater than 4 characters</div>
</div>
</div>


<div class='form-table'>
<div class='form-field'>
New Password Again
</div>
<div class='form-value'>
<input type='password' name='password2' required='required' title='New Password Again' placeholder='Type new password again' class='input width-full'>
<div class='small red'> Your new password must be greater than 4 characters and match the first one already entered</div>
</div>
</div>


<input type='text' class='hidden' name='token_test' title='Please enter your last name' value='<?php print hourly_token();  ?>'/>

<div>
<input type='submit' value='Make this my new password' class='submit' name='change'>
</div>
</form>
</div>




</div>
</div>


<div class='layout-sub'>
<?php 
sidebar_settings('password');
?>
</div>
<?php include($k['f_dir'].'include/footer.php'); ?>