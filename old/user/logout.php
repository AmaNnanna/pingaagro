<?php
include('dir.php');
$page_name="logout";
$title="Welcome to ";
include($k['f_dir'].'include/header.php'); 

if(isset($_SESSION[$k['id-token']])){
// please use this opportunity to update stats such as comment, spread, messages for user
//update_user_stats($_SESSION[$k['id-token']]);

}








if(isset($_SERVER['HTTP_REFERER'])){ $_SESSION['logout']=$_SERVER['HTTP_REFERER']; }
else{ $_SESSION['logout']=$k['full_dir']; }

logout();

header('location:'.$_SESSION['logout']);





include($k['f_dir'].'include/footer.php'); ?>