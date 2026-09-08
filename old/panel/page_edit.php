<?php 
include('dir.php');
$page_name="page-edit-admin";
user_only();

$object_name='page';
$ann=auth_object_page($object_name);

$meta_title="Edit Article ".$ann['title'];
$meta_description="Edit Article ".$ann['title'];
$meta_img="";

include($k['f_dir'].'include/header.php');


if(!has_basic_permission($m_info['admin'])){ exit; }


?>
<div class='layout-800'>















<h1 class='title'><?php print $ann['title']; ?></h1>









<?php 



//DATA COLLECTION
if(isset($_POST['title']) ){

$content=remove_slash($_POST['content']);
$title=sn_dt($_POST['title']);
if(isset($_POST['publish'])){ $status='1'; } else if(isset($_POST['update'])) { $status='0'; } else { $status='2'; }
$embed=sn_dt($_POST['embed_code']);
$category=sn_dt($_POST['category']);

if(isset($_POST['show_related'])){ $show_related='1'; } else { $show_related='0'; }
if(isset($_POST['show_gallery'])){ $show_gallery='1'; } else { $show_gallery='0'; }
if(isset($_POST['show_comment'])){ $show_comment='1'; } else { $show_comment='0'; }
if(isset($_POST['show_home'])){ $show_home='1'; } else { $show_home='0'; }
if(isset($_POST['show_time'])){ $show_time='1'; } else { $show_time='0'; }

//sanitize the data
$error_message='';


if(strlen($title)=='0'){ $error_message.='<div>Title is empty! Required!</div>'; }
if(strlen($content)=='0'){ $error_message.='<div>Content is empty! Required!</div>'; }
if(!(this_object_exists($category,'category'))){ $error_message.='<div>Category is invalid! Required!</div>'; }



//sanitize done, now time to insert...
if($error_message==''){


if(isset($_POST['time']) || $status=='2'){ $t_update=",`lastepoch`='".$k['epoch']."'"; }else{ $t_update=''; }
//Update others that might throw up errors when not set
$update_success=true;
$sql="UPDATE `page` SET `category`='$category',`show_related`='$show_related',`show_gallery`='$show_gallery',
`show_comment`='$show_comment',`show_home`='$show_home',`show_time`='$show_time',
`status`='$status',`title`='$title',`content`='$content',`embed_code`='$embed' 
".$t_update." WHERE `id`='".$ann['id']."' ";
$result=query_sql($sql);
$ann=get_object_info($ann['id'],'page');



display_s_m("Page updated successfully");



} else { // there were error messages
display_e_m($error_message);
}
}



if($ann['status']=='1'){
print"<div class='space right'><a href='".$k['full_dir']."page-".$ann['id']."' class='bold'>View Page</a></div>";
}
?>









<div class='bold'>(Optional) Page Cover Photo</div>
<?php gallery_uploader($ann['id'],'3','ann-'.$ann['id']); ?>
<p>&nbsp;</p>

<div class='bold'>(Optional) Photos to be used within Page</div>
<?php gallery_uploader($ann['id'],'4','annth-'.$ann['id']); ?>
<p>&nbsp;</p>


<form action='#' method='post'>
<?php 
if(isset($_GET['new'])){ 
display_w_m("Remember to publish once you are done writing"); 
}
?>





<p>&nbsp;</p>



<div class='padding'>
<div>Post Title</div>
<input type='text' placeholder='Title of Post' class='input width-full' name='title' value='<?php print $ann['title']; ?>'/>
</div>




<?php print richtexteditor(); ?>
<div>
<textarea placeholder='Article Content - Use photos uploaded in uploader' class='ckeditor' name='content'><?php print $ann['content']; ?></textarea>
</div>





<div class='padding'>
<div>Embed Code such as Youtube video code etc.</div>
<textarea placeholder='Any Embed Code such as YouTube' class='textarea width-full' name='embed_code'><?php print backbreak($ann['embed_code']); ?></textarea>
</div>


<div class='padding'>
<div>Select Category</div>
<select name='category'>
<?php cat_drop($ann['category'],false); ?>
</select>
</div>









<div>
<label class='check'>
<input type="checkbox" class='checkbox' name='show_related' <?php print check_box_default($ann['show_related']); ?>> 
Show Related Posts <span class='smaller gray'>Check button to show related posts after this post is shown </span>
</label> 
</div>


<div>
<label class='check'>
<input type="checkbox" class='checkbox' name='show_gallery' <?php print check_box_default($ann['show_gallery']); ?>> 
Compile Gallery <span class='smaller gray'>Check to use uploaded photos form gallery below this post</span>
</label> 
</div>

<div>
<label class='check'>
<input type="checkbox" class='checkbox' name='show_comment' <?php print check_box_default($ann['show_comment']); ?>> 
Enable Comments <span class='smaller gray'>Check button to show comments below post, if enabled for this installation</span>
</label> 
</div>

<div>
<label class='check'>
<input type="checkbox" class='checkbox' name='show_home' <?php print check_box_default($ann['show_home']); ?>>  
Show on homepage <span class='smaller gray'>Check button to show post on homepage (Only for important posts)</span>
</label> 
</div>

<div>
<label class='check'>
<input type="checkbox" class='checkbox' name='show_time' <?php print check_box_default($ann['show_time']); ?>>  
Display Time <span class='smaller gray'>Check button to show time when post was last updated</span>
</label> 
</div>




<div>
<label class='check'>
<input type="checkbox" class='checkbox' name='time'>  
Update Publish Time to now <span class='smaller gray'>This makes the time reflect now and may 
influence being shown first wherever sorting is done chronologically</span>
</label> 
</div>



<?php 
if($ann['status']=='0'){ display_w_m("This post is still saved as draft. Click Publish to go live when ready"); }
else if($ann['status']=='1'){ display_s_m("This post is currently published!"); }
else { display_e_m("This post is in trash. Click Publish to recover it!"); }
?>


<div class='padding'>
<input type='submit' value='Publish' class='submit' name='publish'/>
<input type='submit' value='Save As Draft' name='update'/>
<input type='submit' value='Discard' name='trash'/>
</div>

</form>








</div>
<?php include($k['f_dir'].'include/footer.php'); ?>