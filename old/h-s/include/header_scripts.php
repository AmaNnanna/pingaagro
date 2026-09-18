<?php 
//token can be anything... change only when you wish new link for favicon, photo or icon... when using defaults
$k['token']=4;
$temp_icon=get_photo_img('icon');
$temp_logo=get_photo_img('logo');
$temp_favicon=get_photo_img('favicon');

//If not declared, make them empty
if(!(isset($meta_title))){$meta_title="";}
if(!(isset($meta_description))){$meta_description="";}
if(!(isset($meta_img))){$meta_img="";}

//If empty, please use these
if($meta_title==''){$meta_title="Welcome to ".$k['site_name'];}
if($meta_description==''){$meta_description=$k['site_desc'];}
if($meta_img==''){$meta_img=$temp_icon['photo'];}

?>
<title>
<?php print $meta_title; ?>
</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<meta charset="utf-8"/>
<meta http-equiv="Content-Type" content="text/html"/>
<meta property="og:site_name" content="<?php print $k['site_name']; ?>"/>
<meta property="og:title" content="<?php print $meta_title; ?>"/>
<meta name="twitter:title" content="<?php print $meta_title; ?>">
<meta property="og:type" content="article"/>
<meta name="twitter:card" content="summary_large_image">
<meta property="og:description" content="<?php print $meta_description; ?>"/>
<meta name="description" content="<?php print $meta_description; ?>"/>
<meta name="twitter:description" content="<?php print $meta_description; ?>">
<meta name="keyword" content="<?php if(isset($meta_keywords)){print $meta_keywords.",";} ?>"/>
<meta property="og:url" content="<?php print $k['protocol'].$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
<meta name="twitter:url" content="<?php print $k['protocol'].$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>">
<meta property="og:image" content="<?php print $meta_img; ?>"/>
<meta name="twitter:image:src" content="<?php print $meta_img; ?>">
<meta name="twitter:site" content="@<?php print $k['twitter']; ?>">
<meta name="twitter:creator" content="@<?php print $k['twitter']; ?>">
<link rel="image_src" type="image/jpeg" href="<?php print $meta_img; ?>" />
<link rel="apple-touch-icon" href="<?php print $temp_favicon['photo']; ?>">
<link rel="icon" href="<?php print $temp_favicon['photo']; ?>">
<link rel="shortcut icon" href="<?php print $temp_favicon['photo']; ?>"/>


<link href="https://fonts.googleapis.com/css?family=Oswald|Gotu|Staatliches" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<?php css_styles(); ?>

<script src="<?php print $k['cdn']; ?>js/jquery.js"></script>
	
    
    
  
<script type="text/javascript">

$(document).ready(function(){
  $(".header-search").click(function(){
    $(".header-search-area").toggle(500);
  });
});

$(document).ready(function(){
  $(".header-close-search-btn").click(function(){
	$(".header-search-area").hide(200);
  });
});


$(document).ready(function(){
  $(".header-menu-btn").click(function(){
	$(".header-menu-area").show(200);
	$(".header-close-menu-btn").show(200);
	$(".header-search-area").hide(200);
	$(".header-menu-btn").hide(200);
  });
});

$(document).ready(function(){
  $(".header-close-menu-btn").click(function(){
	$(".header-menu-area").hide(200);
	$(".header-menu-btn").show(200);
  });
});

$(document).ready(function(){
  $("#btn1").click(function(){
    $("#area1").toggle(200);
  });
});




function pop_action(name){
	var div_id = name;
	div_id_c="#"+div_id+"-area";
	
 	 $(document).ready(function(){
 	   $(div_id_c).toggle(500);
	});
	 
			}
						
			
			
	function pop_close(name){
	var div_id = name;
	div_id_c="#"+div_id+"-area";
	
 	 $(document).ready(function(){
 	   $(div_id_c).hide(500);
	});
	 
			}
 
//specially meant for menu so that other menu can close when new one is clicked on
function pop_action_menu(name){
	var div_id = name;
	div_id_c="#"+div_id+"-area";
	var div_status=$(div_id_c).css('display');
 	 $(document).ready(function(){
								
	   $('.header-cat-flyer').hide(500);
	 if( div_status=== 'none') {
		 $(div_id_c).show(500);
	} else { $(div_id_c).hide(500); }
	
	});
			}
</script>







<!--For email livesearch-->
<script type="text/javascript">
<!--
function showEmailavail(str)
{
if (str.length==0)
  { 
  document.getElementById("live-email").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("live-email").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","<?php print $k['full_f_dir']; ?>include/frame-live-email.php?q="+str,true);
xmlhttp.send();
}

//-->
</script>








<?php if($page_name=='index_home_main'){ //this is needed only where wow_slider is called ?>
    <!-- Start WOWSlider.com HEAD section of your page -->
	<link rel="stylesheet" type="text/css" href="<?php print $k['cdn']; ?>slide_wow2/engine1/style.css" />
	<script type="text/javascript" src="<?php print $k['cdn']; ?>slide_wow2/engine1/jquery.js"></script>
	<!-- End WOWSlider.com HEAD section -->
<?php } ?>





<?php
//with page name set as admin, it is automatically checked for security in header scripts...
//display analytics cos I wouldn't wanna track admin pages.
if(strpos($k['my_url'],$k['website'].'/panel')){ 

user_only();
if(!has_manage_permission($m_info['admin'])){ exit; }

} else {
?>

<!--Analytics go here-->
<?php print $k['analytics']; ?>
<!--Analytics-->
<!--translate-->
<meta name="google-translate-customization" content="b1219b8cd46356dd-b842f5820fd7dae8-gb962734c5ee1db6f-e"></meta>
<!--translate-->



<?php } ?>






<!--Linkify-->
<script src="<?php print $k['cdn']; ?>js/linkify.min.js"></script>
<script src="<?php print $k['cdn']; ?>js/linkify-jquery.min.js"></script>
<!--Linkify-->












<!-- Add jQuery library for gallery pop-up -->

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="<?php print $k['cdn']; ?>fancybox-2.1.7/lib/jquery.mousewheel.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="<?php print $k['cdn']; ?>fancybox-2.1.7/source/jquery.fancybox.css?v=2.1.7" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print $k['cdn']; ?>fancybox-2.1.7/source/jquery.fancybox.pack.js?v=2.1.7"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="<?php print $k['cdn']; ?>fancybox-2.1.7/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print $k['cdn']; ?>fancybox-2.1.7/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="<?php print $k['cdn']; ?>fancybox-2.1.7/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<link rel="stylesheet" href="<?php print $k['cdn']; ?>fancybox-2.1.7/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="<?php print $k['cdn']; ?>fancybox-2.1.7/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<!-- Add jQuery library for gallery pop-up -->


