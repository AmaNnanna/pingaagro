<?php 
include('dir.php');
$page_name="blog";

$meta_title="Blog";
$meta_description="Checkout our blog";
$meta_img="";
include($k['f_dir'].'include/header.php');

?>
<div class='layout-full'>
<div class='center'>









<div class='bloghome1'>
<p>
<h1 class='title title-font vertical-middle'>POSTS</h1>
</p>
<?php
$query="SELECT * FROM `page` WHERE `status`='1' && `category`='2' ORDER BY `lastepoch` DESC ";
$sql=$query." LIMIT 0 , 10 ";
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result)){ 
flat_post($f);
}

print"<div class='clear'></div>
<a href='".$k['full_dir']."category/blog' class='submit'>MORE POSTS &rarr; </a>
";
?>





</div>
<div class='bloghome2'>
<?php
$start=get_page_count();
$range=8;
$page=$k['full_dir']."pages/gallery.php?start=";
?>
<p>
<h1 class='title title-font vertical-middle'>GALLERY</h1>
</p>
<?php

$query="SELECT * FROM `gallery` WHERE `status`='1'  ORDER BY `epoch` DESC  ";
$sql=$query." LIMIT $start , $range ";
$result=query_sql($sql);


while($f=mysqli_fetch_assoc($result)){ 
print gallery_display($f);
}


print"<div class='clear'></div>
<a href='".$k['full_dir']."gallery' class='submit'>MORE PHOTOS &rarr; </a>
";
print"<p>&nbsp;</p>";
?>


<p>&nbsp;</p>
</div>







</div>
</div>
<?php include($k['f_dir'].'include/footer.php'); ?>