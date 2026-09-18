






<div class='clear'></div>
</div>
<!--End of layout holder-->







<!--footer starts-->
<div class='footer'>
<div class='footer-holder'>


<div class='footer-box'>
<a href='<?php print $k['full_dir']; ?>' class='title'>Home</a>
<a href='<?php print $k['full_dir']; ?>contact' class='link'>Contact Us</a>
<a href='<?php print $k['full_dir']; ?>about' class='link'>About Us</a>
<a href='<?php print $k['full_dir']; ?>blog' class='link'>Blog</a>
<?php if(is_logged()){ ?>
<a href='<?php print $k['full_dir']; ?>user/logout' class='link'>Logout</a>
<?php } ?>
</div>





<div class='footer-box'>
<span class='title'>Social Media & Sharing</span>

<?php if($settings['fb']!=''){ ?>
Follow Us on <a href='<?php print resn_json($settings['fb']); ?>' target='_blank' class='link'> <i class="fa fa-facebook"></i> </a>
<?php } ?>

<?php if($settings['tw']!=''){ ?>
<a href='<?php print resn_json($settings['tw']); ?>' target='_blank' class='link'> <i class="fa fa-twitter"></i> </a>
<?php } ?>

<?php if($settings['ig']!=''){ ?>
<a href='<?php print resn_json($settings['ig']); ?>' target='_blank' class='link'> <i class="fa fa-instagram"></i> </a>
<?php } ?>

<?php if($settings['lnk']!=''){ ?>
<a href='<?php print resn_json($settings['lnk']); ?>' target='_blank' class='link'> <i class="fa fa-linkedin"></i> </a>
<?php } ?>

<div class='up-down'><?php print share_social(); ?></div>
</div>





</div>
</div>
<!--/footer ends/-->



<!--Footest-->
<div class='footest'>
<div class='footest-holder'>
<a href='<?php print $k['full_dir']; ?>privacy' class='link'>Privacy Policy</a>
<a href='<?php print $k['full_dir']; ?>terms' class='link'>Terms of Service</a>
<span class='link'> &copy; <?php print date('Y'); ?> <?php print $k['site_name']; ?> - All Rights Reserved </span>
<a href='http://masterweb.com.ng' class='link'>Developed by Masterweb Solutions</a>
</div>
</div>
<!--//Footest ends-->










<?php
//Worker.... 
//Email Queue processing, Notification processing, Abandoned Session Processing...
//Delete Abandoned attachment and session

print"
<iframe src='".$k['full_f_dir']."include/worker.php?time=".$k['epoch']."' marginwidth='0' marginheight='0' frameborder='no' 
scrolling='no' allowTransparency='true' class='hidden' rel='nofollow' name='worker' id='worker'></iframe>";



print richtexteditor('real');   
?>



<!--Attach fancybox when the document is loaded-->
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>




<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5c925e16c37db86fcfcef64c/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

</body>
</html>