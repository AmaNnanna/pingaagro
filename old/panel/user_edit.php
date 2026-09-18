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












<h1 class='title'>Edit User Data - <?php print $user['name']; ?></h1>







<?php 




//DATA COLLECTION
if(isset($_POST['update']) ){

//sanitize the data
$email=sn_dt($_POST['email']);
$name=sn_dt($_POST['name']);
if(isset($_POST['email_verify'])){ $email_verify='1'; }else{ $email_verify='0'; }
if(isset($_POST['status'])){ $status='1'; }else{ $status='0'; }
$admin=sn_dt($_POST['admin']);
$pin=sn_dt($_POST['pin']);


$error_message='';
if(!(validate_email($email))){ $error_message.='<div>Email is invalid.</div>'; }
if($user['id']==$m_info['id'] && (  $admin<$m_info['admin'] || $status=='0' || $email_verify=='0' ))
{ $error_message.='<div>You can not pull down this admin.</div>'; }
if($admin>2 || $admin<0){ $error_message.='<div>The admin level is out of range.</div>'; }
if($pin!=$m_info['email_code']){ $error_message.='<div>PIN failed</div>'; log_incorrect_try(); }

$sql="SELECT `id` FROM `account` WHERE (`email`='$email') && `id`!='".$user['id']."' "; 
$result=query_sql($sql);
if(mysqli_num_rows($result)>0){ $error_message.='<div>Someone has this email already</div>'; }






//sanitize done, now time to insert...
if($error_message==''){
	


$sql="UPDATE `account` SET `email`='$email',`status`='$status',`email_verify`='$email_verify',
`admin`='$admin',`name`='$name' WHERE `id`='".$user['id']."' ";
$result=query_sql($sql);
$user=get_object_info($user['id'],'account');

$update_success=true;

// alert me now of the success

$msg="Account was updated successfully";
display_s_m($msg);



} else { // there were error messages
display_e_m($error_message);
}
}
?>




<?php admin_user($user,true,true); ?>
<div class='right'><a href='<?php print $k['full_dir']; ?>panel/user_edit_pin.php?id=<?php print $user['id']; ?>' class='red'>RESET PIN FOR ADMIN</a></div>







<form action='#' method='post'>

<div>
Name <span class='smaller gray'>Full name</span> <br/>
<input type='text' placeholder='Name' class='input width-full' value='<?php print $user['name']; ?>' 
name='name' required='required'/>
</div>



<div>
Email <span class='smaller gray'>Email must be unique</span> <br/>
<input type='email' placeholder='Whatever could make you want to change this' class='input width-full' value='<?php print $user['email']; ?>' 
name='email' required='required'/>
</div>


<div>
<label class='check'>
<input type="checkbox" class='checkbox' name='email_verify' <?php print check_box_default($user['email_verify']); ?>> 
Mark Email As Verified <span class='smaller gray'>Just to prove that this person owns the email</span>
</label> 
</div>




<div>
<label class='check'>
<input type="checkbox" class='checkbox' name='status' <?php print check_box_default($user['status']); ?>> 
Active <span class='smaller gray'>Uncheck to block user from using site</span>
</label> 
</div>





<div>
<div><b>Admin Status</b></div>


<div>
<label class='check'>
<input type="radio" class='radiobox' name='admin' value='0' <?php print radio_button_default('0',$user['admin']); ?> >  
Not Admin
</label> 
</div>


<div>
<label class='check'>
<input type="radio" class='radiobox' name='admin' value='1' <?php print radio_button_default('1',$user['admin']); ?> > 
Basic Admin
</label> 
</div>


<div>
<label class='check'>
<input type="radio" class='radiobox' name='admin' value='2' <?php print radio_button_default('2',$user['admin']); ?> > 
Super Admin
</label> 
</div>



</div>












<div>
PIN <span class='smaller gray'>You must know this to make this kind of change</span> <br/>
<input type='password' placeholder='PIN' class='input width-full' value='' name='pin' required='required'/>
</div>





<div class='padding'>
<input type='submit' value='Save' class='submit' name='update'>
</div>
</form>








</div>
</div>



</div>

<?php include($k['f_dir'].'include/footer.php'); ?>