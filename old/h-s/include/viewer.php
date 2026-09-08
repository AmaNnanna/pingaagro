<?php
include('dir.php');
$page_name="index";
$token=hourly_token();
?>
<html>
<head>
<title>Gallery Viewer</title>
<meta charset="utf-8"/>
<meta http-equiv="Content-Type" content="text/html"/>
</head>
<body>
<?php ob_start(); ?>
<div>
<?php



//these 3 are very compulsory
$id=get_get('id');
$type=get_get('type');
$target=get_get('target');
if($id=='' || $type=='' || $target==''){ display_e_m("Some tokens are missing"); goto bottomline;  }

$the_title=get_get('title'); //if set, show this as title of document

$v_sq="";
//we can decide to show only gallery of certain types only... E.g 0 Documents, 1 Photos, 2 Videos differently
$file_type=get_get('file_type');
if($file_type!=''){ $v_sq=$v_sq." && `file_type`='$file_type' "; }


//For temporal checks of permission to view for those whom are logged out
if(!(isset($m_info))){ $m_info=array('id'=>'0','admin'=>'0'); }
//default sort order=
$sort_order="ASC";


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
	//hide from all except owner
	$public='0';
	}
} else if($type=='2'){ //profile pics
	if(!(this_object_exists($id,'account'))){ display_e_m("Account does not exist"); goto bottomline; } else { 
	$object=get_object_info($id,'account');
	$account=$object;
	$ownership_check=$object['id'];
	//make public to all
	$public='1';
	}
} else if($type=='3'){ //Post Cover
	if(!(this_object_exists($id,'page'))){ display_e_m("Post does not exist"); goto bottomline; } else { 
	$object=get_object_info($id,'page');
	$ownership_check=$object['user_id'];
	$public='1';
	}
} else if($type=='4'){ //Post Gallery
	if(!(this_object_exists($id,'page'))){ display_e_m("Post does not exist"); goto bottomline; } else { 
	$object=get_object_info($id,'page');
	$ownership_check=$object['user_id'];
	$public='1';
	}
} 





//Check permission, in case the object is disabled and you lack necessary permission
if($ownership_check==$m_info['id'] || has_basic_permission($m_info['admin']) ){  }
else if($public=='1'){ }
else { display_e_m("You do not have permission to view some content of this page"); goto bottomline; }


















//0 Documents, 1 Photos, 2 Videos, 3 Audio differently

$upload_count=gallery_count($id,$type,$file_type);
$sql="SELECT * FROM `gallery` WHERE `object_id`='".$object['id']."' && `type`='$type' ".$v_sq." ORDER BY `id` ".$sort_order." "; 
$result=query_sql($sql);
if($upload_count>0){ //there are attachments now. Now decide how best to show them
	
if($the_title!=''){ print"<div class='gallery-type-title'>".$the_title."</div>"; }





while($f=mysqli_fetch_assoc($result))  { gallery_display($f); }
















} //END OF there are attachments now. Now decide how best to show them




?>







<div class='clear'></div>


</div>
<!--End of canvas-->
<?php
bottomline:
$data=ob_get_contents();
ob_end_clean();




?>
<script type="text/javascript">
var info="<?php print sn_dt_js($data); ?>"; 
parent.document.getElementById('viewfeed-<?php print $target; ?>').innerHTML=info;
</script>
</body>
</html>