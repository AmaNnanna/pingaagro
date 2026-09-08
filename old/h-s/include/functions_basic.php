<?php

function css_styles(){  //for the website
 global $k;
 ?>
<link type="text/css" rel="stylesheet" href="<?php print $k['cdn']; ?>css/site.css?t=<?php print $k['epoch']; ?>"/>
<link type="text/css" rel="stylesheet" href="<?php print $k['cdn']; ?>css/common.css?t=<?php print $k['epoch']; ?>"/>
<?php }


function scare_attackers($dirty_html){
	$purifier = new HTMLPurifier();
    $clean_html = $purifier->purify($dirty_html);
return $clean_html; }



//sanitize data where any character is allowed
function sn_dt($check){
	$check=trim($check);
	$check=str_replace("<","&lt;",$check);
	$check=str_replace('>','&gt;',$check);
	$check=str_replace("\r\n","<br>",$check);
	$check=str_replace("\n","<br>",$check);
	$check=str_replace("\r","<br>",$check);
	$check=str_replace("/","&#47;",$check);
	$check=str_replace("\\","&#92;",$check);
	$check=str_replace("'","&#39;",$check);
	$check=str_replace('"','&quot;',$check);
	 return $check;}
 
 
 //sanitize data where eng only is needed, like in username choosing and email
function sn_dt_eng($check){
	$check=htmlentities($check); //convert strange chars first
	$check=sn_dt($check); //then sanitize normal
	 return $check;}
 
 
 
 //sanitize data and truncate... for strings that must be truncated like in quote
 function truncate_msg($check,$count=300)	{
	$check=substr($check,0,$count);
	$check=sn_dt($check);
	 return $check;			}
 
 
 
 //makes data ok on edit
 function backbreak($check){
	$check=str_replace("<br/>","\r\n",$check);
	$check=str_replace("<br>","\r\n",$check);
	$check=str_replace("&gt;",">",$check);
	$check=str_replace("&lt;","<",$check);
	$check=str_replace("&#39;","'",$check);
	$check=str_replace('&quot;','"',$check);
	$check=str_replace("&#47;","/",$check);
	$check=str_replace("&#92;","\\",$check);
	 return $check;}
 
 
 
//sanitize data for javascript
function sn_dt_js($check){
	$check=str_replace("\r\n"," ",$check);
	$check=str_replace("\n"," ",$check);
	$check=str_replace("\r"," ",$check);
	$check=str_replace('"','\"',$check);
	$check=str_replace("'","\'",$check);
	 return $check;}



//translate quotes b4 database insertion
function transform_quote($check){
	$check=str_replace("'","<code...>&#39;</code...>",$check);
	 return $check;}
	 
//re-translate quotes b4 sending out email
function retransform_quote($check){
	$check=str_replace("<code...>&#39;</code...>","'",$check);
	 return $check;}





 function sn_json($check){
	//$check=htmlentities($check);
	$check=str_replace("/","&#47;",$check);
	$check=str_replace("\\","&#92;",$check);
	$check=str_replace('"','&quot;',$check);
	$check=str_replace('<','&lt;',$check);
	$check=str_replace('>','&gt;',$check);
	$check=str_replace("\r\n"," ",$check);
	$check=str_replace("\n"," ",$check);
	$check=str_replace("\r"," ",$check);
	$check=str_replace("\t"," ",$check);
	 return $check;}

 
//return whatever you have changed in the json
function resn_json($check){
	//$check=html_entity_decode($check);
	$check=str_replace("&#47;","/",$check);
	$check=str_replace('&quot;','"',$check);
	$check=str_replace('&lt;','<',$check);
	$check=str_replace('&gt;','>',$check);
	 return $check;}


 //before url encode, convert quotes etc back so that it does not gets messed up. url encode will do its job
function format_sharing_text($check){
	$check=str_replace('&quot;','"',$check);
	$check=str_replace("&#39;","'",$check);
	return $check;}
 
 
 function remove_slash($check){
	 $check=scare_attackers($check);
	 $check=str_replace("\'","'",$check);
	$check=str_replace("'","&#39;",$check);
	$check=str_replace('\"','"',$check);
	$check=str_replace("\\","&#92;",$check);
return $check; }


/** More stuff for new additions**/
function generate_friendly_url($f_url) {
	$f_url = (preg_replace("/[^A-Za-z0-9-]/", "-", $f_url));
	$f_url=str_replace('--','-',$f_url);
	$f_url=str_replace('---','-',$f_url);
	$f_url=str_replace('--','-',$f_url);
	$f_url=substr($f_url,'0','40');
	$f_url=strtolower($f_url);
	return $f_url; }
 
 
 //returns form post or get with a don't print request that is false by default 
 function r_f_p($check,$return=false){
	if(isset($_POST[$check])){
		if($return==false){ print $_POST[$check];} else {
		return $_POST[$check]; }} }
	function r_f_g($check,$return=false){
	if(isset($_REQUEST[$check])){
		if($return==false){print $_REQUEST[$check]; } else {
		return $_REQUEST[$check]; }} }
//similar to function above but returns data, passed to it when the post,get are empty
//0=post,1=get
function r_f_double($name,$data='',$type='0'){
	$da='';
	if($type=='0'){ if(isset($_POST[$name])){ $da=$_POST[$name]; } }
	else { if(isset($_GET[$name])){ $da=$_GET[$name]; } }
		if($da==''){ $da=$data; }
		return $da; }

function check_box_default($value){
	if($value=='1'){$df=" checked ";}
	else {$df=" ";}
	return $df; }
	
function radio_button_default($value,$selected){
	if($value==$selected){$df=" checked ";}
	else {$df=" ";}
	return $df; }


function select_button_default($value,$exp){
	if($value==$exp){print " selected ";}
	 }


 
 //error, success, warning and tip messages
function display_e_m($message,$print=true){
	$message="<div class='error-message'><i class='fa fa-remove'></i> ".$message."</div>";
	if($print==true){print$message;}
	return $message; }
function display_s_m($message,$print=true){
	$message="<div class='success-message'><i class='fa fa-check-circle'></i> ".$message."</div>";
	if($print==true){print$message;}
	return $message; }
function display_w_m($message,$print=true){
	$message="<div class='warning-message'><i class='fa fa-warning'></i> ".$message."</div>";
	if($print==true){print$message;}
	return $message; }
function display_t_m($message,$print=true){
	$message="<div class='tip-message'><i class='fa fa-lightbulb-o'></i> ".$message."</div>";
	if($print==true){print$message;}
	return $message; }


	
//get suffix for plural	
function get_plural($no){
	if( $no>1)
	{$status='s'; } else {$status='';}
	print $status; }
	
	
//get hw many times ago
function timecalc($time) {
	$sdiff=date('U')-$time;
	if($sdiff<60){ if(floor($sdiff)>1){$sss="s";} else {$sss="";} $time=floor($sdiff)." Second".$sss." ago";}
	 $mdiff=floor($sdiff/60);
	if($mdiff<60 && $mdiff>0){if(floor($mdiff)>1){$sss="s";} else {$sss="";} $time=floor($mdiff)." Min".$sss." ago";}
	 $hdiff=floor($mdiff/60);
	if($hdiff<24 && $hdiff>0){if(floor($hdiff)>1){$sss="s";} else {$sss="";} $time=floor($hdiff)." Hr".$sss." ago";}
	 $ddiff=floor($hdiff/24);
	if($ddiff<28 && $ddiff>0){if(floor($ddiff)>1){$sss="s";} else {$sss="";} $time=floor($ddiff)." Day".$sss." ago";}
	 $modiff=floor($ddiff/28);
	if($modiff<13 && $modiff>0){if(floor($modiff)>1){$sss="s";} else {$sss="";} $time=floor($modiff)." Month".$sss." ago";}
	 $ydiff=floor($modiff/13);
	if($ydiff>=1){if(floor($ydiff)>1){$sss="s";} else {$sss="";} $time=floor($ydiff)." Year".$sss." ago";}
	return $time;}
	
//times ago plus detail
function fulltime($epoch){
	$time=getdate($epoch);
	$full=timecalc($epoch)." &middot;
	".$time['mday']." ".$time['month']." ".$time['year']." ".correct_time_digit($time['hours']).":".correct_time_digit($time['minutes']);
	$full=date('M d Y h:m a ',$epoch);
	return $full; }
	
//convert total no of seconds to readable time
function seconds_word($seconds) {
	$hours=floor($seconds/3600);
	$min_left=floor(($seconds) - ($hours*3600));
	$min = floor($min_left/60);
	$rem_seconds = $seconds%60;
	$time=$hours."h:".$min."m:".$rem_seconds."s";
	return $time;}

//where a 1 digit month, day, hour, min or sec is returned, this is used to append zero to front to make sure standards are adhered to
function correct_time_digit($no){
	if($no<10){$no="0".$no; }
	return $no; }

//organises time text or string
function process_time($epoch){
	global $k;
	if(!ctype_digit($epoch)){ $epoch=strtotime($epoch); }
	/**
[seconds] - seconds
[minutes] - minutes
[hours] - hours
[mday] - day of the month
[wday] - day of the week
[mon] - month
[year] - year
[yday] - day of the year
[weekday] - name of the weekday
[month] - name of the month
[0] - seconds since Unix Epoch
	**/
	$time=getdate($epoch); 
	//readable format //04 January 2018 12:59
	$time['full']=correct_time_digit($time['mday'])." ".$time['month']." ".$time['year']." ".
	correct_time_digit($time['hours']).":".correct_time_digit($time['minutes']); 
	//2017-06-01T08:30 //format needed in html forms
	$time['form']=$time['year']."-".correct_time_digit($time['mon'])."-".
	correct_time_digit($time['mday'])."T".correct_time_digit($time['hours']).":".correct_time_digit($time['minutes']); 
	$time['formdate']=$time['year']."-".correct_time_digit($time['mon'])."-".
	correct_time_digit($time['mday']); 
	//Diff
	$time['diff']=$time[0]-$k['epoch'];
	return $time; }




//Get short form of long numbers
function shorten_number($no){
	$l=strlen($no);
	if($l<=3){ $n=$no; } //less than thousand, return like that
	else if($l>3 && $l<=6){ $no=round(($no/1000),1); $n=$no."k";  }	//In thousands
	else if($l>6 && $l<=9){ $no=round(($no/1000000),1); $n=$no."m";  }	//In Millions
	else if($l>9 && $l<=12){ $no=round(($no/1000000000),1); $n=$no."b";  }	//In Billions
	else if($l>9){ $no=round(($no/1000000000000),1); $n=$no."t";  }	//In Trillions
	return $n; }
	
	
//Get short form of times when given seconds
function shorten_time($sdiff){
	if($sdiff<60){ $n=$sdiff." seconds";} //seconds
	else if($sdiff<(60*60)){ $n=round(($sdiff/60),0)." mins"; } //minutes
	else if($sdiff<(24*60*60)){ $n=round(($sdiff/(60*60)),0)." hrs"; } //hours
	else { $n=round(($sdiff/(60*60*24)),0)." days"; } //days
	return $n; }



function number_to_month($n){
	if($n==1){$month="January";}
	else if($n==2){$month="February";}
	else if($n==3){$month="March";}
	else if($n==4){$month="April";}
	else if($n==5){$month="May";}
	else if($n==6){$month="June";}
	else if($n==7){$month="July";}
	else if($n==8){$month="August";}
	else if($n==9){$month="September";}
	else if($n==10){$month="October";}
	else if($n==11){$month="November";}
	else if($n==12){$month="December";}
	else{$month="NewlyFound";}
	return $month; }


function percentage_calc($percent,$number){
	$no=(($percent/100)*$number);
	return $no;
}



// This generates a random number
function random_number(){
	$numbers=array(0,1,2,3,4,5,6,7,8,9);
	shuffle($numbers);
	return $numbers[0]; }
	
// This generates a random alphabet
function random_alpha(){
	$numbers=array('a','A','B','b','c','D','d','e','E','F','f','G','h','H','i','J','j','K','m','M','n',
				   'N','P','Q','q','R','r','S','s','T','t','U','v','W','x','Y','Z');
	shuffle($numbers);
	return $numbers[0]; }
	
function new_phone_code(){
	return random_alpha().random_number().random_alpha().random_alpha().random_number();
	}


// generate hourly token to monitor spam
function hourly_token($salt=''){
	global $k;
	$token=md5($k['secret_key'].date('d-H-m-Y').$salt);
	return $token; }
	
function get_token($input){
	global $k;
	$token=md5($k['secret_key'].md5($input));
	return $token; }
	
function get_pwd_token($input){
	global $k;
	$token=md5($k['pwd_key'].md5($input));
	return $token; }
	
	
	
//validate email
function validate_email($email){
	$status=false;
	$email=strtolower($email);
	$regex='/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
	if(preg_match($regex, $email)){$status=true;}
	return $status; }
	
//Validate any message
function validate_message($message){
	$status=false;
	if(  strlen($message)>0 ){	 $status=true; } 
	return $status; }


//Validate any phone
function validate_phone($no){
	$status=false;
	if(  substr($no,0,1)=='+' && strlen($no)>7 ){	 $status=true; } 
	return $status; }


//validate allowed username
function validate_username($username){
	$status=false;
	$regex='/^[A-Za-z0-9]{1}[A-Za-z0-9_]{2,19}$/'; 
	if(preg_match($regex, $username) && !(ctype_digit($username)) && ($username!='user' && $username!='search' && $username!='msg' 
			  && $username!='developers' && $username!='about' && $username!='campaigns' && $username!='inbox' && $username!='pages'
			  && $username!='www' && $username!='messages' && $username!='login' && $username!='logout' && $username!='signin'
			   && $username!='signout' && $username!='settings' && $username!='signup' && $username!='register' && $username!='live'
			   && $username!='cpanel' && $username!='webmail' && $username!='discover' && $username!='post' && $username!='annual' 
			   && $username!='popular' && $username!='promo' && $username!='channel' && $username!='channels' && $username!='register' 
			   && $username!='join' && $username!='invite' && $username!='admin' && $username!='official' && $username!='term' 
			   && $username!='terms' && $username!='privacy' && $username!='policy' && $username!='trade' && $username!='trader' 
			   && $username!='user' && $username!='superuser' && $username!='adminuser'))
	{$status=true;}
	return $status; }
	
	
function validate_password($pwd){
	$status=false;
	if(  strlen($pwd)>4 ){	 $status=true; } 
	return $status; }






//validate allowed digits in currency
function validate_decimal($no){
	$status=false;
	//0-9 between 1-19 digits, dot once, 0-9 between 1 to 19 digits
	//or whole number
	$regex='/^[0-9]{1,19}[.]{1}[0-9]{1,19}$/'; 
	if( preg_match($regex, $no) || ctype_digit($no) )
	{$status=true;}
	return $status; }


function format_decimal($no){
	//$no=" ".$no;
	//$no=str_replace(' -','',$no);
	//$no=str_replace(' ','',$no);
	$data=explode('.',$no);
	$sep=count($data);
	if($sep==0){ $new=0; }
	else if($sep==1 && ctype_digit($data[0])){ $new=number_format($data[0]); }
	else if($sep==2 && ctype_digit($data[0])){ $new=number_format($data[0]).".".$data[1]; }
	else{$new=$no;}
	return $new; }
	






	




function go_to($url=''){
	global $k;
	if($url==''){$url=$k['full_dir'];}
	header('location:'.$url);
	 exit;}



function redirect_404(){ //for desktop
	global $k;
	go_to($k['full_dir'].'404-page'); 
	}









function get_photo_img($type='icon'){
	global $k;
	if($type=='favicon'){ $t='22'; }
	else if($type=='logo'){ $t='21'; }
	else{ $type='icon'; $t='23'; } //icon
	$profile_pic="no-img";
	$status=true;
	$sql="SELECT * FROM `gallery` WHERE `type`='$t' ORDER BY `id` ASC LIMIT 0,1"; 
	$result=query_sql($sql);
	while($f=mysqli_fetch_assoc($result))  { 
	$profile_pic=$k['uploads']."uploads/".$f['file']; $profile_pic_full=$k['full_uploads']."uploads/".$f['file'];  
											}
	if(!file_exists($profile_pic)){ $profile_pic=$profile_pic_full=$k['cdn'].'css/'.$type.'.png?t='.$k['token']; $status=false; }
	return array('photo'=>$profile_pic_full,'status'=>$status); }








//Email sending
function sending_email($email,$subject,$message,$footer='',$reply_to=''){
	global $k;
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	// Additional headers
	$headers .= 'From: '.$k['site_name'].' <'.$k['site_email'].'>' . "\r\n";
	$headers .= 'Bcc: '.$email.'' . "\r\n";
	if($reply_to!=''){ $headers .= 'Reply-to: '.$reply_to.'' . "\r\n"; }
	
	if($footer==""){$footer="Please ignore this email if you never requested for such";}
	//format message	
	$temp_logo=get_photo_img('logo');
	$message="<div style='margin:0px;background:green;font-family:calibri;color:#000;font-size:13px;padding:10px;'>
	<div style='border-radius:5px;padding:10px;background:#fff;'>
	
	<div style='text-align:center;'>
	<a href='".$k['full_dir']."'>
	<img src='".$temp_logo['photo']."' title='".$k['site_name']." Logo' alt='".$k['site_name']." Logo' border='0' style='max-width:80%;'/>
	</a>
	</div>
	
	<div style='padding:5px 0px 5px 0px;font-size:14px;color:#000;margin:0px auto 0px auto;max-width:800px;'>
	".$message."
	</div>
	
	<div style='font-size:10px;color:gray;border-top:1px #000 solid;padding-top:5px;text-align:center;'>
	".$footer."
	</div>
	
	</div>
	</div>
	";
	@mail('',$subject, $message, $headers);	
}















//File uploader for documents and photos only
//Name is the html input name
//Maxfilesize in mb
//Folder where files are saved from uploads
//AllowedFileType can either be image(.jpg,.jpeg,.png,.gif) or document(.pdf,.doc,.docx) or video or all or some special combos (imagevideo, imagedocument)
//For images, optional resizing by setting width and quality
function multi_upload($name,$size,$folder,$type='all',$width=1200,$quality=100){
	global $k,$m_info;
	
if( isset($_FILES[$name]['tmp_name']) && basename($_FILES[$name]['tmp_name'])!=""){ //yes a file is being uploaded
if($type=='image'){$allowedExts = array("png", "jpeg", "jpg", "gif"); }
else if($type=='document') {$allowedExts = array("doc", "docx", "pdf"); }
else if($type=='video') {$allowedExts = array("webm", "mp4", "ogg","flv","avi","3gp","3gpp","wmv","m3u8","mov","ts"); }
else if($type=='audio') {$allowedExts = array("mp3","wma","wav"); }
else if($type=='audiovideo') {$allowedExts = array("webm", "mp4", "ogg","flv","avi","3gp","3gpp","wmv","m3u8","mov","ts","mp3","wma","wav"); }
else if($type=='imagevideo') {$allowedExts = array("png", "jpeg", "jpg", "gif","webm", "mp4", "ogg","flv","avi","3gp","3gpp","wmv","m3u8","mov","ts"); }
else if($type=='imagedocument') {$allowedExts = array("doc", "docx", "pdf","png", "jpeg", "jpg", "gif"); }
else{ $allowedExts = array("doc", "docx", "pdf","png", "jpeg", "jpg", "gif","webm", "mp4", "ogg","flv","avi",
						   "3gp","3gpp","wmv","m3u8","mov","ts","mp3","wma","wav"); }
	
$error_message='';
$fileextension = strtolower(pathinfo($_FILES[$name]["name"], PATHINFO_EXTENSION));
$filesize=floor(($_FILES[$name]["size"])/(1024*1024)); //in mb
$mime=strtolower($_FILES[$name]["type"]);

//Allowed mime types 
if (  
	(($type=='all' || $type=='imagedocument' || $type=='document') && (
			($mime == "application/pdf")
			|| ($mime == "application/x-pdf")
			|| ($mime == "application/acrobat")
			|| ($mime == "application/vnd.pdf")
			|| ($mime == "applications/vnd.pdf")
			|| ($mime == "text/pdf")
			|| ($mime == "text/x-pdf")
			|| ($mime == "application/msword")
			|| ($mime == "application/word")
			|| ($mime == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
											))
	||
	
	(($type=='all' || $type=='imagevideo' || $type=='imagedocument' || $type=='image' ) && (
			($mime == "image/gif")
			|| ($mime == "image/jpeg")
			|| ($mime == "image/jpg")
			|| ($mime == "image/pjpeg")
			|| ($mime == "image/pjpg")
			|| ($mime == "image/png")
											))
	||
	
	(($type=='all' || $type=='imagevideo' || $type=='video' ) && (
			($mime == "video/webm")
			|| ($mime == "video/mp4")
			|| ($mime == "video/ogg")
			|| ($mime == "video/flash")
			|| ($mime == "video/x-flv")
			|| ($mime == "video/flv")
			|| ($mime == "video/avi")
			|| ($mime == "video/x-msvideo") //avi
			|| ($mime == "video/3gpp")
			|| ($mime == "video/3gp")
			|| ($mime == "video/x-ms-wmv")
			|| ($mime == "video/wmv")
			|| ($mime == "application/x-mpegurl") //iPhone Index  .m3u8
			|| ($mime == "video/mp2t") //iPhone Segment  .ts 
			|| ($mime == "video/quicktime") //.mov
											))
	||
	
	(($type=='all' || $type=='audiovideo' || $type=='audio' ) && (
			($mime == "audio/mpeg") //.mp3
			|| ($mime == "audio/mp3") //.mp3
			|| ($mime == "audio/x-ms-wma")//.wma
			|| ($mime == "audio/wma") //.wma
			|| ($mime == "audio/wav") //.wav
											))

) {} else {$error_message.='<div>Uploaded file type is not allowed</div>';}

//Allowed size, in mb
if($filesize > $size){$error_message.='<div>Uploaded file is more than '.$size.'mb</div>';}

//Allowed extension
if(in_array($fileextension, $allowedExts))
	{} else {$error_message.='<div>Allowed extensions are '.strtoupper(implode($allowedExts,', ')).'</div>';}
	
//Check for internal error code
if ($_FILES[$name]["error"] > 0)
   {$error_message.= "<div>An error occured during upload! Code:" . $_FILES[$name]["error"] . "</div>";  }
   
  if($fileextension=='png' || $fileextension=='gif' || $fileextension=='jpeg' || $fileextension=='jpg'){
	  	$doctype='image'; $doctype_id='1';
		 $file=$_FILES[$name]['tmp_name']; $filedetails=getimagesize($file);
		if(($filedetails[2]=="1") || ($filedetails[2]=="2") || ($filedetails[2]=="3")){} else { 
		$error_message.= "<div>The image you uploaded is not a valid JPG, GIF & PNG</div>";}
  }else if($fileextension=='webm' || $fileextension=='mp4' || $fileextension=='ogg' || $fileextension=='flv' || 
		   $fileextension=='avi' || $fileextension=='3gp' || $fileextension=='3gpp' || $fileextension=='wmv'){
	  $doctype='video'; $doctype_id='2';
  }else if($fileextension=='mp3' || $fileextension=='wav' || $fileextension=='wma'){
	  $doctype='audio'; $doctype_id='3';
  }
  else{ $doctype='document'; $doctype_id='0'; }


//Check done, time to upload and update
 if($error_message=='') {
	 
	 $targetpath=$folder."/".uniqid()."_".$m_info['id'].".".$fileextension;  
	 $new_uri=$k['uploads']."uploads/".$targetpath;
	 move_uploaded_file($_FILES[$name]["tmp_name"],$new_uri);
	 $status=array(true,$targetpath,$fileextension,$doctype,$doctype_id);
	 //resize if image
	 if($doctype=='image'){
		resize($width,$new_uri,500,$quality); //resize ..width500px,uri,maxkb,quality 
	 }
	 
	 
 } else { $status=array(false,$error_message); }

//yes a file is being uploaded brace closed here
} else { $status=array(false,"No File Selected For Upload"); }
	
	
	return $status; }







/**
 * Image resize
 * @param int $width
 * @param str $img_dir
 * @param int $max_kb
 * @param int $quality 1-100
 */
function resize($width,$img_dir,$max_kb,$quality=100){
  /* Get original image x y*/
  list($w, $h) = getimagesize($img_dir);
  $kb=floor(filesize($img_dir)/1024);
  
  //any condition found true prompts resize... greater than recommended width or kb
  if (($kb>$max_kb) || ($w>$width) ){
  /*Assign new height based on original size 
  $w==$width
  $h==$height
  $height=floor(($width*$h)/$w);
  */
  $height=floor(($width*$h)/$w);
  
  
  /* calculate new image size with ratio */
  $ratio = max($width/$w, $height/$h);
  $h = ceil($height / $ratio);
  $x = ($w - $width / $ratio) / 2;
  $w = ceil($width / $ratio);
  /* new file name */
  $path = $img_dir;
  /* read binary data from image file */
  $imgString = file_get_contents($img_dir);
  /* create image from string */
  $image = imagecreatefromstring($imgString);
  $tmp = imagecreatetruecolor($width, $height);
  imagecopyresampled($tmp, $image,
    0, 0,
    $x, 0,
    $width, $height,
    $w, $h);
  /* Save image */
      imagejpeg($tmp, $path, $quality); 
  return $path;
  /* cleanup memory */
  imagedestroy($image);
  imagedestroy($tmp);
  
  }
}




function make_links($text, $class='', $target='_blank'){
	$text=str_replace("&#47;","/",$text);
    return preg_replace('!((http\:\/\/|ftp\:\/\/|https\:\/\/)|www\.)([-a-zA-Z0-9\~\!\@\#\$\%\^\&\*\(\)_\-\=\+\\\/\?\.\:\;\'\,]*)?!ism', 
    '<a class="'.$class.'" href="//$3" target="'.$target.'">$1$3</a>', 
    $text);
}


//Use double @ to put a link relative to this website for use in support
function shortcode_link($string){
	global $k;
	$string=" ".$string." ";
	$string=preg_replace("/ @@([^\s[:punct:]]+)/", "<a href='".$k['full_dir']."$1' target='_blank'> ".$k['full_dir']."$1 </a>", $string);	
	return $string; }
	
	
function replace_urls($string, $rel = 'nofollow'){
	global $k;
    $string=make_links($string, $class='', $target='_blank');
	$string=shortcode_link($string);
	return $string; } 
	

function format_link($url){
	$url=backbreak($url);
	$f=substr($url,0,7);
	$g=substr($url,0,8);
	if($f=='http://' || $g=='https://'){ $url=$url; } else { $url="http://".$url; }
	return $url;
}
	



function admin_power(){
	global $m_info,$k;
	$status=false;
	if($m_info['id']==$k['admin_id']){$status=true;}
return $status; }





//functions that show both facebook and Google Login/Register option
function social_button($word="Login With "){
	global $k;
	/**
	$data="
	<a href='".$k['full_dir']."0auth/fb/' rel='no-follow' class='button bg-blue' target='_blank'><i class='material-icons'>account_box</i>".$word."Facebook</a>
	<a href='".$k['full_dir']."0auth/gg/' rel='no-follow' class='button bg-blood' target='_blank'><i class='material-icons'>account_box</i>".$word."Google</a>";
	**/ $data="";
	return $data; }



//shows this when quick login options needs to be shown
function login_box($text="You are required to login or register to access this page"){
	global $k;
	if($text!=''){$text="<div class='warning-message'>".$text."</div>";}
	$data="<div>".$text.
	"<a href='".$k['full_dir']."login' class='button'><i class='material-icons'>account_box</i>Login</a>
	<a href='".$k['full_dir']."register' class='button'><i class='material-icons'>queue</i>Register</a>
	".social_button('')."
	</div>";
	
	return $data; }







function share_buttons($url='',$title=''){ ?>	
	<div style='margin:10px 0px 10px 0px;'>
    <?php print share_social($url,$title); ?>
	<a name='share'></a>
	</div>
<?php }




function share_social($url='',$title=''){ 
	global $k,$meta_title;
	
	if($url==''){ $url=$k['my_url']; }
	if($title==''){ $title=$meta_title; }
	$text=html_entity_decode(strip_tags($title));
	$text=format_sharing_text($text);
	$text=substr($text,0,115)." - ".$url;
	$share="	
	<div class='clear'>
	<a href='https://www.facebook.com/sharer/sharer.php?u=".urlencode($url)."' title='Click to share on Facebook' 
    target='_blank' title='Share on Facebook' class='no-decoration bold blue'>
	<img src='".$k['cdn']."css/icon_facebook.png' style='width:20px;margin-right:5px;border:0px;'/>
	</a>  
    <a href='https://twitter.com/intent/tweet?text=".urlencode($text)."' title='Click to share on Facebook' 
    target='_blank' class='no-decoration bold blue'>
	<img src='".$k['cdn']."css/icon_twitter.png' style='width:20px;margin-right:5px;border:0px;'/>
	</a>
	<a href='whatsapp://send?text=".urlencode($text)."' title='Click to share on Whatsapp' 
    target='_blank' class='no-decoration bold blue'>
	<img src='".$k['cdn']."css/icon_whatsapp.png' style='width:20px;margin-right:5px;border:0px;'/>
	</a>
	<a href='mailto:?subject=I want you to see this&amp;body=".urlencode($text)."' title='Click to share on Email' 
    target='_blank' class='no-decoration bold blue'>
	<img src='".$k['cdn']."css/icon_email.png' style='width:20px;margin-right:5px;border:0px;'/>
	</a>
	<a class='addthis_button_compact at300m' href='#' title='Click for more sharing options'>
	<img src='".$k['cdn']."css/icon_more.png' style='width:20px;margin-right:5px;border:0px;'/>
	</a>
	<script type='text/javascript' src='//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51864251488181a4'></script>
	</div>";
	return $share; }





function get_qrcode($url){
$url=urlencode($url);
$img="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=".$url;
	return $img; }




function remember_redirect_link(){
	global $k;
//rememeber redirect link
if(!(isset($_SESSION['link']))){
if(isset($_SERVER['HTTP_REFERER']))
{
$link=strtolower($_SERVER['HTTP_REFERER']);
if(strpos($link,$k['website'])) {
if(strpos($link,'login') || strpos($link,'register')  || strpos($link,'h-s'))
{$_SESSION['link']=$k['full_dir'];}
else{
$_SESSION['link']=$link;
}
}else{$_SESSION['link']=$k['full_dir'];}
}else{$_SESSION['link']=$k['full_dir'];}
}

}


//redirect after login
function redirect_after_login(){
	global $k;
	if(!(isset($_SESSION['link']))){ $redirect=$k['full_dir'];}
	else{ $redirect=$_SESSION['link']; unset($_SESSION['link']); }
	go_to($redirect); exit;
}
	




function query_sql($query){
	global $k;
	$result=mysqli_query($k['connection'],$query);
	return $result; }
	
function last_id(){
	global $k;
	$result=mysqli_insert_id($k['connection']);
	return $result; }



//How to fix
//Find mysql_query( and replace with query_sql(
//Then find any mysql_ and replace with mysqli_
//Replace mysqli_insert_id() with last_id()










//Email queuing to avoid server from becoming overloaded with emails being sent out
function email_queue($email,$subject,$message,$footer='',$priority='0'){
	global $k; 
	//print $message;
	$sql="INSERT INTO `email`
(`email`,`subject`,`content`,`footer`,`epoch_submitted`,`priority`)
VALUES
('$email','".transform_quote($subject)."','".transform_quote($message)."','".transform_quote($footer)."','".$k['epoch']."','$priority')";
$result=query_sql($sql);
	
}






function richtexteditor($empty=''){
	global $k;
	if($empty==''){ $return=''; } else {
	$return='<!--script src="//cdn.ckeditor.com/4.5.11/full/ckeditor.js"></script-->
<script src="'.$k['cdn'].'richtext/dist/trumbowyg.min.js"></script>
<link rel="stylesheet" href="'.$k['cdn'].'richtext/dist/ui/trumbowyg.min.css">
<script type="text/javascript">
$(".ckeditor").trumbowyg();
</script>'; }
	return $return; }










//Insert data into a specified table field
function save_data($id,$table,$field,$data){
	$sql="UPDATE `".$table."` SET `".$field."`='".$data."' WHERE `id`='".$id."' ";
	$result=query_sql($sql);
}


//Pull data from a specified table field
function pull_data($id,$table,$field){
	$sql="SELECT `".$field."` FROM `".$table."` WHERE `id`='".$id."' ";
	$result=query_sql($sql);
	while($f=mysqli_fetch_assoc($result)){$data=$f[$field];}
	return $data; }



//LOCATION OBJECT... accepts parameter of the table name, and other optional data

//existence... field is optional incase we don't want same field occuring twice, an an exception during edit
function this_object_exists($id,$table,$field='id',$exception='0'){
	$status=false;
	$sql="SELECT 1 FROM `".$table."` WHERE `".$field."`='$id' && `id`!='".$exception."' "; $result=query_sql($sql);
	if(mysqli_num_rows($result)=='1') {$status=true;}
			return $status;		}
	

//pulls it
function get_object_info($id,$table,$field='id'){
	$sql="SELECT * FROM `".$table."` WHERE (`".$field."`='$id')"; $result=query_sql($sql);
	while($x=mysqli_fetch_assoc($result))
	{$info=$x;} 
			return $info;		}


//makes sure that a page is valid ... use both in admin and in site... Add table name
function auth_object_page($table){
	if(isset($_GET['id'])){ $id=sn_dt($_GET['id']);
	if(!(this_object_exists($id,$table))){ $error_page=true; }
	else{ $object=get_object_info($id,$table); }
	} else { $error_page=true; }
	if(isset($error_page)){ redirect_404(); exit; }
	return $object; }





//get count based on sent criteria..
function get_table_count($table,$criteria){
	$visible="";
	if($criteria==''){ $where=""; } else { $where=" WHERE "; }
	$sql="SELECT 1 FROM `".$table."` ".$where." ".$criteria." "; $result=query_sql($sql);
	$count=mysqli_num_rows($result);
	if($count>0) { $visible="(".$count.")"; }
	$stats=array('count'=>$count,'visible'=>$visible);
			return $stats;		}
	






//payment methods are comma separated of allowed currencies.... we need to check a currency against the list
function check_against_list($no,$list){
	$status=false;
	$array=explode(',',$list);
	$count=count($array);
	for($i=0;$i<$count;$i++){
	if($array[$i]==$no){ $status=true; break; }	
	}	
	return $status; }







//VIEW

//Function for views... session/cookie based views [once everyday]...
//returns data of whether this user has viewed this page or not
//@ObjectID, @Type (1=places, 2=category, 3=location)
function has_viewed($object,$type){
	global $m_info_user_id,$k;
	$status=false;
	$token='view_tracker_'.$m_info_user_id.'_'.$type.'_'.$object;
	if( isset($_SESSION[$token]) || isset($_COOKIE[$token]) ){ $status=true; }
	return $status; }
	
	
	
//This function saves the view if none exists for this person and re-calculates views for the object and saves
//each session lasts 24hrs... owner necessary for calc of things like total posts views for a particular user 
function save_view($object,$type,$owner_id='0'){
	global $m_info_user_id,$k;
	if(!(has_viewed($object,$type))){ 
	//do insert and re-calculate
	$token='view_tracker_'.$m_info_user_id.'_'.$type.'_'.$object;
	$token_value=md5($m_info_user_id.'_'.$type.'_'.$object);
	$_SESSION[$token]=$token_value;
	$expires=time()+(60*60*24);
	setcookie( $token, $token_value, $expires, '/', $k['cookie_url']); 
	$field_name="view";
	if($type=='1'){ $tb_name="places"; } 
	else if($type=='2') { $tb_name="category"; }
	else if($type=='3') { $tb_name="location"; }
	$epoch=$k['epoch'];
	
	$sql="SELECT `view` FROM `".$tb_name."` WHERE `id`='".$object."' ";
	$result=query_sql($sql);
	while($f=mysqli_fetch_assoc($result)){ $no=$f['view']+1; }
	
	$sql="UPDATE `".$tb_name."` SET `".$field_name."`='".$no."' WHERE `id`='".$object."' ";
	$result=query_sql($sql);
	}
	}







function get_settings(){
	$setting=get_object_info('1','options');
	$settings=json_decode($setting['value'],true);
	$settings['home_text']=$setting['v1'];
	$settings['middle_text']=$setting['v2'];
 return $settings; }
 $settings=get_settings();
 




function log_incorrect_try(){
	global $k;
	if(isset($_SESSION['log_incorrect_try'])){ $_SESSION['log_incorrect_try']=$_SESSION['log_incorrect_try']+1;  }
	else{ $_SESSION['log_incorrect_try']=1; }
	if($_SESSION['log_incorrect_try']>20){ $_SESSION['log_incorrect_try_limit']=true; go_to($k['full_dir'].'logout'); }
}








function load_google_map($address){
$string="";
$address = urlencode($address);
$fullurl = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=true";
$string .= @file_get_contents($fullurl); // get json content
$json_a = json_decode($string, true); //json decoder

if(isset($json_a['results'][0]['geometry']['location']['lat'])){
 $latitude=$json_a['results'][0]['geometry']['location']['lat']; }
 else {$latitude='';}// get lat for json
if(isset($json_a['results'][0]['geometry']['location']['lng'])){
 $longitude=$json_a['results'][0]['geometry']['location']['lng']; }
 else{$longitude='';}// get lng for json

?>

<p>
<iframe width="100%" height="320" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $address; ?>&amp;aq=0&amp;oq=<?php echo $address; ?>&amp;;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo $address; ?>&amp;z=14&amp;ll=<?php echo $latitude; ?>,<?php echo $longitude; ?>&amp;output=embed"></iframe>
</p>

<?php }











function getYouTubeIdFromURL($url) {
	$code="";
  if (strpos( $url,"v=") !== false)
    {
        $code= substr($url, strpos($url, "v=") + 2, 11);
    }
    elseif(strpos( $url,"embed/") !== false)
    {
        $code= substr($url, strpos($url, "embed/") + 6, 11);
    }
	if(strlen($code)!=11){$code="";}
	return $code;
}






?>