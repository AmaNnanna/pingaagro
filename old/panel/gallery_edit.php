<?php 
include('dir.php');
$page_name="gallery_edit";
user_only();

$object_name='gallery';
$obj_info=auth_object_page($object_name);

$meta_title="Edit Gallery";
$meta_description="Edit Gallery";
$meta_img="";

include($k['f_dir'].'include/header.php');

verified_user_only();
if( has_basic_permission($m_info['admin'])  ||  $obj_info['user_id']==$m_info['id'] ){} else 
{ display_e_m("You have no permission to perform this operation"); exit; }
?>
<div class='layout-600'>













<div>
<a href='<?php print $k['full_dir']; ?>panel/gallery_view.php' class='red small'>Back to Gallery</a> <h1 class='title title-font'>Edit File Title</h1>
</div>






<?php 
//DATA COLLECTION
if(isset($_POST['title']) ){

//sanitize the data
if(isset($_POST['status'])){ $status='1'; }else{ $status='0'; }
$title=sn_dt($_POST['title']);

if(isset($_POST['trash'])){  
	gallery_delete(" `id`='".$obj_info['id']."' ");
	display_s_m("File Deleted!"); exit;
		}


$error_message='';
if($title==''){ $error_message.='<div>The title cannot be empty.</div>'; }
//sanitize done, now time to insert...
if($error_message==''){
	
	

$sql="UPDATE `gallery` SET `title`='$title',`status`='$status' WHERE `id`='".$obj_info['id']."' ";
$result=query_sql($sql);
$obj_info=get_object_info($obj_info['id'],'gallery');
$update_success=true;

// alert me now of the success

$msg="File was updated successfully";
display_s_m($msg);



} else { // there were error messages
display_e_m($error_message);
}
}
?>




<?php gallery_display($obj_info); ?>







<form action='#' method='post'>

<div class='form-table'>
Title of File <br/>
<input type='text' placeholder='Title' class='input width-full' value='<?php print $obj_info['title']; ?>' name='title' required='required'/>
<div class='small red'>Required</div>
</div>


<div>
<label class='check'>
<input type="checkbox" class='checkbox' name='status' <?php print check_box_default($obj_info['status']); ?>> 
Include in Gallery system <span class='smaller gray'>Unmark to hide file from the central gallery available on website </span>
</label> 
</div>



<div class='padding'>
<input type='submit' value='Save' class='submit' name='update'> <input type='submit' value='Delete' name='trash'>
</div>
</form>





</div>
</div>




</div>
<?php include($k['f_dir'].'include/footer.php'); ?>