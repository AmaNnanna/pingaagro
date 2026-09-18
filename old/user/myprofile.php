<?php 
include('dir.php');
$page_name="profile";
$id=get_get('id');
//user_only();
if($id=='' && is_logged()){ $user=$m_info; }
else{ $user=auth_user_page(); }

$img=get_user_img($user['id']);

//owner only or admin
//if($user['id']==$m_info['id'] || has_basic_permission($m_info['admin']) ){ } else { exit; }



$meta_title=$user['name'];
$meta_description="Posts added by ".$user['name']." on ".$k['site_name'];
$meta_img=$img['profile'];
include($k['f_dir'].'include/header.php');
?>
<div class='layout-800'>



<h1 class='title title-font'><?php print $user['name']; ?>'s Posts</h1> 
<?php if($img['status']){ ?>
<div><img src='<?php print $meta_img; ?>' style='max-width:200px;'/></div>
<?php } ?>


<?php 

$start=get_page_count();
$range=100;
$page=$k['full_dir']."user/myprofile.php?id=".$user['id']."&start=";

//must be published, but can show unpublished when page is being viewed by the person who posted
$query="SELECT * FROM `page` WHERE `user_id`='".$user['id']."' && `status`='1'  ORDER BY `lastepoch` DESC ";
$sql=$query." LIMIT $start , $range ";
$result=query_sql($sql);
if(mysqli_num_rows($result)=='0'){ display_e_m("No post added by this person yet"); }

while($f=mysqli_fetch_assoc($result)){ 

flat_post($f); 

}





print"<div class='clear'></div>";
print"<p>&nbsp;</p>";
//please never add limit to query
show_next_button($start,$range,$page,$query,'','');	
?>


















</div>
<?php include($k['f_dir'].'include/footer.php'); ?>