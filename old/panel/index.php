<?php 
include('dir.php');
$page_name="admin";
$meta_title="Administrative Panel";
$meta_description="View the administrative dashboard, from where you can manage everything";
$meta_img="";
user_only();
if(!has_basic_permission($m_info['admin'])){ exit; }
include($k['f_dir'].'include/header.php');
$settings=get_settings();
?>
<div class='layout-600'>




<div>
<h1 class='title green'>Administrative Panel</h1>
</div>















<div class='layout-admin-dash'>

<div class='title'> 
Publishing
</div>
<div class='divider'></div>
<a href='<?php print $k['full_dir']; ?>panel/page_create.php' class='tab'>
New Page
</a>
<a href='<?php print $k['full_dir']; ?>panel/page_view.php' class='tab'>
View Pages
</a>

<a href='<?php print $k['full_dir']; ?>panel/cat_view.php' class='tab'>
View/Edit Categories
</a>


</div>


















<?php if(has_super_permission($m_info['admin'])){ ?>


<div class='layout-admin-dash'>

<div class='title'> 
Super User Options
</div>
<div class='divider'></div>

<a href='<?php print $k['full_dir']; ?>panel/settings.php' class='tab'>
General Settings
</a>

<a href='<?php print $k['full_dir']; ?>panel/home_slider.php' class='tab'>
Website Photos
</a>

<div class='divider'></div>
<a href='<?php print $k['full_dir']; ?>panel/user_view.php' class='tab'>
Manage Admins
</a>

<a href='<?php print $k['full_dir']; ?>panel/gallery_view.php' class='tab'>
Browse Uploads
</a>

</div>




<?php } ?>
















<div class='layout-admin-dash'>

<div class='title'> 
My Account
</div>
<div class='divider'></div>

<a href='<?php print $k['full_dir']; ?>user/profile' class='tab'>
Settings and Password
</a>

<a href='<?php print $k['full_dir']; ?>user/logout' class='tab'>
Logout
</a>

</div>






<div class='border'>
<form action='<?php print $k['full_dir']."panel/page_view.php"; ?>' method='get' class='space'>
<input type='text' name='id' class='input' placeholder='Page ID' />
<input type='submit' name='submit' value='Go To Page' class='submit' />
</form>
</div>


<div class='border'>
<form action='<?php print $k['full_dir']."panel/user_view.php"; ?>' method='get' class='space'>
<input type='text' name='id' class='input' placeholder='Admin ID' />
<input type='submit' name='submit' value='Go To Admin' class='submit' />
</form>
</div>


<div class='border'>
<form action='<?php print $k['full_dir']."panel/gallery_view.php"; ?>' method='get' class='space'>
<input type='text' name='id' class='input' placeholder='Gallery ID' />
<input type='submit' name='submit' value='Go To Gallery' class='submit' />
</form>
</div>













</div>
<?php include($k['f_dir'].'include/footer.php'); ?>