<?php 
include($dir.'config.php');
require_once($k['dir'].'_lib/HTMLPurifier4.10.0/HTMLPurifier.auto.php'); //set of codes that format text inputs
include($k['f_dir'].'include/functions_basic.php'); //basic codes not specific to any table
include($k['f_dir'].'include/functions_user.php'); //codes specific mostly to a user
include($k['f_dir'].'include/functions_post.php'); //codes specific mostly to posts and ads
include($k['f_dir'].'include/functions_others.php'); //anything else can come here
//all other major functions follow soon... Remember hierarchy of what needs what before placing
?>