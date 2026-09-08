<?php 
include('dir.php');
$page_name="login";
$meta_title="Login to your account";
$meta_description="To login you have to type in your username or email address here.";
$meta_keywords="login, sign in, get started";
visitor_only();
include($k['f_dir'].'include/header.php');




remember_redirect_link();


?>
<div class='layout-600'>
<h1 class='title-font title'><?php print $k['site_name']; ?> Login</h1>








<?php
if(isset($_SESSION['log_incorrect_try_limit'])){
display_e_m("You have attempted to use incorrect credentials a lot of times. Please close this browser and re-open to be able to continue. 
			You may try Forgot Password option too");	exit;
}










//DATA COLLECTION
if(isset($_POST['login']) && isset($_POST['token_test'])){
//check for spam first
if(sn_dt($_POST['token_test'])==hourly_token()){
	
//sanitize the data
$username=sn_dt($_POST['username']);
$password=sn_dt($_POST['password']);
if(isset($_POST['remember'])){$remember=true;}else{$remember=false;}
$error_message='';

if(!(this_email_exists($username))){ $error_message.='<div>Sorry, this account does not exist!</div>'; }

//sanitize done, now time to login or show incorrect login...
if($error_message==''){

if(!(auth_login($username,$password,true,$remember))){ display_e_m('<div>Sorry, login is incorrect!</div>'); log_incorrect_try(); }
		 else{  redirect_after_login();	}

} else { // there were error messages
display_e_m($error_message);
}
}
}
?>








<?php if(!(isset($login_success))){ ?>


<form action='<?php print $k['full_dir']."user/login"; ?>' method='post'>

<div class='red up-down white-box small'>
You can only login if you already own an account. If you do not have an account, register instead
</div>

<div class='form-table'>
Email <br/> 
<input type='email' class='input width-full' value='<?php r_f_p('username'); ?>' name='username' required='required' title='Enter Email' placeholder='Enter Email'>
</div>



<script>
function mypwdvisibile() {
    var x = document.getElementById("pwd");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>
<div class='form-table'>
<i class='fa fa-eye cursor' title='Touch to make password visible' onclick='mypwdvisibile()'></i> Password <br/> 
<input type='password' class='input width-full' value='' id='pwd' 
name='password' required='required' title='Enter a Password' placeholder='Enter a Password'>
</div>

<div class='form-table'>
<label>
<input type='checkbox' value='1' name='remember' title='Do you want to be remembered? Check this' <?php if(isset($_POST['remember'])){print"checked";} ?>> 
Remember me 
</label>
<div class='small red'> Do not check this if you're using a shared device </div>
</div>

<input type='text' class='hidden' name='token_test' title='Please enter your last name' value='<?php print hourly_token();  ?>'/>




<div class='form-table'>
<input type='submit' value='Login' class='submit' name='login'>
</div>


<div>
<a href='<?php print $k['full_dir']."user/recover-password"; ?>'>Forgot password? Recover it here</a>
</div>

<div>
<a href='<?php print $k['full_dir']."join"; ?>'>Don't have an account yet? Click Here To Register</a>
</div>



<?php print social_button($word="Login With "); ?>

</form> 
<?php } ?>





</div>
<?php include($k['f_dir'].'include/footer.php'); ?>