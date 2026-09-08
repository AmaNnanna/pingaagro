<?php
include('dir.php');
$page_name="articles";
user_only();
$meta_title="Create Article";
$meta_description="Create Article";
$meta_img="";

include($k['f_dir'].'include/header.php');

if(!has_basic_permission($m_info['admin'])){ exit; }
?>
<div class='layout-800'>












<?php


//Time to process post...
if( isset($_POST['create']) && isset($_POST['token_test']) ){
//check for spam first
if(sn_dt($_POST['token_test'])==hourly_token()){

//sanitize the data
$title=sn_dt($_POST['title']);
$category=sn_dt($_POST['category']);
$error_message='';
if(strlen($title)=='0'){ $error_message.='<div>Your Title is empty!</div>'; }
if(!(this_object_exists($category,'category'))){ $error_message.='<div>Category is invalid! Required!</div>'; }

$sql="SELECT `id` FROM `page` WHERE `title`='$title' && `category`='$category' "; 
$result=query_sql($sql);
if(mysqli_num_rows($result)>0){ $error_message.='<div>There has been a post with this exact title and category!</div>'; }


//sanitize done, now time to insert...
if($error_message==''){
	

$epoch=$k['epoch'];
$sql="INSERT INTO `page`
(`title`,`user_id`,`epoch`,`category`,`lastepoch`)
VALUES
('$title','".$m_info['id']."','$epoch','$category','$epoch')";
$result=query_sql($sql);
$page_id=last_id();

$create_success=true;
// alert me now of the success
go_to($k['full_dir']."panel/page_edit.php?id=".$page_id."&new=true");


} else { // there were error messages
display_e_m($error_message); 
}
}
}


?>







<h1 class='title'> Create New Page</h1>


<?php display_w_m("Please create only pages that are necessary"); ?>





<form action='#' method='post'>
<div class='form-table'>
<input type='text' placeholder='Title E.g: We are starting a promotion soon' class='input width-full' name='title' value='<?php r_f_p('title'); ?>'/>
</div>



<div class='form-table'>
<div>Select Category</div>
<select name='category'>
<?php cat_drop(); ?>
</select>
</div>


<div>
<input type='submit' value='Continue' class='submit' name='create'>
</div>
<input type="text" class="hidden" name="token_test" title="Please enter your last name" value="<?php print hourly_token(); ?>"/>
</form>






</div>
<?php include($k['f_dir'].'include/footer.php'); ?>