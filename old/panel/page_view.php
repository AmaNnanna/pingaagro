<?php 
include('dir.php');
$page_name="article";
user_only();
$meta_title="Article";
$meta_description="View all articles";
$meta_img="";
include($k['f_dir'].'include/header.php');
if(!has_basic_permission($m_info['admin'])){ exit; }


//Specific Object that shall be printed
$search_info="";

//CRITERIA FOR SEARCH

//From a specific ID
$id=get_get('id');
$q_id="";
if($id!='' && this_object_exists($id,'page') ){	
$q_id=" && `id`='$id' "; }



//From a specific userID
$user_id=get_get('user_id');
$q_user_id="";
if($user_id!='' && this_object_exists($user_id,'account') ){	
$q_user_id=" && `user_id`='$user_id' "; }


//From a specific search keyword
$q=get_get('q');
$q_q="";
if($q!=''){	
$q_q=" && ( `title` LIKE '%".(str_replace(' ','%%',$q))."%') "; }


//From status
$status=get_get('status');
$q_status="";
if($status!=''){	
$q_status=" && `status`='$status' "; }




//From a specific Category
$category=get_get('category');
$q_category="";
if($category!='' && this_object_exists($category,'category') ){	
$q_category=" && `category` = '".$category."' "; }


?>
<div class='layout-800'>














<h1 class='title'>Pages/Articles</h1>





<?php print $search_info; ?>
<form action='#' method='get'>


<input type='number' value='<?php print $id; ?>' name='id' placeholder='Article ID' title='Article ID'/>

<input type='number' value='<?php print $user_id; ?>' name='user_id' placeholder='User ID' title='User ID'/>

<input type='text' value='<?php print $q; ?>' name='q' placeholder='Keyword' title='Keyword'/>


<select name='status'>
<option value=''>--Status--</option>
<option value='0'<?php select_button_default($status,'0'); ?>>Draft</option>
<option value='1'<?php select_button_default($status,'1'); ?>>Published</option>
<option value='1'<?php select_button_default($status,'2'); ?>>Trashed</option>
</select>



<select name='category'>
<option value=''>--All Categories--</option>
<?php cat_drop($category,false); ?>
</select>


<div class='divider'></div>

<input type='submit' value='Go' class='submit' name='go'>
</form>



<?php display_w_m("You can find all articles here. Use the available options to sort. Click on any of them to manage"); ?>

















<?php

$start=get_page_count();
$range=20;
$page=$k['full_dir']."panel/page_view.php?id=".$id."&q=".$q."&status=".$status."&category=".$category."&user_id=".$user_id."&start=";


$query="SELECT * FROM `page` WHERE `id`!='' ".$q_id.$q_q.$q_status.$q_category.$q_user_id." ORDER BY `lastepoch` DESC ";
$sql=$query." LIMIT $start , $range ";
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result)){ admin_page($f); }





print"<div class='clear'></div>";
print"<p>&nbsp;</p>";
//please never add limit to query
show_next_button($start,$range,$page,$query,'','');	
?>



<p>&nbsp;</p>










</div>
<?php include($k['f_dir'].'include/footer.php'); ?>