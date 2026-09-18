<?php 
include('dir.php');
$page_name="join";
$meta_title="Registration";
$meta_description="Register by filling this form and you can start using the system right away";
$meta_keywords="join, register, sign up, request invite";
visitor_only();
include($k['f_dir'].'include/header.php');

if($settings['user']=='0'){ go_to(); }
?>

<div class='layout-600'>
<h1 class='title-font title'><?php print $k['site_name']; ?> Registration</h1>













<?php 
//DATA COLLECTION
if(isset($_POST['join']) && isset($_POST['token_test']) ){
//check for spam first
if(sn_dt($_POST['token_test'])==hourly_token()){
	
//sanitize the data
$name=sn_dt($_POST['name']);
$email=sn_dt($_POST['email']);
$password=sn_dt($_POST['password']);
$password2=sn_dt($_POST['password2']);



$error_message='';
if($password!==$password2){ $error_message.='<div>Passwords do not match. Please enter the same password in the two fields for password</div>'; }
//if(!(isset($_POST['terms']))){ $error_message.='<div>You must accept our terms to register.</div>'; }
if(!(validate_email($email))){ $error_message.='<div>The email address is invalid.</div>'; }
if(this_email_exists($email)){ $error_message.='<div>This email is already registered. Please try logging in or try another email.</div>'; }
if(!(validate_password($password))){$error_message.='<div>Your password must be longer than 4 characters!</div>';}
if(strlen($name)<5){ $error_message.='<div>Your Name is invalid.</div>'; }

//sanitize done, now time to insert...
if($error_message==''){
	
	
	
	
$epoch=$k['epoch'];
$pwd=get_pwd_token($password);
$email_code=new_phone_code();
//actually email verification code
$search=$name;


$sql="INSERT INTO `account`
(`name`,`email`,`password`,`lastepoch`,`regepoch`,`loginepoch`,`email_code`,`last_email_epoch`)
VALUES
('$name','$email','$pwd','$epoch','$epoch','$epoch','$email_code','$epoch')";

$result=query_sql($sql);
$user_id=last_id();
auth_login($email,$password,true,true);


	
//Send verification code plus welcome email
$link=$k['full_dir']."user/setting_verification.php?token=".$email_code."&acc=".$user_id;
$message="Hello ".$name.",<br/> We are glad that you have joined ".$k['site_name'].". 
We would love you to verify your email with the Code: <b>".$email_code."</b> if you have not done that already. 
Email Verification ensures you own the email you are using. Click this link to automatically get verified <a href='".$link."'>".$link."</a>  ";
$subject=$name.", Welcome To ".$k['site_name'];
$footer="You received this email because someone registered on ".$k['site_name']." with the email address ".$email;
email_queue($email,$subject,$message,$footer,'1');
$register_success=true;

// alert me now of the success

$msg="
<span class='bold'>Congratulations ".$name."!</span>
<div>
Your registration was successful! A verification code has been sent to your email address ".$email.". 
<a href='".$k['full_dir']."user/verification'>Please click here to enter the code if you received it.</a>  
You can continue to update your profile or verify your email
<p>&nbsp;</p>
<a href='".$k['full_dir']."?new' class='button'>Home</a>  
<a href='".$k['full_dir']."user/profile' class='button'>Complete Profile</a>   
<a href='".$k['full_dir']."user/verification' class='button'>Verify Email</a> 
</div>";
display_s_m($msg);




} else { // there were error messages
display_e_m($error_message);
}
}
}
?>








<?php if(!(isset($register_success)) ){ ?>

<form action='#' method='post'>



<script type="text/javascript" language="javascript">
          function dothemaths3()
            {
                var p1 = document.getElementById("password").value;
				var p2 = document.getElementById("password2").value;
				if(p1!=p2 || p2==''){ //others so there is need to specify, so show the last field
				
				document.getElementById("password2").style.background = "#FCC";
				
				} else{  //hide the extra field, no need to show
				
				document.getElementById("password2").style.background = "#3F9";				
				
				}
            }
</script>




<div class='red up-down white-box small'>
Please complete our simple registration. <a href='<?php print $k['full_dir']."login"; ?>'>You can login if you already have an account. </a>
</div>






<div class='form-table'>
Full Name <span class='smaller gray'>Use your full name</span> <br/>
<input type='text' placeholder='Full Name' class='input width-full' value='<?php r_f_g('name'); ?>' name='name' required='required'/>
</div>



<div class='form-table'>
Email <span id='live-email'></span>
<div class='smaller gray'> Please make sure the email address is correct</div>
<input type='email' class='input width-full' value='<?php r_f_g('email'); ?>' name='email' required='required' 
title='Enter a Valid Email' onkeyup="showEmailavail(this.value)" placeholder='Enter a Valid Email'>
</div>






<div class='form-table'>
Password <span class='smaller gray'>Your password must be greater than 4 characters</span> <br/> 
<input type='password' class='input width-full' value='<?php r_f_p('password'); ?>' name='password' required='required' title='Enter a Password' id='password'>
</div>


<div class='form-table'>
Password Again <span class='smaller gray'>Your password must match with the first</span> <br/> 
<input type='password' class='input width-full' value='<?php r_f_p('password2'); ?>' name='password2' required='required' title='Enter a Password' id='password2' 
onblur="dothemaths3()" onKeyDown="dothemaths3()" onKeyUp="dothemaths3()" onClick="dothemaths3()" onmouseover="dothemaths3()" onchange="dothemaths3()">
</div>




<input type='text' class='hidden' name='token_test' title='Please enter your last name' value='<?php print hourly_token();  ?>'/>

<div class='form-table'>
<input type='submit' value='Submit' class='submit' name='join'>
</div>
</form>




<div>
<a href='<?php print $k['full_dir']."login"; ?>'>Already have an account? Click Here To Login</a>
</div>




<?php //print social_button($word="Register With "); ?>




<?php } ?>





</div>
<?php include($k['f_dir'].'include/footer.php'); ?>