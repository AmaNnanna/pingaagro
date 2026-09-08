<?php 
include('dir.php');
$page_name="gallery";

$meta_title="Gallery";
$meta_description="Browse Gallery";
$meta_img="";
include($k['f_dir'].'include/header.php');




$start=get_page_count();
$range=20;
$page=$k['full_dir']."pages/gallery.php?start=";

?>












<div class='layout-full'>
<div class='center'>
<p>
<h1 class='title title-font vertical-middle'>Browse Gallery</h1>
</p>
<?php

$query="SELECT * FROM `gallery` WHERE `status`='1'  ORDER BY `epoch` DESC  ";
$sql=$query." LIMIT $start , $range ";
$result=query_sql($sql);


while($f=mysqli_fetch_assoc($result)){ 
print gallery_display($f);
}





print"<div class='clear'></div>";
print"<p>&nbsp;</p>";
//please never add limit to query
show_next_button($start,$range,$page,$query,'','');	
?>



<p>&nbsp;</p>

</div>
</div>









<?php include($k['f_dir'].'include/footer.php'); ?>