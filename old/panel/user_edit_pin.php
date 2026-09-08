<?php 
include('dir.php');
$page_name="member";
user_only();

$object_name='account';
$user=auth_object_page($object_name);

$meta_title="Edit User ".$user['name'];
$meta_description="Edit User ".$user['name'];
$meta_img="";

include($k['f_dir'].'include/header.php');

verified_user_only();
if(!has_super_permission($m_info['admin'])){ exit; }
?>
<div class='layout-600'>












<h1 class='title'>PIN RESET - <?php print $user['name']; ?></h1>







<?php 




//DATA COLLECTION
if(isset($_POST['update']) ){

//sanitize the data
$pin=sn_dt($_POST['pin']);
$pass=sn_dt($_POST['password']);
$pwd=get_pwd_token($pass);

$error_message='';
if($pin!=$m_info['email_code']){ $error_message.='<div>PIN failed</div>'; log_incorrect_try(); }
if($pwd!=$m_info['password']){ $error_message.='<div>PASSWORD failed</div>'; log_incorrect_try(); }


//sanitize done, now time to insert...
if($error_message==''){
	

$email_code=new_phone_code();
$sql="UPDATE `account` SET `email_code`='$email_code' WHERE `id`='".$user['id']."' ";
$result=query_sql($sql);
$user=get_object_info($user['id'],'account');

$update_success=true;

// alert me now of the success

$msg="Account PIN was reset successfully. Please Copy New PIN <b>".$email_code."</b> ";
display_s_m($msg);



} else { // there were error messages
display_e_m($error_message);
}
}
?>




<?php admin_user($user,true,true); ?>




<form action='#' method='post'>

<div>You can reset the PIN that an admin can use to make changes to other users on the admin panel.</div>


<div>
PIN <span class='smaller gray'>Your own PIN</span> <br/>
<input type='password' placeholder='PIN' class='input width-full' value='' name='pin' required='required'/>
</div>


<div>
PASSWORD <span class='smaller gray'>Your own Password</span> <br/>
<input type='password' placeholder='PASSWORD' class='input width-full' value='' name='password' required='required'/>
</div>




<div class='padding'>
<input type='submit' value='RESET PIN' class='submit' name='update'>
</div>
</form>








</div>
</div>



</div>

<?php include($k['f_dir'].'include/footer.php'); ?>