<?php 
include('dir.php');
$page_name="article";
$object_name='page';
$ann=get_object_info(1,'page');
if($ann['status']!='1'){ print"Page not published!"; exit; }

$meta_title=$ann['title'];
$meta_description="Checkout details of  ".$ann['title'];
$img=get_post_img($ann['id']);
$meta_img='';
if($img['status']==true){ $meta_img=$img['photo']; }

include($k['f_dir'].'include/header.php');

?>



<div class='layout-800'>
<p><h1 class='title title-font'><?php print $ann['title']; ?></h1></p>
<?php 
if($img['status']==true){ print"<div><img src='".$img['photo']."'/></div>"; }
print $ann['content'];
?>
</div>







<div class='layout-full'>


<?php 
$mis=get_object_info(8,'page');
$vis=get_object_info(10,'page');
$shv=get_object_info(11,'page');
?>
<div class='home-middle'>
<div class='home-middle1'><div class='hmt'><?php print $mis['title']; ?></div><div class='hmc'><?php print $mis['content']; ?></div></div>
<div class='home-middle2'><div class='hmt'><?php print $vis['title']; ?></div><div class='hmc'><?php print $vis['content']; ?></div></div>
<div class='home-middle3'><div class='hmt'><?php print $shv['title']; ?></div><div class='hmc'><?php print $shv['content']; ?></div></div>
</div>




<!--div class='center'>
<div><h2 class='title'>DIRECTORS</h2></div>
<?php
$query="SELECT * FROM `page` WHERE  `status`='1' && `category`='12' ORDER BY `lastepoch` DESC ";
$sql=$query." LIMIT 0 , 8 ";
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result)){ 
//show featured posts here
grid_team($f);
}
?>
</div-->



<!--div class='center'>
<div><h2 class='title'>MANAGEMENT TEAM</h2></div>
<?php
$query="SELECT * FROM `page` WHERE  `status`='1' && `category`='11' ORDER BY `lastepoch` DESC ";
$sql=$query." LIMIT 0 , 8 ";
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result)){ 
//show featured posts here
grid_team($f);
}
?>
</div-->


<?php
if($ann['show_gallery']=='1'){
gallery_viewer($ann['id'],'4','article'.$ann['id']);
}
?>

</div>


<div class='layout-800'>
<?php 

print backbreak($ann['embed_code']);
print"<p class='red bold'>SHARE PAGE</p>";
share_buttons();
?>
</div>
<?php include($k['f_dir'].'include/footer.php'); ?>