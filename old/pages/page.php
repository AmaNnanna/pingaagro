<?php 
include('dir.php');
$page_name="article";
$object_name='page';
$ann=auth_object_page($object_name);
if($ann['status']!='1'){ print"Page not published!"; exit; }

$meta_title=$ann['title'];
$meta_description="Checkout details of  ".$ann['title'];
$img=get_post_img($ann['id']);
$meta_img='';
if($img['status']==true){ $meta_img=$img['photo']; }

include($k['f_dir'].'include/header.php');

?>
<div class='layout-800'>


<p><h1 class='title title-font'><?php print $ann['title']; ?></h1></p>




<?php 
if($ann['show_time']=='1'){
print "<div class='gray smaller'>Updated ".fulltime($ann['lastepoch'])."</div>";
}


if($img['status']==true){ print"<div><img src='".$img['photo']."' style='max-height:500px;'/></div>"; }


print $ann['content'];
print backbreak($ann['embed_code']);



if($ann['id']=='2'){  //contact page... show other stuff needed for contact like map etc
print"<div><span class='bold blue'><i class='fa fa-phone'></i> Phone</span> ".$settings['phones']."</div>";
print"<div><span class='bold blue'><i class='fa fa-envelope'></i> Email</span> ".$settings['emails']."</div>";
print"<div><span class='bold blue'><i class='fa fa-map-marker'></i> Address</span> ".$settings['address']."</div>";

print"
<!--Map-->
<div>
<iframe src='".resn_json($settings['map'])."' width='100%' height='450' frameborder='0' style='border:0' allowfullscreen></iframe>
</div>
<!--//Map-->
";

contactform(); 
} //end of contact

if($ann['show_gallery']=='1'){
gallery_viewer($ann['id'],'4','article'.$ann['id']);
}


print"<p class='red bold'>SHARE WITH OTHERS</p>";
share_buttons();

?>











<?php
$disqus=resn_json($settings['disqus']);
if($disqus==''){ $disqus='masterwebng'; }


if($ann['show_comment']=='1'){
print"<p class='red bold'>ADD COMMENTS BELOW</p>"; ?>
<div id="disqus_thread"></div>
<script>
/**
*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

var disqus_config = function () {
this.page.url = "<?php print $k['full_dir']."page-".$ann['id']; ?>";  // Replace PAGE_URL with your page's canonical URL variable
this.page.identifier = "page.<?php print $ann['id']; ?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
};

(function() { // DON'T EDIT BELOW THIS LINE
var d = document, s = d.createElement('script');
s.src = 'https://<?php print $disqus; ?>.disqus.com/embed.js';
s.setAttribute('data-timestamp', +new Date());
(d.head || d.body).appendChild(s);
})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<?php } ?>                         







<?php
if($ann['show_related']=='1'){
	
//articles related 
print"<div class='blue bold'>Related Pages</div>";
$query="SELECT * FROM `page` WHERE `status`='1' && `id`!='".$ann['id']."' && `category`='".$ann['category']."' ORDER BY `lastepoch` DESC ";
$sql=$query." LIMIT 0 , 10 ";
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result)){ 
flat_post($f);
}

}//end of related
?>



</div>
<?php include($k['f_dir'].'include/footer.php'); ?>