<?php
include('dir.php');
$page_name="index";
if(!(is_logged())){ exit; }
$token=hourly_token();
//verified_user_only();
?>
<!--html>
<head>
<title>Gallery Uploader</title>
<meta charset="utf-8"/>
<meta http-equiv="Content-Type" content="text/html"/>
</head>
<body-->
<?php ob_start(); ?>
<div>
<?php








/**


Video formats and their mime types
WebM	video/webm
MP4	video/mp4
OGG	video/ogg
FLV	video/flash video/x-flv video/flv 
AVI	video/avi video/x-msvideo
3GP	video/3gpp video/3gp
WMV	video/x-ms-wmv video/wmv

**/




//these 3 are very compulsory
$id=get_get('id');
$type=get_get('type');
$target=get_get('target');
if($id=='' || $type=='' || $target==''){ display_e_m("Some tokens are missing"); goto bottomline;  }
//$v1=get_get('v1');
$v_sq="";
$allowed="all";
$max_no=10; //you can reduce or increase for diff object types
$only_one_needed=false; //this makes sure existing gets over-written wheneve new one is sent

/**
Types: 1 TMP for anything, 2 profile photo, 3 articles cover photo, 4 articles gallery, 20 is homepage slider,
21 logo, 22 favicon, 23 icon
**/
//In Profile Pics, there is no limit shown but previous uploads are deleted as soon as new one is uploaded
//In TMP, just ID of user is saved in object.... object and type are updated as soon as any post is sent or attachments are deleted after 24 hours



//Now select object and its features based on type
if($type=='1'){ //TMP
	if(!(this_object_exists($id,'account'))){ display_e_m("User does not exist"); goto bottomline; } else { 
	$object=get_object_info($id,'account');
	$ownership_check=$object['id'];
	$allowed="image";
	}
} else if($type=='2'){ //profile pics
	if(!(this_object_exists($id,'account'))){ display_e_m("Account does not exist"); goto bottomline; } else { 
	$object=get_object_info($id,'account');
	$account=$object;
	$ownership_check=$object['id'];
	$allowed="image";
	$max_no=2;
	$only_one_needed=true; 
	}
} else if($type=='3'){ //Post cover
	if(!(this_object_exists($id,'page'))){ display_e_m("Post does not exist"); goto bottomline; } else { 
	$object=get_object_info($id,'page');
	$ownership_check=$object['user_id'];
	$allowed="image";
	$max_no=2;
	$only_one_needed=true; 
	}
} else if($type=='4'){ //Post Gallery
	if(!(this_object_exists($id,'page'))){ display_e_m("Post does not exist"); goto bottomline; } else { 
	$object=get_object_info($id,'page');
	$ownership_check=$object['user_id'];
	$allowed="image";
	}
} else if($type=='20'){ //Homepage slider
	$object=get_object_info($k['admin_id'],'account');
	$account=$object;
	$ownership_check=$object['id'];
	$allowed="image";
}  else if($type=='21'){ //Logo
	$object=get_object_info($k['admin_id'],'account');
	$account=$object;
	$ownership_check=$object['id'];
	$allowed="image";
	$max_no=2;
	$only_one_needed=true; 
}  else if($type=='22'){ //Favicon
	$object=get_object_info($k['admin_id'],'account');
	$account=$object;
	$ownership_check=$object['id'];
	$allowed="image";
	$max_no=2;
	$only_one_needed=true; 
}  else if($type=='23'){ //Icon
	$object=get_object_info($k['admin_id'],'account');
	$account=$object;
	$ownership_check=$object['id'];
	$allowed="image";
	$max_no=2;
	$only_one_needed=true; 
} 












//has upload permission
if( isset($ownership_check) &&  ($ownership_check==$m_info['id'] || has_basic_permission($m_info['admin'])) ){  
} else { display_e_m("You do not have permission to upload to this page"); goto bottomline; }




if($allowed=="image"){ $allowed_desc="Photo (JPG, PNG, GIF)"; }
else if($allowed=="document"){ $allowed_desc="Document (PDF, DOC, DOCX)"; }
else if($allowed=="video"){ $allowed_desc="Video (3GP, AVI, MP4, FLV, WMV)"; }
else if($allowed=="audio"){ $allowed_desc="Audio (MP3, WEBM, WMA)"; }
else if($allowed=="imagevideo"){ $allowed_desc="Photo/Video/Audio (JPEG, PNG, GIF, 3GP, AVI, MP4, FLV, WMV, MP3, WEBM, WMA)"; }
else if($allowed=="audiovideo"){ $allowed_desc="Video/Audio (3GP, AVI, MP4, FLV, WMV, MP3, WEBM, WMA)"; }
else if($allowed=="imagedocument"){ $allowed_desc="Photo/Document (JPEG, PNG, GIF, PDF, DOC, DOCX)"; }
else{ $allowed_desc="Picture/Video/Audio/Document (JPEG, PNG, GIF, 3GP, AVI, MP4, FLV, WMV, MP3, WEBM, WMA, PDF, DOC, DOCX)"; }

$upload_count=gallery_count($id,$type);









//Deleting
if(isset($_GET['del'])){
	$gal_id=sn_dt($_GET['del']);
	//check if connection exists
    if(this_object_exists($gal_id,'gallery')){ 
	$gal_data=get_object_info($gal_id,'gallery');
		if($gal_data['type']==$type && $gal_data['object_id']==$object['id']){




		//remove
		gallery_delete(" `id`='".$gal_data['id']."' ");
		display_s_m("File Deleted!");
		$upload_count=$upload_count-1;




		
		}else { display_s_m("You do not have permission to delete this file!"); }
	}else { display_s_m("This file does not exist!"); }
}


?>













<?php //make upload form available if count has not exceeded $max_no=10
if($upload_count>=$max_no){ display_e_m("You can delete some attachment if you wish to upload more"); } else {

//process any upload
if(isset($_POST['submituploader'])){ //1.attempt
	$name=sn_dt($_POST['name']);
	if($name==''){ $name=date('r'); }
	$upload=multi_upload('file',100,date('Y'),$allowed);
if($upload[0]==false){ display_e_m($upload[1]); }
else{ //2.there is upload




display_s_m("File Upload Successful");
$upload_count=$upload_count+1;
$epoch=$k['epoch'];
$sql="INSERT INTO `gallery`
(`title`,`user_id`,`object_id`,`type`,`file`,`extension`,`epoch`,`file_type`)
VALUES
('$name','".$m_info['id']."','".$object['id']."','$type','".$upload[1]."','".$upload[2]."','$epoch','".$upload[4]."')";
$result=query_sql($sql);
$last_attach_id=last_id();





if($only_one_needed==true){ //delete any other existing cos just one type is needed
		gallery_delete(" `object_id`='".$object['id']."' && `type`='$type' && `id`!='$last_attach_id'   ");
		//$upload_count=$upload_count-1;
}












} //2.

} //1.






if($only_one_needed){ $temp_text_field='hidden'; } else { $temp_text_field='text'; }
?>
<div>
<div class='smaller orange'><?php print $allowed_desc; ?></div>
<form id="upload_form<?php print $target; ?>" method="post" enctype="multipart/form-data">
	<div><input type='<?php print $temp_text_field; ?>' placeholder='Title of File being uploaded' 
    class='input width-full' value='<?php r_f_g('name'); ?>' name='name<?php print $target; ?>' id='name<?php print $target; ?>'/></div>
    <input type="file" name="file<?php print $target; ?>" id="file<?php print $target; ?>" class="input-upload width-200">
    <span title="Click Here to Upload File" onclick="uploadFile<?php print $target; ?>()" class="button">
    Click Here to Upload File
    </span>
    <div>
    <progress id="progressBar<?php print $target; ?>" value="0" max="100" style="max-width:200px;">
    <div id="loaded_n_total<?php print $target; ?>"></div>
    </progress> 
  <span id="status<?php print $target; ?>"></span>
  </div>
</form>
</div>
<?php } ?>










<?php
if($upload_count>0){
if($only_one_needed==false){
print"<div><div class='bold'>Uploaded Attachments (".$upload_count."/".$max_no.")</div>";
}
$sql="SELECT * FROM `gallery` WHERE `object_id`='".$object['id']."' && `type`='$type' ".$v_sq." ORDER BY `id` ASC"; 
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result))  { 
	


$access="<a href='".$k['full_dir']."panel/gallery_edit.php?id=".$f['id']."' class='red' title='Edit Title' target='_blank'><i class='fa fa-edit'></i></a> 
&nbsp; &nbsp; 

<a href='".$k['full_f_dir']."include/uploader.php?id=".$id."&type=".$type."&target=".$target."&del=".$f['id']."#revoke' 
class='red' target='frame-".$target."' title='Delete'><i class='fa fa-trash'></i></a>"; 
if($f['file_type']=='0'){ $icon="<span class='gray3'><i class='fa fa-file'></i> Document</span>"; }
else if($f['file_type']=='1'){ $icon="<span class='gray3'><i class='fa fa-file-image-o'></i> Photo</span>"; }
else if($f['file_type']=='2'){ $icon="<span class='gray3'><i class='fa fa-file-video-o'></i> Video</span>"; }
else if($f['file_type']=='3'){ $icon="<span class='gray3'><i class='fa fa-file-audio-o'></i> Audio</span>"; }
else{ $icon="<span class='gray3'><i class='fa fa-paperclip'></i> ".strtoupper($f['extension'])."</span>"; }


if($f['file_type']=='1' && $only_one_needed==true){ $preview="<div class='center'><img src='".gallery_url($f['file'])."' style='max-width:90%;'/></div>";  }
else{ $preview=""; }

print"
<div class='up-down'>
<div class='divider'></div>
".$preview."
<div>
<a href='".gallery_url($f['file'])."' class='gray4 small' target='_blank'>
".$icon." ".$f['title']." 
</a>
<div class='float-right inline-block'>
".$access."
</div>
<div class='clear'></div>
</div>
</div>
";
	
 }
 print"</div>";
}
?>







<div class='clear'></div>


</div>
<!--End of canvas-->
<?php
bottomline:
$data=ob_get_contents();
ob_end_clean();



//use this option if delete is done, but new upload may not work again
if(isset($_GET['del'])){
?>
<script type="text/javascript">
var info="<?php print sn_dt_js($data); ?>"; 
parent.document.getElementById('feed-<?php print $target; ?>').innerHTML=info;
</script>
<?php } else { 

print $data;

}





?>
<!--/body>
</html-->