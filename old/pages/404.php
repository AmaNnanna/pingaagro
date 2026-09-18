<?php 
include('dir.php');
$page_name="404";
$meta_title="Page Not Found";
$meta_description="You probably ended up here because the page you were looking for does not exist";
$meta_img="";
$meta_keywords="error";
include($k['f_dir'].'include/header.php'); 
 ?>
<div class='layout-600'>





<h2 class='title title-font'> 404 Error: Page Not Found</h2>


<div>
<p>
You probably ended up here because the page you were looking for does not exist, or has been deleted. You can start browsing from our homepage
</p>

<h1 class='title'><?php print $k['site_name']; ?></h1>
<p>
<?php print $k['site_desc']; ?>.
</p> 

<a href='<?php print $k['full_dir']; ?>'>Find your way back to the homepage</a>

</div>





</div>
<?php include($k['f_dir'].'include/footer.php'); ?>