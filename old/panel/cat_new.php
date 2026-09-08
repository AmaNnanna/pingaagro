<?php 
include('dir.php');
$page_name="admin";
$meta_title="Create a Category - ".$k['site_name'];
$meta_description="Create a new Category";
$meta_img="";
$meta_keywords="category";
user_only();
include($k['f_dir'].'include/header.php');


if(!has_super_permission($m_info['admin'])){ exit; }
?>
<div class='layout-600'>











<?php

//Time to process post...
if( isset($_POST['create']) ){

//sanitize the data
$name=sn_dt($_POST['title']);
$error_message='';
if(strlen($name)<1){ $error_message.='<div>The title cannot be empty</div>'; }

$new_slug=generate_friendly_url($name);
$sql="SELECT `id` FROM `category` WHERE (`name`='".$name."' || `slug`='".$new_slug."') "; 
$result=query_sql($sql);
if(mysqli_num_rows($result)>0){ $error_message.='<div>There is already a duplicate of this category</div>'; }


//sanitize done, now time to insert...
if($error_message==''){
	
	

$sql="INSERT INTO `category`
(`name`,`slug`,`status`,`user_id`)
VALUES
('$name','".$new_slug."','0','".$m_info['id']."')";
$result=query_sql($sql);
$c_id=last_id();

$create_success=true;
// alert me now of the success
go_to($k['full_dir']."panel/cat_edit.php?id=".$c_id."&new=true");


} else { // there were error messages
display_e_m($error_message); $view_mode='';
}
}



?>


<!--Create-->

<div class='white-box'>
<h1 class='title title-font'> Create A New Category</h1>


<form action='#' method='post'>
<?php 
display_t_m("Please be sure there is need for this category, and that category similar to this does not already exist");
?>


<div class='form-table'>
Title of Category <span class='small gray'>E.g: Sports</span> <br/>
<input type='text' placeholder='Type name' class='input width-full' value='<?php r_f_p('title'); ?>' name='title'/>
<div class='small red'>You will be able to add more options in the next section</div>
</div>



<div class='right'>
<input type='submit' value='Continue' class='submit' name='create'  title='More options are available in the next section'>
</div>


</form>



</div>
<!--//Create-->








</div>
<?php include($k['f_dir'].'include/footer.php'); ?>