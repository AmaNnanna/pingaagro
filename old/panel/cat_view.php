<?php 
include('dir.php');
$page_name="category";
user_only();
$meta_title="Categories";
$meta_description="View all categories";
$meta_img="";
include($k['f_dir'].'include/header.php');
verified_user_only();
if(!has_basic_permission($m_info['admin'])){ exit; }



//CRITERIA FOR SEARCH

//From a specific ID
$id=get_get('id');
$q_id="";
if($id!='' && this_object_exists($id,'category') ){	
$q_id=" && `id`='$id' "; }


//From a specific search keyword
$q=get_get('q');
$q_q="";
if($q!=''){	
$q_q=" && ( (MATCH(`search`) AGAINST('".$q."')) || `search` LIKE '%".(str_replace(' ','%%',$q))."%'  )  "; }


//From status
$status=get_get('status');
$q_status="";
if($status!=''){	
$q_status=" && `status`='$status' "; }



?>
















<div class='layout-600'>
<h1 class='title'> Categories</h1> 

<div class='right'>
<a href='<?php print $k['full_dir']; ?>panel/cat_new.php' class='gray small'>New Category</a>
</div>




<form action='#' method='get'>



<input type='number' value='<?php print $id; ?>' name='id' placeholder='Cat ID' title='Cat ID'/>

<input type='text' value='<?php print $q; ?>' name='q' placeholder='Keyword' title='Keyword'/>

<select name='status'>
<option value=''>--Status--</option>
<option value='0'<?php select_button_default($status,'0'); ?>>Trashed</option>
<option value='1'<?php select_button_default($status,'1'); ?>>Published</option>
</select>

<div class='divider'></div>

<input type='submit' value='Go' class='submit' name='go'>
</form>



<?php display_w_m("You can find all categories here. Use the available options to sort. Click on any of them to manage.  
				  Categories can be created on demand when categorizing items."); ?>

















<?php

$start=get_page_count();
$range=100;
$page=$k['full_dir']."panel/cat_view.php?id=".$id."&q=".$q."&status=".$status."&start=";



$query="SELECT * FROM `category` WHERE `id`!='' ".$q_id.$q_q.$q_status." ORDER BY `name` ASC ";

//show result count
$result=query_sql($query);
$counter=mysqli_num_rows($result);
print"<div class='space larger bold red'>".$counter." Results for this search parameters</div>";

$sql=$query." LIMIT $start , $range ";
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result)){ 

admin_cat($f,true,true);

}





print"<div class='clear'></div>";
print"<p>&nbsp;</p>";
//please never add limit to query
show_next_button($start,$range,$page,$query,'','');	
?>



<p>&nbsp;</p>













</div>
<?php include($k['f_dir'].'include/footer.php'); ?>