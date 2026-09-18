<?php 
include('dir.php');
$page_name="index_home_main";
$meta_title=$k['site_name'];
$meta_description=strip_tags(resn_json($settings['home_text']));
$meta_img="";
$meta_keywords="home";
include($k['f_dir'].'include/header.php');
$settings=get_settings(); 
?>

<div class='layout-full' style='padding:0px;'>















<?php if($settings['home_slide']=='1'){ ?>
<!--1347px by 500px-->
<!-- Start WOWSlider.com BODY section -->
	<div id="wowslider-container1">
	<div class="ws_images"><ul> 
<?php    
$no=0;
$sql="SELECT * FROM `gallery` WHERE `type`='20' && `file_type`='1' ORDER BY `id` DESC LIMIT 10 ";
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result)){ $img=gallery_url($f['file']); 
$file_data=explode('--',$f['title']);
if(count($file_data)==2){  $file_title=$file_data[0]; $file_url=trim($file_data[1]); }
else{ $file_title=$f['title']; $file_url=$k['full_dir']; }
if($settings['home_slide_text']=='0'){ $file_title=""; }
?>
	
    <li><img src="<?php print $img; ?>" alt="<?php print $file_title; ?>" title="<?php print $file_title; ?>" id="wows1_<?php print $no; ?>"/><?php //print $info['desc']; ?> 
    <?php if($file_url!==''){ print'<a href="'.$file_url.'" target="_blank">Learn More</a>'; } ?></li>
    
<?php	$no=$no+1; } ?>
    
	</ul></div>
	</div>
	<script type="text/javascript" src="<?php print $k['cdn']; ?>slide_wow2/engine1/wowslider.js"></script>
	<script type="text/javascript" src="<?php print $k['cdn']; ?>slide_wow2/engine1/script.js"></script>
	<!-- End WOWSlider.com BODY section -->
<?php } ?>














<!--home main-->
<div style='background:url(<?php print $img; ?>) center center;'>
<div class='home-main'>

<div class='title-font intro-title'>
<?php print resn_json($settings['intro']); ?>
</div>

<div class='intro-text'>
<?php print resn_json($settings['home_text']); ?>
</div>

<?php if($settings['yt_home']!=''){ //show youtube video
$youtube_code=getYouTubeIdFromURL(resn_json($settings['yt_home']));
print'<div class="center"><iframe width="100%" height="320" src="//www.youtube.com/embed/'.$youtube_code.'" frameborder="0" allowfullscreen="" style="max-width:900px;margin:0px auto 0px auto;"></iframe></div>';
} ?>

<div class='center'><a href='<?php print $k['full_dir']; ?>about' class='submit'> MORE ABOUT OUR COMPANY &rarr; </a></div>





<!--div class='center'>
<?php
$query="SELECT * FROM `gallery` WHERE `status`='1'  ORDER BY `epoch` DESC  ";
$sql=$query." LIMIT 0 , 6 ";
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result)){ 
print gallery_display($f);
}
?>
</div-->




</div>
</div>
<!--end of home main-->












<div class='center'>
<div><h2 class='title'>PRODUCTS & SERVICES</h2></div>
<?php

$query="SELECT * FROM `page` WHERE  `status`='1' && `category`='10' ORDER BY `lastepoch` DESC ";
$sql=$query." LIMIT 0 , 8 ";
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result)){ 


//show featured posts here
grid_post($f);

}
?>
</div>







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










<!--Map-->
<div class='center'>
<div><h2 class='title'>Locate our office address</h2></div>
<div class='padding'><?php print resn_json($settings['address']); ?></div>
<iframe src="<?php print resn_json($settings['map']); ?>" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
<!--//Map-->


























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
<?php include($k['f_dir'].'include/footer.php'); ?>