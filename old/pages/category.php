<?php 
include('dir.php');
$page_name="category";

//CRITERIA FOR SEARCH

//From a specific search keyword
$q=get_get('q');
$q_q="";
$sort_query="";
if($q!=''){	
$q_q=" && ( (MATCH(`search`) AGAINST('".$q."')) || `search` LIKE '%".(str_replace(' ','%%',$q))."%'  || `name` LIKE '%".(str_replace(' ','%%',$q))."%'  )  "; 
$sort_query=" MATCH(`search`) AGAINST('".$q."') DESC, ";
}






$meta_title="Sitemap";
$meta_description="Browse our list of categories";
$meta_img='';
include($k['f_dir'].'include/header.php');



?>
<div class='layout-600'>
<div>












<p/>
<!--form action='<?php print $k['full_dir']; ?>pages/category.php' method='get'>
<div class='inline-block vertical-middle'>
<input type='text' value='<?php print $q; ?>' name='q' placeholder='category name only' title='Keyword' class='input'/>
<input type='submit' value='Search' class='submit' name='go'>
</div>
</form-->




<div class='title-font'>Sitemap</div>

<ul>
<?php

$start=get_page_count();
$range=100;
$page=$k['full_dir']."pages/category.php?q=".$q."&start=";



$query="SELECT * FROM `category` WHERE `status`='1' ".$q_q." ORDER BY ".$sort_query." `order` DESC, `name` ASC  ";
$sql=$query." LIMIT $start , $range ";
$result=query_sql($sql);
while($f=mysqli_fetch_assoc($result)){ 

	print"<li><a href='".$k['full_dir']."category/".$f['slug']."' class='title'>".$f['name']."</a></li>";

}




print"</ul><div class='clear'></div>";
print"<p>&nbsp;</p>";
//please never add limit to query
show_next_button($start,$range,$page,$query,'','');	
?>



<p>&nbsp;</p>













</div>
</div>
<?php include($k['f_dir'].'include/footer.php'); ?>