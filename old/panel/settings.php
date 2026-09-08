<?php 
include('dir.php');
$page_name="admin";
user_only();
$meta_title="Settings";
$meta_description="Edit General Site Settings";
$meta_img="";
include($k['f_dir'].'include/header.php');

verified_user_only();
if(!has_super_permission($m_info['admin'])){ exit; }
?>
<div class='layout-600'>











<h1 class='title title-font'>Edit General Settings</h1>







<?php 
//DATA COLLECTION
if(isset($_POST['update']) ){

//sanitize the data
if(isset($_POST['us'])){ $us='1'; }else{ $us='0'; }
if(isset($_POST['home_slide'])){ $home_slide='1'; }else{ $home_slide='0'; }
if(isset($_POST['home_slide_text'])){ $home_slide_text='1'; }else{ $home_slide_text='0'; }
if(isset($_POST['flash'])){ $flash='1'; }else{ $flash='0'; }

$flash_text=sn_dt($_POST['flash_text']);
$home_text=remove_slash($_POST['home_text']);
$middle_text=remove_slash($_POST['middle_text']);
$yt_home=sn_dt($_POST['yt_home']);
$intro=sn_dt($_POST['intro']);
$phones=sn_dt($_POST['phones']);
$emails=sn_dt($_POST['emails']);
$address=sn_dt($_POST['address']);
$map=sn_dt($_POST['map']);
$menu=sn_dt($_POST['menu']);
$fb=sn_dt($_POST['fb']);
$tw=sn_dt($_POST['tw']);
$ig=sn_dt($_POST['ig']);
$lnk=sn_dt($_POST['lnk']);
$disqus=sn_dt($_POST['disqus']);


$error_message='';

//sanitize done, now time to insert...
if($error_message==''){


$settings=array(
				
"user"=>$us,"home_slide_text"=>$home_slide_text,"home_slide"=>$home_slide,
"yt_home"=>$yt_home,"flash"=>$flash,"flash_text"=>sn_json($flash_text),
"intro"=>sn_json($intro),"phones"=>sn_json($phones),"emails"=>sn_json($emails),
"address"=>sn_json($address),"map"=>sn_json($map),"menu"=>sn_json($menu),"fb"=>sn_json($fb),"tw"=>sn_json($tw),"ig"=>sn_json($ig),"lnk"=>sn_json($lnk),
"disqus"=>sn_json($disqus)

);





$json=json_encode($settings);

$sql="UPDATE `options` SET `value`='$json',`v1`='$home_text',`v2`='$middle_text' WHERE `id`='1' ";
$result=query_sql($sql);


$update_success=true;

// alert me now of the success
$msg="Settings were updated successfully";
display_s_m($msg);



} else { // there were error messages
display_e_m($error_message);
}
}
?>








<?php $settings=get_settings(); ?>







<form action='#' method='post'>








<div class='white-box'>
<div class='bold blue'>Admin Membership</div>


<div class='padding'>
<label class='check'>
<input type="checkbox" class='checkbox' name='us' <?php print check_box_default($settings['user']); ?>> 
Enable Admin Registration <span class='smaller gray'>This will make it possible for you to register new admins via <b>website/join</b></span>
</label> 
</div>


</div>























<div class='white-box'>
<div class='bold blue'>Homepage</div>


<div class='padding'>
<label class='check'>
<input type="checkbox" class='checkbox' name='home_slide' <?php print check_box_default($settings['home_slide']); ?>> 
Enable Gallery Sliders <span class='smaller gray'>This enables a sliding gallery on the homepage which can be used for advertisements</span>
</label> 
</div>



<div class='padding'>
<label class='check'>
<input type="checkbox" class='checkbox' name='home_slide_text' <?php print check_box_default($settings['home_slide_text']); ?>> 
Enable Text on Gallery Sliders <span class='smaller gray'>This enables a sliding text in the gallery on the homepage</span>
</label> 
</div>





<div class='padding'>
Homepage Intro Title <span class='small gray'>Title of Text on Homepage</span> <br/>
<input type='text' placeholder='Home Title' class='input width-full' value='<?php print resn_json($settings['intro']); ?>' name='intro'/>
</div>


<div class='padding'>
Homepage Text <span class='small gray'>This text is displayed on the homepage, after the intro text</span> <br/>
<textarea placeholder='Intro about your website' class='ckeditor' 
name='home_text'><?php print $settings['home_text']; ?></textarea>
<div class='small red'>Please keep as brief as possible</div>
</div>





<div class='padding'>
Homepage Middle Text <span class='small gray'>Use this to showcase short text such as quick mission/vision or announcement</span> <br/>
<textarea placeholder='Middle Text' class='ckeditor' 
name='middle_text'><?php print $settings['middle_text']; ?></textarea>
<div class='small red'>Please keep as brief as possible</div>
</div>




<div class='padding'>
YouTube Video for Homepage <span class='small gray'>Leave empty to remove Video</span> <br/>
<input type='text' placeholder='Video starts with https://' class='input width-full' value='<?php print resn_json($settings['yt_home']); ?>' name='yt_home'/>
</div>







</div>














<div class='white-box'>
<div class='bold blue'>Contact Information</div>
<div class='small gray'>Any additional contact information can be added via contact page</div>



<div class='padding'>
Phones <span class='small gray'>Separate multiple phones with comma</span> <br/>
<input type='text' placeholder='Phones' class='input width-full' value='<?php print resn_json($settings['phones']); ?>' name='phones'/>
</div>

<div class='padding'>
Emails <span class='small gray'>Separate multiple emails with comma</span> <br/>
<input type='text' placeholder='Emails' class='input width-full' value='<?php print resn_json($settings['emails']); ?>' name='emails'/>
</div>

<div class='padding'>
Address <span class='small gray'>Main Address</span> <br/>
<input type='text' placeholder='Main address' class='input width-full' value='<?php print resn_json($settings['address']); ?>' name='address'/>
</div>

<div class='padding'>
Google Map Embed Link <span class='small gray'>Only the link for map plotting</span> <br/>
<input type='text' placeholder='Map link' class='input width-full' value='<?php print resn_json($settings['map']); ?>' name='map'/>
</div>



<div class='padding'>
Facebook Page URL <span class='small gray'>Leave empty to remove Facebook</span> <br/>
<input type='text' placeholder='FB url starts with https://' class='input width-full' value='<?php print resn_json($settings['fb']); ?>' name='fb'/>
</div>

<div class='padding'>
Twitter Page URL <span class='small gray'>Leave empty to remove Twitter</span> <br/>
<input type='text' placeholder='TW url starts with https://' class='input width-full' value='<?php print resn_json($settings['tw']); ?>' name='tw'/>
</div>

<div class='padding'>
Instagram Page URL <span class='small gray'>Leave empty to remove Instagram</span> <br/>
<input type='text' placeholder='IG url starts with https://' class='input width-full' value='<?php print resn_json($settings['ig']); ?>' name='ig'/>
</div>

<div class='padding'>
LinkedIn Page URL <span class='small gray'>Leave empty to remove LinkedIn</span> <br/>
<input type='text' placeholder='LinkedIn url starts with https://' class='input width-full' value='<?php print resn_json($settings['lnk']); ?>' name='lnk'/>
</div>


</div>










<div class='white-box'>
<div class='bold blue'>Flash</div>



<div class='padding'>
<label class='check'>
<input type="checkbox" class='checkbox' name='flash' <?php print check_box_default($settings['flash']); ?>> 
Enable Flash News <span class='smaller gray'>Flash can be used to display most important information on top or just quick contact information</span>
</label> 
</div>



<div class='padding'>
Flash Message <span class='small gray'>Pro Tip: Use double dash (--) to separate link and flash message. 
Message -- Link. If no link is found, only flash message is displayed</span> <br/>
<textarea placeholder='E.g Phone +23456669974747 -- http://fb.me/masterwebng' class='textarea width-full' 
name='flash_text'><?php print backbreak(resn_json($settings['flash_text'])); ?></textarea>
<div class='small red'>Please keep as brief as possible - When there is no announcement, use this to display Quick contact info</div>
</div>




</div>







<div class='white-box'>
<div class='bold blue'>Others</div>
<?php display_w_m("Feel free to ignore this area"); ?>


<div class='padding'>
Menu Link Builder <span class='small gray'>Each menu on a new line. Title first, comma, then link. E.g Home,<?php print $k['full_dir']; ?></span> <br/>
<textarea placeholder='E.g Contact Us,<?php print $k['full_dir']; ?>contact' class='textarea width-full' 
name='menu'><?php print backbreak(resn_json($settings['menu'])); ?></textarea>
<div class='small red'>Please ignore this area if you do not know how to use it</div>
</div>


<div class='padding'>
Disqus ID <span class='small gray'>This is the subdomain keyword from Disqus that powers comments on this website</span> <br/>
<input type='text' placeholder='E.g dorotv' class='input width-full' value='<?php print resn_json($settings['disqus']); ?>' name='disqus'/>
</div>



</div>












<div class='padding'>
<input type='submit' value='Save Settings' class='submit' name='update'>
</div>
</form>









</div>

<?php 
include($k['f_dir'].'include/footer.php');
?>