<?php 
include('dir.php');
$page_name="panel";
$meta_title="Administrative Panel";
$meta_description="View the administrative dashboard, from where you can manage quizzes and groups";
$meta_img="";
user_only();
include($k['f_dir'].'include/header.php');
verified_user_only();
?>





<div class='block-full'>
<h1 class='block-title'>Testing our popups</h1>
<div class='space'>



<?php 
$pop_name="alert0";
$pop_content="We are here to show you a message that might be of interest to you";
$pop_info="";
print pop_up($pop_name,$pop_content,0,$pop_info);
?>
<span id='<?php print $pop_name; ?>-button' onClick="pop_action('<?php print $pop_name; ?>')" class='button cursor'>Type 0</span>





<?php 
$pop_name="alert1";
$pop_content="We are here to show you a message that might be of interest to you";
$pop_info="";
print pop_up($pop_name,$pop_content,1,$pop_info);
?>
<span id='<?php print $pop_name; ?>-button' onClick="pop_action('<?php print $pop_name; ?>')" class='button cursor'>Type 1</span>





<?php 
$pop_name="alert2";
$pop_content="We are here to show you a message that might be of interest to you";
$pop_info="";
print pop_up($pop_name,$pop_content,2,$pop_info);
?>
<span id='<?php print $pop_name; ?>-button' onClick="pop_action('<?php print $pop_name; ?>')" class='button cursor'>Type 2</span>







</div>
</div>

<?php include($k['f_dir'].'include/footer.php'); ?>