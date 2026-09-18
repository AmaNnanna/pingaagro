<?php 
include('dir.php');
$page_name="settings";
$meta_title="Edit Preferences";
$meta_description="Change your Preferences ";
$meta_img="";
user_only();
$sidebar_exist=true; //remove if you do not want side bar but full blown width
include($k['f_dir'].'include/header.php');
?>


















<div class='layout-main'> <!--only used where sidebar exists-->
<div class='layout-full'>
<h1 class='title-font title'>Preferences</h1>










<?php
//DATA COLLECTION
if(isset($_POST['change']) ){

//sanitize the data
if(isset($_POST['email_notify'])){ $email_notify='1'; }else{ $email_notify='0'; }


$error_message='';
if(!(isset($email_notify))){$error_message.='<div>You have not set anything for the email!</div>';}

//sanitize done, now time to update...
if($error_message==''){
	


$sql="UPDATE `account` SET `email_notify`='$email_notify' WHERE `id`='".$m_info['id']."' ";
$result=query_sql($sql);
$m_info=get_user_info($m_info['id']);


// alert me now of the success
$success_message="Your preferences were updated successfully!";
display_s_m($success_message);

} else { // there were error messages
display_e_m($error_message);
}
}
?>













<div class='white-box up-down'>
<form action='#' method='post'>





<div class='form-table'>
<label>
<input type="checkbox" class='checkbox' name='email_notify' <?php print check_box_default($m_info['email_notify']); ?> > 
 Enable Email Notifications (Emails are sent only when extremely important)
</label> 
</div>





<div class='form-table'>
<input type='submit' value='Save Update' class='submit' name='change'>
</div>
</form>

</div>








</div>
</div>


<div class='layout-sub'>
<?php 
sidebar_settings('preference');
?>
</div>
<?php include($k['f_dir'].'include/footer.php'); ?>