<?php


// email existence
function this_email_exists($email){
	$status=false;
	$sql="SELECT `id` FROM `account` WHERE `email`='$email' "; $result=query_sql($sql);
	if(mysqli_num_rows($result)=='1') {$status=true;}
			return $status;		}
	
	
// user existence
function this_user_exists($userid){
	$status=false;
	$sql="SELECT `id` FROM `account` WHERE `id`='$userid' "; $result=query_sql($sql);
	if(mysqli_num_rows($result)=='1') {$status=true;}
			return $status;		}
	

//pull user data
function get_user_info($user_id){
	$sql="SELECT*FROM `account` WHERE (`id`='$user_id' || `email`='$user_id')"; $result=query_sql($sql);
	while($x=mysqli_fetch_assoc($result))
	{$user_info=$x;}
			return $user_info;		}

//gets no img, so as not to cause max nesting for function
function get_simple_user_info($user_id){
	$sql="SELECT*FROM `account` WHERE (`id`='$user_id' || `email`='$user_id')"; $result=query_sql($sql);
	while($x=mysqli_fetch_assoc($result))
	{$user_info=$x;}
			return $user_info;		}





function get_user_img($user_id){
	global $k;
	$profile_pic="no-img";
	$status=true;
	$sql="SELECT * FROM `gallery` WHERE `object_id`='$user_id' && (`type`='2') ORDER BY `id` ASC"; 
	$result=query_sql($sql);
	while($f=mysqli_fetch_assoc($result))  { 
	$profile_pic=$k['f_dir']."uploads/".$f['file']; $profile_pic_full=$k['full_f_dir']."uploads/".$f['file'];  
											}
	if(!file_exists($profile_pic)){ $profile_pic=$profile_pic_full=$k['cdn'].'images/profile.png'; $status=false; }
	return array('profile'=>$profile_pic_full,'status'=>$status); }
	
	
	
	
function auth_login($username,$password,$log=true,$remember=true,$pwd_token=''){
	global $k;
	if($pwd_token==''){
	$pwd=get_pwd_token($password);
	} else {  $pwd=$pwd_token; } //the real db pwd can be sent direct in the case of 0auth logins
	$sql="SELECT `id` FROM `account` WHERE `password`='$pwd' && (`email`='$username') && `status`='1'";
	$result=query_sql($sql);
	if(mysqli_num_rows($result)!='1'){$status=false;}
	else{ $status=true;
	while($f=mysqli_fetch_assoc($result)){$account_id=$f['id'];}
	//if log is true, log session
	if($log==true){
	$_SESSION[$k['id-token']]=$account_id;
	$_SESSION[$k['pw-token']]=(md5($pwd).md5(base_convert($account_id,10,35).$k['secret_key']));
	$sql="UPDATE `account` SET `loginepoch`='".date('U')."' WHERE `id`='$account_id'";
	$result=query_sql($sql);
	//if remember is true, log cookie
	if($remember==true){
	$expires=time()+(60*60*24*100);
	setcookie( $k['id-token'], $_SESSION[$k['id-token']], $expires, '/', $k['cookie_url']); 
	setcookie($k['pw-token'], $_SESSION[$k['pw-token']], $expires, '/', $k['cookie_url']);
	}
	}
	}	
 return $status; }
 
 
 
function logout(){
	global $k;
	unset($_SESSION[$k['id-token']]);
	unset($_SESSION[$k['pw-token']]);
	unset($_SESSION['link']);
	unset($_SESSION['userid']);
	$expires=time()-(60*60*24*100);
	setcookie( $k['id-token'], 'delete', $expires, '/', $k['cookie_url']); 
	setcookie($k['pw-token'], 'delete', $expires, '/', $k['cookie_url']);
		}



function user_auth($user_id){ 
	global $k;
	 if(isset($_COOKIE[$k['id-token']]) && isset($_COOKIE[$k['pw-token']]))
	 {$_SESSION[$k['id-token']]=$_COOKIE[$k['id-token']]; $_SESSION[$k['pw-token']]=$_COOKIE[$k['pw-token']]; }
	 	 
	if(isset($_SESSION[$k['id-token']]) && isset($_SESSION[$k['pw-token']]) ){	 
	if(this_user_exists($_SESSION[$k['id-token']])) {
	$user_info=get_user_info($_SESSION[$k['id-token']]);
	$user_token=(md5($user_info['password']).md5(base_convert($user_info['id'],10,35).$k['secret_key']));
	if($user_token==$_SESSION[$k['pw-token']] && $user_info['id']==$_SESSION[$k['id-token']] && $user_info['status']=='1')
	{	
	// update last seen
	$epoch=date('U');
	$user_id=$user_info['id'];
	$sql="UPDATE `account` SET `lastepoch`='$epoch' WHERE `id`='$user_id'"; 
	$result=(query_sql($sql));
	//this is just for cometchat
	$_SESSION['userid'] = $user_id;
	
	} else { logout(); header('location:'.$k['full_dir'].'user/logout.php'); exit;  }	
	} else { logout(); header('location:'.$k['full_dir'].'user/logout.php'); exit;  }	
	}
	}


//user_auth
$m_info_user_id='0';
if(isset($_COOKIE[$k['id-token']]))
 {user_auth($_COOKIE[$k['id-token']]); $m_info=get_user_info($_SESSION[$k['id-token']]); $m_info_user_id=$m_info['id']; }
 else
 if(isset($_SESSION[$k['id-token']]))
 {user_auth($_SESSION[$k['id-token']]); $m_info=get_user_info($_SESSION[$k['id-token']]); $m_info_user_id=$m_info['id']; }
//user_auth





function is_logged(){
	global $k;
	$status=false;
	if(isset($_SESSION[$k['id-token']])){$status=true;}
	return $status; }


// page for user & visitor
function visitor_only($append=''){
	global $k;
	//if logged, redirect
	if(isset($_SESSION[$k['id-token']])){header('location:'.$k['full_dir'].$append);
	exit; }
}

function user_only($append=''){ 
	global $k;
	//if unlogged, redirect
	if(!(isset($_SESSION[$k['id-token']]))){header('location:'.$k['full_dir'].$append.'user/login.php');
	exit; }
}


function verified_user_only(){ 
	global $k;
	$status=false;
	//if unverified, show a message and exit
	if(is_logged()){ global $m_info; if($m_info['email_verify']=='1'){ $status=true; } }
	if(!($status)){ display_w_m("You are not verified and not eligible to access this content!"); exit; }
}





//makes sure that a user page is valid
function auth_user_page(){
	if(isset($_GET['id'])){ $username=sn_dt_eng($_GET['id']);
	if( !(this_user_exists($username)) ){ $error_page=true; }
	else{ $user=get_user_info($username);
	}
	} else { $error_page=true; }
	if(isset($error_page)){ redirect_404(); exit; }
	return $user; }




//Permission to view reports and take action 2 [moderator]
function has_basic_permission($level){
	$status=false;
	if($level>=1){ $status=true;	}
	return $status; }

//Permission to approve users and ban etc is 3 [1st admins with human power]
function has_manage_permission($level){
	$status=false;
	if($level>=1){ $status=true;	}
	return $status; }

//Permission for super admin is 4 [Ususally just one super admin with superpower]
function has_super_permission($level){
	$status=false;
	if($level>=2){ $status=true;	}
	return $status; }






//this function collects user_id or 0, and email, plus an optional name
//if id or email belongs to admin, it fails
//if it belongs to any user, it uses it to log the person in
//if it does not belong to anyone, it creates new account and logs the person in
//it returns true on success, and false on fail...
//any new id created is passed through a session
function log_me_in($email='',$user_id='0',$name='0'){
	global $k;
	$status=false;
	if($user_id!='0'){ $q_u=" && `id`='$user_id' "; }
	else if($email!=''){ $q_u=" && `email`='$email' "; }
	else{ $q_u=""; }
	$sql="SELECT * FROM `account` WHERE `email`!='' ".$q_u." ORDER BY `id` ASC LIMIT 0,1 ";
	$result=query_sql($sql);
	while($f=mysqli_fetch_assoc($result)){
		$user=$f;
		if($user['status']!='1'){ $status=false; }
		else if($user['admin']>0){ $status=false; }
		else{  $status=true; /**We need to log this person in**/ }
	}
	
	if( !(isset($user)) && $status==false){ //we need to create a new user
			
$password=new_phone_code();
$epoch=$k['epoch'];
$pwd=get_pwd_token($password);
$email_code=new_phone_code();

$sql="INSERT INTO `account`
(`name`,`email`,`password`,`lastepoch`,`regepoch`,`loginepoch`,`email_code`,`last_email_epoch`)
VALUES
('$name','$email','$pwd','$epoch','$epoch','$epoch','$email_code','$epoch')";
$result=query_sql($sql);
$user_id=last_id();
$user=get_object_info($user_id,'account');
$status=true;
	} //we need to create ended
	


//check overall whether we can proceed with login
if($status==true){ 
$_SESSION['new_user_data']=$user;
if( auth_login($user['email'],$user['password'],true,true,$user['password'])==false ){ $status=false; }
}

return $status;
}




?>