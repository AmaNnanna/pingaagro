<?php 
include('dir.php');
$page_name="members";
user_only();
$meta_title="Member List";
$meta_description="View all members";
$meta_img="";
include($k['f_dir'].'include/header.php');
verified_user_only();
if(!has_basic_permission($m_info['admin'])){ exit; }


//Specific Object that shall be printed
$search_info="";

//CRITERIA FOR SEARCH

//From a specific ID
$id=get_get('id');
$q_id="";
if($id!='' && this_object_exists($id,'account') ){	
$q_id=" && `id`='$id' "; }

//From a specific email
$email=get_get('email');
$q_email="";
if($email!='' ){	
$q_email=" && `email`='$email' ";  }

//From a specific name keyword
$q=get_get('q');
$q_q="";
if($q!=''){	
$q_q=" && `name` LIKE '%".(str_replace(' ','%%',$q))."%' "; }

//From status
$status=get_get('status');
$q_status="";
if($status!=''){	
$q_status=" && `status`='$status' "; }

//From email_verify
$email_verify=get_get('email_verify');
$q_email_verify="";
if($email_verify!=''){	
$q_email_verify=" && `email_verify`='$email_verify' "; }

//From admin
$admin=get_get('admin');
$q_admin="";
if($admin!=''){	
$q_admin=" && `admin`='$admin' "; }




?>
<div class='layout-600'>
















<h1 class='title'> Member List</h1>






<form action='#' method='get'>




<input type='number' value='<?php print $id; ?>' name='id' placeholder='User ID' title='User ID'/>

<input type='text' value='<?php print $email; ?>' name='email' placeholder='Email' title='Email'/>

<input type='text' value='<?php print $q; ?>' name='q' placeholder='Name' title='Name'/>


<select name='status'>
<option value=''>--Account Status--</option>
<option value='0'<?php select_button_default($status,'0'); ?>>Blocked</option>
<option value='1'<?php select_button_default($status,'1'); ?>>Active</option>
</select>


<select name='email_verify'>
<option value=''>--Verified Email--</option>
<option value='1'<?php select_button_default($email_verify,'1'); ?>>Verified</option>
<option value='0'<?php select_button_default($email_verify,'0'); ?>>Unverified</option>
</select>


<select name='admin'>
<option value=''>--Admin Status--</option>
<option value='0'<?php select_button_default($admin,'0'); ?>>Not Admin</option>
<option value='1'<?php select_button_default($admin,'1'); ?>>Basic Admin (Posts)</option>
<option value='2'<?php select_button_default($admin,'2'); ?>>Super Admin(Everything)</option>
</select>



<div class='divider'></div>

<input type='submit' value='Go' class='submit' name='go'>
</form>



<?php display_w_m("You can find all users here. Use the available options to sort. Click on any of them to manage"); ?>

















<?php

$start=get_page_count();
$range=20;
$page=$k['full_dir']."panel/user_view.php?id=".$id."&email=".$email."&q=".$q."&status=".$status."&email_verify=".$email_verify."&admin=".$admin."&start=";


$csv_main_query=$main_query="FROM `account` WHERE `id`!='' && `admin`!='0'  
".$q_id.$q_email.$q_q.$q_status.$q_email_verify.$q_admin." 
ORDER BY `id` DESC ";

$query="SELECT 1 ".$main_query;

//show result count
$result=query_sql($query);
$counter=mysqli_num_rows($result);
print"<div class='space larger bold red'>".$counter." Results for this search parameters</div>";

$query="SELECT * ".$main_query;
$sql=$query." LIMIT $start , $range ";
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result)){ 

admin_user($f,true,true);


}





print"<div class='clear'></div>";
print"<p>&nbsp;</p>";
//please never add limit to query
show_next_button($start,$range,$page,$query,'','');	
?>



<p>&nbsp;</p>









</div>
<?php include($k['f_dir'].'include/footer.php'); ?>