<?php 
session_start();  ob_start("ob_gzhandler"); set_time_limit(0);
date_default_timezone_set('Africa/Lagos'); //putenv("Africa/Lagos");


function dbpass()
	{$user='pingaagr_zvksdvhdb'; $pass='$9nnHE#OnJY'; $database='pingaagr_zvksdvhdb'; $server='127.0.0.1';
	$con=@mysqli_connect($server,$user,$pass,$database);
	return $con; }



$k['connection']=dbpass();
if(!($k['connection'])) {
	//Try one more time
	$k['connection']=dbpass();
		if(!($k['connection'])){
  		//print "Failed to connect to DB: " . mysqli_connect_error(); //this is the right error code, but we need to be smart
		print"<html>
		<head>
		<title>
		Sorry About This!
		</title>
		<meta http-equiv='refresh' content='30'/>
		</head>
		<body style='background:#000;color:#fff;text-align:center;font-family:calibri;'>
		<h1>A SOLAR ECLIPSE IS ON <br/>WE WILL REFRESH THIS PAGE SOON TO FIND OUT IF IT IS OVER!</h1>
		Sincere apologies for this. We are working on forcasting the next eclipse so we can notify you on time
		</body>
		</html>";
		exit;
		}
  }






//Maintenance/Sandbox Mode
$k['sandbox']=false;
$k['sandbox_key']='sandy_maintenance_key'; //change this after every maintenance to keep it safe for the next
if($k['sandbox']==true){ //sandbox mode is on, so pause everything...
	if(isset($_GET[$k['sandbox_key']]) || isset($_SESSION[$k['sandbox_key']])){
		$_SESSION[$k['sandbox_key']]=true; //set session for maintenance and do nothing
	} else { //show maintenace message and exit
	
	print"<html>
		<head>
		<title>
		Maintenance Mode!
		</title>
		<meta http-equiv='refresh' content='30'/>
		</head>
		<body style='background:#000;color:#fff;text-align:center;font-family:calibri;'>
		<h1>WE ARE UNDERGOING MAINTENANCE <br/>PLEASE WAIT TILL DECEMBER 4, 12:00 AM!</h1>
		This update will enable us serve you better. Please bear with us and return on the announced date. 
		Remember to follow our social media pages for the latest update. Facebook and Twitter @MasterwebNG
		</body>
		</html>";
		exit;
	
} }






$k['site_name']='Pinga Agro Investment Limited';
$k['site_slogan']='PINGA another name for Quality';
$k['site_desc']=$k['site_name']." are into poultry farming and currently produce quality eggs which are distributed in Nigeria. You can purchase your eggs, old layers and manures from us.";
$k['cookie_url']='.pingaagro.com'; //cookie url .yourdomainname
$k['website']='pingaagro.com'; //domain url
$k['protocol']='https://'; //protocol
$k['files_folder']='h-s'; //files directory
$k['uploads_folder']='_uploads'; //this is where uploads go to, from root
$k['dir']=$dir; //relative root directory
$k['f_dir']=$k['dir'].$k['files_folder'].'/'; //relative files directory
$k['full_dir']=$k['protocol'].$k['website'].'/'; //absolute root directory
$k['full_f_dir']=$k['protocol'].$k['website'].'/'.$k['files_folder'].'/';  //absolute files directory
$k['uploads']=$k['dir'].$k['uploads_folder'].'/'; //relative uploads directory... useful while uploading or deleting
$k['full_uploads']=$k['protocol'].$k['website'].'/'.$k['uploads_folder'].'/';  //absolute uploads directory... for showing files publicly
$k['cdn']=$k['full_dir'].'_cdn/'; //where we save static files... we can use external server if we wish
$k['admin_dir']=$k['full_dir']."panel/"; //adim link
$k['admin_id']='1'; //account ID for super-admin //service charges go here


$k['site_email']='contact@pingaagro.com'; //for customer care and on receipt
$k['site_phone']='+2348052220220'; //for customer care and on receipt
$k['twitter']='pingaagro'; //to help fetch twitter data
$k['site_email_pwd']=''; //incase we are to use SMTP auth



$k['epoch']=$k['token']=date('U');
if(isset($_SERVER['HTTP_USER_AGENT'])){$k['my_browser']=$_SERVER['HTTP_USER_AGENT'];} else {$k['my_browser']='';}
$k['my_ip']=$_SERVER['REMOTE_ADDR'];
if(isset($_SERVER['HTTP_REFERER'])){$k['my_ref']=$_SERVER['HTTP_REFERER'];} else {$k['my_ref']='';}
$k['my_url']=$k['protocol'].$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$k['secret_key']='BM8ExSR%'; //change to logout everyone
$k['pwd_key']='Vastr^+J#'; // never change this one please, as it affects the pwd salt encryption, or everyone would recover account
$k['id-token']=md5('logon-id'.$k['secret_key']);
$k['pw-token']=md5('logon-pwd'.$k['secret_key']);
$k['tracker']='DEV'.md5('tracker'.$k['secret_key']);


$k['ads']='<div style="width:100%;height:90px;background:#000;color:#fff;margin:10px 0px 10px 0px;">Ads</div>';
$k['linkads']='<div style="width:100%;height:90px;background:#000;color:#fff;margin:10px 0px 10px 0px;">Link Ads</div>';
$k['headads']='';
$k['analytics']="<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src='https://www.googletagmanager.com/gtag/js?id=UA-101153841-11'></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-101153841-11');
</script>
";
?>