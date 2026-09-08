<?php

function get_page_count(){
	//selects page number in case there is a set range
	if(isset($_GET['start'])){ $start=$_GET['start']; 
	if(ctype_digit($start) && $start>=0){ } else {$start='0';}
	} else {$start='0';}
	return $start;	}




//please never add limit to query
function show_next_button($start,$range,$page,$sql,$separator='/',$append='',$target=''){
//gives detail of next or previous page
	if($target!=''){ $target=" target='".$target."' "; }

	if($start=='0'){ $prev_btn=" "; }else{
	$prev_btn="<a href='".$page.$separator.($start-$range).$append."' class='button' ".$target.">&laquo;Previous</a> &nbsp; "; }
	$start=$start+$range;
	$sql=$sql." LIMIT $start , $range ";
	$result=query_sql($sql); if(mysqli_num_rows($result)>0){
	$next_btn="<a href='".$page.$separator.($start).$append."' class='button' ".$target.">Next&raquo;</a>";
	} else {$next_btn=" "; }
	//display buttons
	print"<p>";
	if(isset($prev_btn)){print $prev_btn;}
	if(isset($next_btn)){print $next_btn;}
	print"<br class='clear'/></p>";
}







//builds up every possible search query, saves session and returns associative array
function get_search_query(){
	if(isset($_GET['q'])){
	$q=sn_dt($_GET['q']); 
	} else {$q='';}
	$_SESSION['q']=$q;
	//build query
	$q_query='%'.str_replace(' ','%_%',$q).'%';
	$q_user=str_replace('@','',$q);
	$url_q=urlencode($q);
	$array=array('q'=>$q,'q_query'=>$q_query,'user'=>$q_user,'url'=>$url_q);
	return $array; }
	





function get_get($id='id'){
	//selects any get value
	if(isset($_GET[$id])){ $id=sn_dt($_GET[$id]); 
	} else {$id='';}
	return $id;	}





function notif_unread($user_id){
	$query="SELECT `id` FROM `notification` WHERE `seen`='0' && `user_id` = '".$user_id."' ";
	$sql=$query." LIMIT 0 , 100 ";
	$result=query_sql($sql);
	$count=mysqli_num_rows($result);
	return $count; }



//use for refreshing frames after changes are made...
function js_refresh($frame='canvas',$seconds='10') {
	print"<script type='text/javascript'>
	function refresh_a_page(){
 	parent.window.frames['".$frame."'].location.reload();
	}
	setTimeout('refresh_a_page()',".($seconds*1000).");
 	</script> 
	";
	}





//Functions should temporarily reside here until they are verified and put in place









//SIDEBARS


//for highlighting of sidebars
function check_this_bar($title,$sent,$print=true){
	if($title==$sent){ $out=" tab-active"; }else { $out=""; }
	if($print){ print $out; }
	return $out;
	}


//sidebar for settings group
function sidebar_settings($title){
	global $k; ?>

<a href='<?php print $k['full_dir']; ?>user/myprofile.php' class='tab<?php check_this_bar($title,'viewprofile') ?>'>
My Posts
</a>
<a href='<?php print $k['full_dir']; ?>user/profile' class='tab<?php check_this_bar($title,'profile') ?>'>
Profile Update
</a>
<a href='<?php print $k['full_dir']; ?>user/preference' class='tab<?php check_this_bar($title,'preference') ?>'>
Preferences
</a>
<a href='<?php print $k['full_dir']; ?>user/verification' class='tab<?php check_this_bar($title,'verification') ?>'>
Verification
</a>
<a href='<?php print $k['full_dir']; ?>user/password' class='tab<?php check_this_bar($title,'password') ?>'>
Change Password
</a>

<?php	}




































//function that returns whatever is gonna pop... with optional types of pop-up
function pop_up($name,$content,$type=4,$info=''){
	//As per type... 0 for page, 1 for fullpage, 2 for menu, 3 for confirmation, 4 for inventory
	if($type=='0'){$t='page-pop';}
	else if($type=='1'){$t='fullpage-pop';}
	else if($type=='2'){$t='menu-pop';}
	else if($type=='3'){$t='confirm-pop';}
	else if($type=='4'){$t='inventory-pop';}
	//more might be added later
	
	//optional info to help newbies
	if($info==''){ $help=''; }else {
	
	//An array will be made to bear most of the tips so there will not be need to repeat some help tips
	$help="<div class='help-button' id='help-".$name."-button' title='Click Here For Help' onClick=\"pop_action('help-".$name."')\">i</div>
	<div class='confirm-pop' id='help-".$name."-area'>
	<div class='close-button' id='help-".$name."-close-button' title='Close this Dialogue' onClick=\"pop_close('help-".$name."')\">x</div>
	<div class='height-safety'>
	".$info."
	<p class='clear'>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
	</div>
	</div> ";
		
	}
	
	$data=" <div class='".$t."' id='".$name."-area'>
	<div class='close-button' id='".$name."-close-button' title='Close this Dialogue' onClick=\"pop_close('".$name."')\" >x</div>
	".$help."
	<div class='height-safety'>
	".$content."
	<p class='clear'>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
	</div>
	</div> ";
	return $data; }


















//mini data for adminitration
function admin_user($f,$admin_link=false,$print=true){
	global $k;
	if($f['status']=='0'){ $status_info=" &middot; <span class='red'>Blocked</span>"; }
	else{ $status_info=" &middot; <span class='green'>Active</span>"; }
	
	if($f['email_verify']=='1'){ $email_info=" &middot; <span class='green'>Email Verified</span>"; }
	else{ $email_info=" &middot; <span class='red'>Email Not Verified</span>"; }
	
	if($f['admin']=='0'){ $admin_info=" <span class='gray'>Not Admin</span>"; }
	else if($f['admin']=='1'){ $admin_info=" <span class='orange'>Basic Admin</span>"; }
	else { $admin_info=" <span class='blue'>Super Admin</span>"; }
	
	if($admin_link){ //append some stuff for admin to view
	$admin_append="<div class='right smaller'>
	<a href='".$k['full_dir']."panel/user_edit.php?id=".$f['id']."'>Edit</a> &middot; 
	<a href='".$k['full_dir']."panel/page_view.php?user_id=".$f['id']."'>Posts</a> &middot; 
	<a href='".$k['full_dir']."panel/gallery_view.php?user_id=".$f['id']."'>Gallery</a> 
	</div>";
	} else { $admin_append=""; }
	
	
	
	$info="
	<div class='gray border bg-white'>
	<div class='space'>
	<a href='".$k['full_dir']."profile/".$f['id']."' class='bold gray'>
	".$f['id'].". ".$f['name']." 
	</a>
	<div class='right smaller'>
	Email:".$f['email']." ".$email_info." ".$status_info." &middot;  
	Admin: ".$admin_info." &middot; Registered:".timecalc($f['regepoch'])." &middot;
	Lastseen: ".timecalc($f['lastepoch'])." 
	</div>
	".$admin_append."
	</div>
	</div>
	<div class='divider'></div>
	";
	if($print){print $info; }
	else {return $info; }
	}










function admin_page($f){
	global $k; 
	
	if($f['status']=='0'){ $status_info=" <span class='gray'>Draft</span>"; }
	else if($f['status']=='1'){ 
	$status_info=" <span class='green'>Published</span>  &middot; 
	<a href='".$k['full_dir']."page/".$f['id']."' class='gray'>Preview </a> "; 
	}else{ $status_info=" <span class='orange'>Trashed</span>"; }
	
	print"<div class='border'>
	<div class='space'>
	<a href='".$k['full_dir']."panel/page_edit.php?id=".$f['id']."'>".$f['title']."</a> 
	<div class='smaller'>".$status_info."</div>
	</div>
	</div>";
	}
	







//mini data for adminitration
function admin_cat($f,$admin_link=false,$print=true){
	global $k;
	
	if($f['status']=='0'){ $status_info=" &middot; <span class='orange'>Trashed</span>"; }
	else if($f['status']=='1'){ 
	$status_info=" &middot; <span class='green'>Published</span>  &middot; 
	<a href='".$k['full_dir']."category/".$f['slug']."' class='gray'>
	Live link 
	</a> "; }
	
	

	if($admin_link){ //append some stuff for admin to view
	$admin_append=" &middot; <a href='".$k['full_dir']."panel/cat_edit.php?id=".$f['id']."'>Edit Category</a> ";
	} else { $admin_append=""; }
	$info="
	<div class='gray'>
	<div class='space'>
	<div class='bold dark'>".$f['name']."</div>
	".$f['desc']."
	<div class='right smaller'>
	<a href='".$k['full_dir']."panel/page_view.php?category=".$f['id']."' class='gray'>
	Pages under ".$f['name']." 
	</a>
	".$status_info.$admin_append."</div>
	</div>
	</div>
	<div class='divider'></div>
	";
	if($print){print "<div style='border:5px solid #000;'>".$info; print"</div>"; }
	else {return $info; }
	}













function contactform($form_name='',$form_email='',$inquiry=''){
	global $k;
//contact form
if($form_name==''){ $form_name="Contact Form"; }
if($form_email==''){ $form_email=$k['site_email']; }
if($inquiry==''){ $inquiry="Comment, Message or Enquiry"; }
?>
<a name='form'></a>
<div class='white-box'>
<h1 class='title title-font'> <?php print $form_name; ?> </h1>


<form action='#form' method='post'>
<?php 
//Time to process post...
if( isset($_POST['create']) ){
//check for spam first
if(sn_dt($_POST['token_test'])==hourly_token()){

//sanitize the data
$name=sn_dt($_POST['name']);
$email=sn_dt($_POST['email']);
$phone=sn_dt($_POST['phone']);
$message=sn_dt($_POST['message']);


$error_message='';
if(strlen($name)<3){ $error_message.='<div>Your name cannot be less than 3 characters</div>'; }
if(!(validate_email($email)) && strlen($phone)<10){ $error_message.='<div>Either phone or email must be valid so that we can get back to you</div>'; }
if(strlen($message)<3){ $error_message.='<div>Please add more details to your inquiry</div>'; }
if(isset($_SESSION['form'.md5($form_name)]) && $_SESSION['form'.md5($form_name)]==$name.$email.$phone.$message){ 
$error_message.='<div>This message has already been sent! Please be patient. We will get back to you!</div>';  }
//sanitize done, now time to insert...
if($error_message==''){

$success=true;
$_SESSION['form'.md5($form_name)]=$name.$email.$phone.$message;
$message="Hi Admin! A customer with name ".$name.", phone/email ".$phone." ".$email." made the following enquiry on ".date('r').". <br/> ".$message;
$subject=$form_name." Enquiry from ".$name." ";
email_queue($form_email,$subject,$message,'','0');
display_s_m("Message Sent Successfully! We will be in touch with you soon! Thank you"); 

} else { // there were error messages
display_e_m($error_message); 
}
}
}


if(!(isset($success))){
display_t_m("Please make an enquiry by filling the form below and we shall get back to you. 
			Alternatively, you can just send an email to ".$form_email." and we shall also get back to you");
?>
<div class='form-table'>
Full Name <span class='small gray'>E.g First Name, Middle Name Surname</span> <br/>
<input type='text' placeholder='Full name' class='input width-full' value='<?php r_f_p('name'); ?>' name='name' required='required'/>
</div>


<div class='form-table'>
Phone <span class='small gray'>E.g +2347031234567 or 07031234567</span> <br/>
<input type='tel' placeholder='Phone' class='input width-full' value='<?php r_f_p('phone'); ?>' name='phone'/>
<div class='small red'>Please make sure this phone exists, in case we need to contact you with it</div>
</div>


<div class='form-table'>
Email <span class='small gray'>E.g: name@gmail.com</span> <br/>
<input type='email' placeholder='Email' class='input width-full' value='<?php r_f_p('email'); ?>' name='email'/>
<div class='small red'>Please make sure this email exists, in case we need to contact you with it</div>
</div>


<div class='form-table'>
<?php print $inquiry; ?> <br/>
<textarea placeholder='Inquiry' class='textarea width-full' name='message' required='required'><?php r_f_p('message'); ?></textarea>
<div class='small red'>Please make sure that you have described your issue or enquiry very well</div>
</div>


<input type='text' class='hidden' name='token_test' title='Please enter your last name' value='<?php print hourly_token();  ?>'/>


<div class='right'>
<input type='submit' value='Submit' class='submit' name='create'  title='Click to submit inquiry'>
</div>
</form>
<?php } ?>
</div>
<!--//Create-->

<?php } 



?>