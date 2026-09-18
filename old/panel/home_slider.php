<?php 
include('dir.php');
$page_name="admin";
user_only();
$meta_title="Photos and Sliders";
$meta_description="Home sliders";
$meta_img="";
include($k['f_dir'].'include/header.php');

verified_user_only();
if(!has_super_permission($m_info['admin'])){ exit; }
?>
<div class='layout-600'>








<h1 class='title title-font'>Up to 10 photos to slide on the homepage</h1>
<div class='red small'><b>PRO TIP:</b> Use a combination of 2 dashes (--) to separate the actual title from a clickable link and you will see your slider contain a link that you can click. <div class='no-wrap green'>E.g  Christmas Bonanza Items -- <?php print $k['full_dir']; ?></div>
<div class='gray'> 
The first part shall become the title and the last part which is a link shall make the slider clickable. 
Recommended size for the photo is 1500px by 1125px
</div>
</div>

<?php 
gallery_uploader($k['admin_id'],'20','home-gallery-slider'); 
?>
<p></p>



<h1 class='title title-font'>Upload Logo</h1>
<div class='red small'>
Recommended size for logo (Consult developer on this)
</div>
<?php 
gallery_uploader($k['admin_id'],'21','home-logo'); 
?>
<p></p>








<h1 class='title title-font'>Favourite Icon</h1>
<div class='red small'>
Recommended size for Favicon is 180px by 180px (Transaprent PNG)
</div>
<?php 
gallery_uploader($k['admin_id'],'22','home-favicon'); 
?>
<p></p>





<h1 class='title title-font'>Website Icon</h1>
<div class='red small'>
Recommended size for Icon is 512px by 512px (Transaprent PNG)
</div>
<?php 
gallery_uploader($k['admin_id'],'23','home-icon'); 
?>
<p></p>





</div>

<?php 
include($k['f_dir'].'include/footer.php');
?>