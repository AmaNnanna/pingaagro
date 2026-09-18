<?php 
include('dir.php');
$page_name="category";
user_only();

$object_name='category';
$obj_info=auth_object_page($object_name);

$meta_title="Edit Category";
$meta_description="Edit Category";
$meta_img="";

include($k['f_dir'].'include/header.php');

verified_user_only();
if(!has_super_permission($m_info['admin'])){ exit; }
?>
<div class='layout-600'>














<h1 class='title title-font'>Edit Category</h1>







<?php 
//DATA COLLECTION
if(isset($_POST['update']) ){

//sanitize the data
if(isset($_POST['status'])){ $status='1'; }else{ $status='0'; }
if(isset($_POST['featured'])){ $featured='1'; }else{ $featured='0'; }
$search=sn_dt($_POST['search']);
$title=sn_dt($_POST['title']);
$slug=sn_dt($_POST['slug']);
$desc=remove_slash($_POST['desc']);
$order=sn_dt($_POST['order']);


$error_message='';
if($search=='' || $title=='' || $slug==''){ $error_message.='<div>The keyword, slug and title cannot be empty.</div>'; }

$sql="SELECT `id` FROM `category` WHERE `slug`='$slug' && `id`!='".$obj_info['id']."' "; 
$result=query_sql($sql);
if(mysqli_num_rows($result)>0){ $error_message.='<div>A slug exactly like this already exists !</div>'; }


//sanitize done, now time to insert...
if($error_message==''){
	
	

$sql="UPDATE `category` SET `name`='$title',`search`='$search',`status`='$status',`slug`='$slug',`desc`='$desc',
`featured`='$featured',`order`='$order' WHERE `id`='".$obj_info['id']."' ";
$result=query_sql($sql);
$obj_info=get_object_info($obj_info['id'],'category');

$update_success=true;

// alert me now of the success

$msg="Category was updated successfully";
display_s_m($msg);



} else { // there were error messages
display_e_m($error_message);
}
}
?>




<?php admin_cat($obj_info); ?>







<form action='#' method='post'>

<div class='form-table'>
Title of Category <span class='small gray'>Use and instead of / or - to separate multiple categories</span> <br/>
<input type='text' placeholder='Type name of Category here' class='input width-full' value='<?php print $obj_info['name']; ?>' name='title'/>
<div class='small red'>Make sure title is also captured in keyword</div>
</div>


<div class='form-table'>
Slug <span class='small gray'>Custom Friendly Text for URL</span> <br/>
<input type='text' placeholder='Slug' class='input width-full' value='<?php print $obj_info['slug']; ?>' name='slug'/>
<div class='small red'>No strange character allowed</div>
</div>

<div class='form-table'>
Tags/Keywords  related to this category only
<span class='smaller gray'>Use comma to separate multiple keywords. No line break or dash</span> <br/>
<textarea placeholder='Keywords' class='textarea width-full' name='search'><?php print backbreak($obj_info['search']); ?></textarea>
</div>


<div class='form-table'>
Description 
<span class='smaller gray'>(Optional) but will give more details about 
what can be found here E.g News about football, basketball, sports in general etc.</span> <br/>
<textarea placeholder='Description' class='ckeditor' name='desc'><?php print $obj_info['desc']; ?></textarea>
</div>


<div>
<label class='check'>
<input type="checkbox" class='checkbox' name='status' <?php print check_box_default($obj_info['status']); ?>> 
Enable <span class='smaller gray'>Mark to make category available on site</span>
</label> 
</div>


<div>
<label class='check'>
<input type="checkbox" class='checkbox' name='featured' <?php print check_box_default($obj_info['featured']); ?>> 
Featured <span class='smaller gray'>Mark to make it display on the homepage</span>
</label> 
</div>




<div class='form-table'>
Order <span class='small gray'>Number between 0 and 100. Category with higher order will be shown first</span> <br/>
<input type='number' placeholder='Order' class='input width-full' value='<?php print $obj_info['order']; ?>' name='order' min='0' max='100' step='1'/>
<div class='small red'>Just plain old numbers</div>
</div>


<div class='padding'>
<input type='submit' value='Save' class='submit' name='update'>
</div>
</form>





</div>
</div>




</div>
<?php include($k['f_dir'].'include/footer.php'); ?>