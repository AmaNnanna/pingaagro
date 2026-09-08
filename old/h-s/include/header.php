<!DOCTYPE html>
<html>
<head>
<?php 
//every script, meta, css and js needed
include($k['f_dir'].'include/header_scripts.php'); ?>
</head>
<body>




<div class='header-box'>






<span class='header-menu-btn'><i class="fa fa-bars"></i></span>


<div class='header-top-links'><!--header-top links-->
<div class='header-menu-area'><!--menu area-->


<div class='header-link'>
<a href='<?php print $k['full_dir']; ?>'> <i class="fa fa-home"></i> HOME </a>
</div>


<div class='header-link'>
<a href='<?php print $k['full_dir']; ?>about'>ABOUT</a>
</div>

<div class='header-link'>
<a href='<?php print $k['full_dir']; ?>category/products'>PRODUCTS & SERVICES</a>
</div>

<div class='header-link'>
<a href='<?php print $k['full_dir']; ?>blog'>BLOG</a>
</div>

<?php //print fetch_top_menu(); ?>

<!--div class='header-link'>
<a href='<?php print $k['full_dir']; ?>gallery'>Gallery</a>
</div-->

<div class='header-link'>
<a href='<?php print $k['full_dir']; ?>shop'>SHOP</a>
</div>

<div class='header-link'>
<a href='<?php print $k['full_dir']; ?>contact'>CONTACT</a>
</div>


<?php if($settings['fb']!=''){ ?>
<div class='header-link'>
<a href='<?php print resn_json($settings['fb']); ?>' target='_blank'> <i class="fa fa-facebook"></i> </a>
</div>
<?php } ?>

<?php if($settings['tw']!=''){ ?>
<div class='header-link'>
<a href='<?php print resn_json($settings['tw']); ?>' target='_blank'> <i class="fa fa-twitter"></i> </a>
</div>
<?php } ?>

<?php if($settings['ig']!=''){ ?>
<div class='header-link'>
<a href='<?php print resn_json($settings['ig']); ?>' target='_blank'> <i class="fa fa-instagram"></i> </a>
</div>
<?php } ?>

<?php if($settings['lnk']!=''){ ?>
<div class='header-link'>
<a href='<?php print resn_json($settings['lnk']); ?>' target='_blank'> <i class="fa fa-linkedin"></i> </a>
</div>
<?php } ?>



<div class='header-close-menu-btn close-btn'>Close</div>
</div><!--menu area-->

</div><!--header-top links ends-->





<div class='logo-box'>
<a href='<?php print $k['full_dir']; ?>'>
<img src='<?php print $temp_logo['photo']; ?>' alt='<?php print $k['site_name']; ?> Logo - <?php print $k['site_slogan']; ?>' />
</a>
</div>









<div class='header-search'>
<i class="fa fa-search"></i>
</div>

<div class='header-fly-right header-search-area'>
<form method='get' action='<?php print $k['full_dir']; ?>pages/' class='padding'>
<input type='text' value='<?php 
if(isset($_GET['q'])){ $_SESSION['q']=sn_dt($_GET['q']); }
else if(!(isset($_SESSION['q']))){ $_SESSION['q']=''; }
print $_SESSION['q'];
?>' name='q' placeholder='Search Pages' class='input width-200'/>
<input type='submit' value='Search' class='submit'/>

</form>
<div class='header-close-search-btn close-btn'>Close</div>
</div>









</div>





<div class='layout-holder'>
<!--start of layout holder above-->











<?php 
flash_head($settings);
?>






<?php
if(isset($_SESSION[$k['id-token']])){ 
if(has_basic_permission($m_info['admin'])){ ?>
<div class='admin-box'>
Hi Admin! 
<a href='<?php print $k['full_dir']; ?>panel' class='yellow'>Click Here To Check Admin Dashboard</a>
</div>
<?php }}  ?>
<!--Admin Announcement-->







