<?php 
include('dir.php');
$page_name="settings";
$meta_title="Edit Profile";
$meta_description="Change your profile details ";
$meta_img="";
user_only();
$sidebar_exist=true; //remove if you do not want side bar but full blown width
include($k['f_dir'].'include/header.php');
?>















<div class='layout-main'> <!--only used where sidebar exists-->
<div class='layout-full'>
<h1 class='title-font title'>Profile Update</h1>








<?php
//DATA COLLECTION
if(isset($_POST['change']) ){

//sanitize the data
$name=sn_dt($_POST['name']);


$error_message='';
if( strlen($name)<5 ){$error_message.='<div>Your name cannot be empty!</div>';}
	

//sanitize done, now time to update...
if($error_message==''){


$sql="UPDATE `account` SET `name`='$name'  WHERE `id`='".$m_info['id']."' ";
$result=query_sql($sql);
$m_info=get_user_info($m_info['id']);


// alert me now of the success
$success_message="Your profile was updated successfully!";
display_s_m($success_message);

} else { // there were error messages
display_e_m($error_message);
}
}
?>





<div class='white-box up-down'>
<div class='bold red'>Optional - Upload Your Photo</div>
<div class='smaller gray'> This might be shown publicly.</div>
<?php 
gallery_uploader($m_info['id'],'2','profile-photo-upload');
//gallery_viewer($m_info['id'],'1','temp-upload','','My Temporal Photos');
?>
</div>





<div class='white-box up-down'>
<form action='#' method='post'>



<div class='form-table'>
<div class='form-field'>
Full Name
</div>
<div class='form-value'>
<input type='text' name='name' required='required' title='Enter your full name' 
value='<?php print $m_info['name']; ?>' placeholder='Type your full name' class='input width-full'>
</div>
</div>







<div class='padding'>
<input type='submit' value='Save Update' class='submit' name='change'>
</div>
</form>
</div>






</div>
</div>


<div class='layout-sub'>
<?php 
sidebar_settings('profile');
?>
</div>
<?php include($k['f_dir'].'include/footer.php'); ?>