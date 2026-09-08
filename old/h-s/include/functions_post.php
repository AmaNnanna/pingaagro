<?php

//helps to pull files from a relative upload url
function gallery_url($relative){
	global $k;
	$url=$k['full_uploads']."uploads/".$relative;
	return $url; }





//for uploading gallery group
function gallery_uploader($id,$type,$target,$v1=''){
	global $k;
	$target=str_replace('-','_',$target);
	?>
    <script>
//this one fetches the gallery by default
	$.ajax({url: "<?php print $k['full_f_dir']."include/uploader.php?id=".$id."&type=".$type."&target=".$target."&v1=".$v1; ?>", 
		success: function(result){
        $("#<?php print "feed-".$target; ?>").html(result);
    }});
	
//this one makes code shorter
function _<?php print $target; ?>(el) {
  return document.getElementById(el);
}

//handles the uploader and still fteches data back just as one above
function uploadFile<?php print $target; ?>() {
  var file = _<?php print $target; ?>("file<?php print $target; ?>").files[0];
  var filetitle = _<?php print $target; ?>("name<?php print $target; ?>").value;
  // alert(file.name+" | "+file.size+" | "+file.type);
  var formdata = new FormData();
  formdata.append("file", file);
  formdata.append("name", filetitle);
  formdata.append("submituploader", "ok");
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler<?php print $target; ?>, false);
  ajax.addEventListener("load", completeHandler<?php print $target; ?>, false);
  ajax.addEventListener("error", errorHandler<?php print $target; ?>, false);
  ajax.addEventListener("abort", abortHandler<?php print $target; ?>, false);
  ajax.open("POST", "<?php print $k['full_f_dir']."include/uploader.php?id=".$id."&type=".$type."&target=".$target."&v1=".$v1; ?>"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
  //use file_upload_parser.php from above url
  ajax.send(formdata);
}

//handles progress, called from the upload
function progressHandler<?php print $target; ?>(event) {
  _<?php print $target; ?>("loaded_n_total<?php print $target; ?>").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
  var percent = (event.loaded / event.total) * 100;
  _<?php print $target; ?>("progressBar<?php print $target; ?>").value = Math.round(percent);
  _<?php print $target; ?>("status<?php print $target; ?>").innerHTML = Math.round(percent) + "% uploaded Please Wait...";
}

//gets the data back after the upload, called from upload
function completeHandler<?php print $target; ?>(event) {
  _<?php print $target; ?>("feed-<?php print $target; ?>").innerHTML = event.target.responseText;
  _<?php print $target; ?>("progressBar<?php print $target; ?>").value = 0; //wil clear progress bar after successful upload
}

//shows error when there are issues, called from above
function errorHandler<?php print $target; ?>(event) {
  _<?php print $target; ?>("status<?php print $target; ?>").innerHTML = "Upload Failed";
}

//shows abort when network is disconnected
function abortHandler<?php print $target; ?>(event) {
  _<?php print $target; ?>("status<?php print $target; ?>").innerHTML = "Upload Aborted";
}
    </script>
	<?php
	print"<div id='feed-".$target."'></div>
	<iframe id='frame-".$target."' src='about:blank' 
	 name='frame-".$target."' marginwidth='0' marginheight='0' frameborder='no' scrolling='no'
	  width='0' height='0' allowTransparency='true' class='hidden'></iframe>";
}







//counts no of uploads for a group
function gallery_count($id,$type,$file_type=''){
	if($file_type==''){ $file_type_q=""; } else { $file_type_q=" && `file_type`='".$file_type."' "; }
	$sql="SELECT 1 FROM `gallery` WHERE `object_id`='$id' && `type`='$type' ".$file_type_q." "; $result=query_sql($sql);
	$count=mysqli_num_rows($result);
	return $count; }


//this outputs a gallery group, and follows same rule with uploader
function gallery_viewer($id,$type,$target,$file_type='',$title=''){
	global $k;
	
	if($file_type=='1'){
	if(gallery_count($id,$type,'1')>0){ print"<div class='gallery-type-title'>".$title."</div>";  
	$title="";
	}
	}
	
	print"<div id='viewfeed-".$target."'></div>
	<iframe src='".$k['full_f_dir']."include/viewer.php?id=".$id."&type=".$type."&target=".$target."&file_type=".$file_type."&title=".$title."' 
	id='viewframe-".$target."' name='viewframe-".$target."' marginwidth='0' marginheight='0' frameborder='no' scrolling='no' 
	width='0' height='0' allowTransparency='true' class='hidden'></iframe>";
	

}


//this deletes a gallery but you have to specify if not it will exit rather than deleting every gallery
function gallery_delete($query){
	global $k;
	if($query==''){ exit; }
	$sql="SELECT `id`,`file` FROM `gallery` WHERE ".$query." "; 
	$result=query_sql($sql);
	while($f=mysqli_fetch_assoc($result)){
		//remove
		$uql="DELETE FROM `gallery` WHERE `id`='".$f['id']."' ";
		$uesult=query_sql($uql);
		if(file_exists($k['uploads'].'uploads/'.$f['file'])){ unlink($k['uploads'].'uploads/'.$f['file']); }
	}
	return true; }



//individually, this is how a gallery is outputted
function gallery_display($f){
	global $k;
	
	$pic="";
if($f['file_type']=='0'){ 

$icon="<i class='fa fa-file'></i> ".strtoupper($f['extension'])." Document"; 
$pic="
<iframe 
src='//docs.google.com/viewer?url=".urlencode(gallery_url($f['file']))."&amp;embedded=true&amp;hl=en' 
title='".$f['title']." - Embedded Document' style='border: none;' class='gallery-type-doc'></iframe>";

}
else if($f['file_type']=='1'){ 

$icon="<i class='fa fa-file-image-o'></i> ".strtoupper($f['extension'])." Photo"; 
$pic="<a href='".gallery_url($f['file'])."' class='fancybox gallery-holder-cont' rel='group' title='".$f['title']."'>
<img src='".gallery_url($f['file'])."' alt='".$f['title']."' class='gallery-type-img'/>
</a>
";

}
else if($f['file_type']=='2'){ 

$icon="<i class='fa fa-file-video-o'></i> ".strtoupper($f['extension'])." Video"; 
$pic="
<video class='gallery-type-vid' controls>
 <source src='".gallery_url($f['file'])."'>
Your browser does not support the video ".$f['title']." </video>";

} else if($f['file_type']=='3'){ 

$icon="<i class='fa fa-file-audio-o'></i> ".strtoupper($f['extension'])." Audio"; 
$pic="
<audio class='gallery-type-aud' controls>
 <source src='".gallery_url($f['file'])."'>
Your browser does not support the audio ".$f['title']." </audio>";

}


print" ".$pic." ";


}















//list item category
function list_cat($cat=''){
global $k;
$result=query_sql("SELECT * FROM `category` WHERE `status`='1' ORDER BY `name` ASC LIMIT 0,40 ");
while($f=mysqli_fetch_assoc($result)){
	print"<a href='".$k['full_dir']."category/".$f['slug']."' class='link'>".$f['name']."</a>";
}
}






 //for select drop down on category
function cat_drop($stay=0,$show_null=false) {
	if($show_null!=false){print"<option value='0'>Select Category</option>";}
	$sql="SELECT `id`,`name` FROM `category` WHERE `status`='1' ORDER BY `name` ASC LIMIT 200"; 
	$result=query_sql($sql);
   	while($x=mysqli_fetch_assoc($result)){ //mainwhile
   if($stay==$x['id']){ $selected="selected='selected'";} else {$selected="";} 
	print"<option value='".$x['id']."' ".$selected.">".$x['name']."</option>"; 
	}//main while
 }























//gets any picture in a post, and if no picture is attached, gets profile pics of the owner... but returns false as status


function get_post_img($item_id){
	global $k;
	$profile_pic="no-img";
	$status=true;
	$sql="SELECT * FROM `gallery` WHERE `object_id`='$item_id' && (`type`='3') ORDER BY `id` ASC"; 
	$result=query_sql($sql);
	while($f=mysqli_fetch_assoc($result))  { 
	$profile_pic=$k['uploads']."uploads/".$f['file']; $profile_pic_full=$k['full_uploads']."uploads/".$f['file'];  
											}
	if(!file_exists($profile_pic)){ $profile_pic=$profile_pic_full=$k['cdn'].'images/item.png'; $status=false; }
	return array('photo'=>$profile_pic_full,'status'=>$status); }





//this is a page for articles
function flat_post($f){
	global $k;
	$img=get_post_img($f['id']);
	if($img['status']==true){ $photo="<img src='".$img['photo']."' align='left' style='width:50px;padding-right:10px;'/>"; } else { $photo=""; }
	if($f['show_time']=='1'){ $time=" &nbsp; ".fulltime($f['lastepoch'])." "; } else { $time=""; }
	print"<div class='flat-post'> 
	<a href='".$k['full_dir']."page-".$f['id']."' class='post-title title-font'>
	".$photo."
	".$f['title']."</a> 
	<span class='meta smaller inline-block'>".$time."</span>
	<div class='clear'></div>
	</div>";
	}




function grid_post($f,$print=true){
	global $k;
	$img=get_post_img($f['id']);
ob_start();
if($f['show_time']=='1'){ $time=" &nbsp; ".fulltime($f['lastepoch'])." "; } else { $time=""; }
?>
<a href='<?php print $k['full_dir']; ?>page-<?php print $f['id']; ?>' class='grid-post'>
<div class='photo'><img src='<?php print $img['photo']; ?>'/></div>
<div class='post-title title-font'><?php print $f['title']; ?></div>
<div><?php print $time; ?></div>
<div class='clear'></div>
</a>
<?php
$data=ob_get_contents();
ob_end_clean();
if($print==true){ print $data; } else { return $data; }
}





function grid_team($f,$print=true){
	global $k;
	$img=get_post_img($f['id']);
ob_start();
?>
<span href='<?php print $k['full_dir']; ?>page-<?php print $f['id']; ?>' class='grid-post' style='background:#A3D982;'>
<div class='photo'><img src='<?php print $img['photo']; ?>'/></div>
<div class='post-title title-font'><?php print strip_tags($f['content']); ?></div>
<div class='smaller' style='color:#000;'><?php print $f['title']; ?></div>
<div class='clear'></div>
</span>
<?php
$data=ob_get_contents();
ob_end_clean();
if($print==true){ print $data; } else { return $data; }
}








//this fetches menu from settings and lists them
function fetch_top_menu(){
	global $settings;
	$menu="";
	if(isset($settings['menu'])){ //start
	$men=explode('<br>',resn_json($settings['menu']));
	if(count($men)>0){ //0
		foreach($men as $item){ //1
			$me=explode(',',$item);
			if(count($me)>1){//2
				$menu=$menu."<div class='header-link'><a href='".$me[1]."'>".$me[0]."</a></div>";	
			}//2	
		} //1
	} //0
	}//start
	return $menu;
}







function flash_head($settings){
	$text=trim(resn_json($settings['flash_text']));
	if($settings['flash']=='1' && $text!=''){
		$file_data=explode('--',$text);
		if(count($file_data)==2){  $file_title=$file_data[0]; $file_url=trim($file_data[1]); $file_start="<a href='".$file_url."' ";  $file_close='</a>'; }
		else{ $file_title=$text; $file_start='<span ';  $file_close='</span>';}
		print $file_start." class='flash-box'>".$file_title.$file_close;
	}
}




?>