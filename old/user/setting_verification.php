<?php 
include('dir.php');
$page_name="verification";
$meta_title="Verify Account";
$meta_description="Verify Your Account";
$meta_keywords="Email verification";
$sidebar_exist=true; //remove if you do not want side bar but full blown width
include($k['f_dir'].'include/header.php');
?>


<div class='layout-main'> <!--only used where sidebar exists-->
<div class='layout-600'>
<h1 class='title-font title'>Email Verification</h1>





<?php

//check if this person is verified already
if(is_logged()){ $account_info=$m_info;
if($account_info['email_verify']=='1'){

display_s_m("This account is already verified"); $success=true; 

}
}










//CONFIRM THIS INVITATION
if(isset($_GET['token']) && isset($_GET['acc']) && !isset($success)){
//sanitize data
$acc=sn_dt($_GET['acc']);
$token=sn_dt($_GET['token']);
if((this_user_exists($acc))){  

//get data or fetch userdata if logged in
$account_info=get_user_info($acc);
if(is_logged()){ $account_info=$m_info; }

//is account already verified
if($account_info['email_verify']!='1'){
//is token correct
if($account_info['email_code']===$token){
//authenticate other data


$sql="UPDATE `account` SET `email_verify`='1' WHERE `id`='".$account_info['id']."' ";
$result=query_sql($sql);
display_s_m("Congratulations! This Account Has Been Verified");
$success=true;

} else {display_e_m("The verification link you entered is not correct. Try again or contact support for manual verification.");}
} else {display_s_m("This account is already verified"); $success=true; }

}
}









?>















<?php if(!(isset($success)) && is_logged()){ ?>
<div class='white-box up-down'>
<form action='#' method='get'>


<div class='form-table'>
Type Verification Code Sent To Your Email 
<div class='small red'>Code is case sensitive</div>
<input type='text' class='input width-full' value='<?php r_f_g('token'); ?>' name='token' required='required' title='Enter Code' placeholder='Type Code here'>
</div>

<input type='hidden' value='<?php print $m_info['id']; ?>' name='acc'/>

<div>
<input type='submit' value='Verify' class='submit' name='change'>
</div>
</form>


<?php display_t_m("<span class='bold'>Did not receive email verification code?</span>
				  <div>
				  <ol>
				  <li>
				  Your email code may take up to 10 minutes to arrive (depending on your email service provider), please do not repeat action by creating new account.
				  </li>
				  <li>
				  Please check if your mailbox works or if it goes to trash/spam folder or your mail inbox is full.
				  </li>
				  <li>
				  Check with your email operator to see if verification code email has been blocked
				  </li>
				  <li>
				  Contact us if all these options have failed
				  </li>
				  </ol>
				  </div>"); ?>
<?php //print social_button($word="Verify Account With "); ?>


</div>

<?php } ?>






</div>
</div>



<div class='layout-sub'>
<?php 
sidebar_settings('verification');
?>
</div>

<?php include($k['f_dir'].'include/footer.php'); ?>