<?php 
include('dir.php');
$page_name="gallery";
user_only();
$meta_title="Gallery List";
$meta_description="View all attachments";
$meta_img="";
include($k['f_dir'].'include/header.php');
verified_user_only();
if(!has_super_permission($m_info['admin'])){ exit; }


//Specific Object that shall be printed
$search_info="";

//CRITERIA FOR SEARCH

//From a specific ID
$id=get_get('id');
$q_id="";
if($id!='' && this_object_exists($id,'gallery') ){	
$q_id=" && `id`='$id' "; }

//From a specific title keyword
$q=get_get('q');
$q_q="";
if($q!=''){	
$q_q=" && `title` LIKE '%".(str_replace(' ','%%',$q))."%' "; }

//From a specific user
$user_id=get_get('user_id');
$q_user_id="";
if($user_id!='' && this_object_exists($user_id,'account') ){	
$q_user_id=" && `user_id`='$user_id' "; $search_info=$search_info."<div>".admin_user(get_object_info($user_id,'account'),true,false)."</div>"; }

//From a specific extension
$extension=get_get('extension');
$q_extension="";
if($extension!=''){	
$q_extension=" && `file_type`='$extension' "; }


?>
<div class='layout-600'>















<h1 class='title'> Gallery List</h1>



<?php print $search_info; ?>
<form action='#' method='get'>




<input type='number' value='<?php print $id; ?>' name='id' placeholder='Gallery ID' title='Gallery ID'/>

<input type='text' value='<?php print $q; ?>' name='q' placeholder='Title' title='Title'/>


<select name='extension'>
<option value=''>--File Type--</option>
<option value='0'<?php select_button_default($extension,'0'); ?>>Document</option>
<option value='1'<?php select_button_default($extension,'1'); ?>>Photo</option>
<option value='2'<?php select_button_default($extension,'2'); ?>>Video</option>
<option value='2'<?php select_button_default($extension,'3'); ?>>Audio</option>
</select>


<input type='number' value='<?php print $user_id; ?>' name='user_id' placeholder='User ID' title='User ID'/>


<div class='divider'></div>

<input type='submit' value='Go' class='submit' name='go'>
</form>



<?php display_w_m("You can find all attachment here. Use the available options to sort. Click on any of them to manage"); ?>

















<?php

$start=get_page_count();
$range=20;
$page=$k['full_dir']."panel/gallery_view.php?id=".$id."&user_id=".$user_id."&q=".$q."&extension=".$extension."&start=";



$query="SELECT * FROM `gallery` WHERE `id`!='' 
".$q_id.$q_user_id.$q_q.$q_extension." 
ORDER BY `epoch` DESC ";
$sql=$query." LIMIT $start , $range ";
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result)){ 




$access="<div class='smaller gray'><a href='".$k['full_dir']."panel/gallery_edit.php?id=".$f['id']."' 
class='red'><i class='fa fa-edit'></i> Edit file</a> ".$f['title']."</div>";
print "<p>&nbsp;</p>".$access;
print gallery_display($f);




}





print"<div class='clear'></div>";
print"<p>&nbsp;</p>";
//please never add limit to query
show_next_button($start,$range,$page,$query,'','');	
?>



<p>&nbsp;</p>








</div>
<?php include($k['f_dir'].'include/footer.php'); ?>