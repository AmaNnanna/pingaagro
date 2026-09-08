<?php 
include('dir.php');
$page_name="posts";



//CRITERIA FOR SEARCH

//From a specific search keyword
$q=get_get('q');
$q_q="";
$sort_query="";
if($q!=''){	
$q_q=" && ( (MATCH(`title`) AGAINST('".$q."')) || `title` LIKE '%".(str_replace(' ','%%',$q))."%'  )  "; 
$sort_query=" MATCH(`title`) AGAINST('".$q."') DESC, ";
}





//From a specific Category
$cat=get_get('cat');
$q_cat="";
if($cat!='' && this_object_exists($cat,'category') ){	
$q_cat=" && `category` = '".$cat."' "; 
$category=get_object_info($cat,'category');
} else if($cat!='' && this_object_exists($cat,'category','slug') ){
$category=get_object_info($cat,'category','slug');
$cat=$category['id'];
$q_cat=" && `category` = '".$cat."' "; 
}










$search_title="";
if(isset($category)){
$search_title.=$category['name']." ";	
} else{ $search_title=" Posts "; }



if($q!=''){ $search_title=$q." ".$search_title;	 }



$meta_title=$search_title;
$meta_description="Browse pages from ".$search_title;
$meta_img="";
include($k['f_dir'].'include/header.php');



?>
<div class='layout-600'>




<?php if($cat==10){ } else{ ?>
<div class='tab center'>
<h1 class='title title-font vertical-middle'><?php print $search_title; ?></h1>

<form action='<?php print $k['full_dir']; ?>pages/' method='get' class='inline-block vertical-middle'>

<input type='text' value='<?php print $q; ?>' name='q' placeholder='search with keyword' title='Keyword' class='input'/>


<select name='cat' class='input' title='You can use a category to filter what you see'>
<option value=''>--All Categories--</option>
<?php cat_drop($cat,false); ?>
</select>



<input type='submit' value='Go' class='submit' name='go'>
</form>
</div>
<?php } ?>





<?php
$start=get_page_count();
$range=100;
$page=$k['full_dir']."pages/?q=".$q."&cat=".$cat."&start=";




if( isset($category) &&  $category['desc']!=''){  //category data
display_t_m("<b class='title'>".$category['name']."</b> <div>".$category['desc']."</div><br class='clear'/>");
}

?>
</div>














<div class='layout-full'>
<div class='center'>
<?php

$query="SELECT * FROM `page` WHERE `status`='1' ".$q_q.$q_cat."  ORDER BY ".$sort_query." `lastepoch` DESC  ";

//show result count
$result=query_sql($query);
$counter=mysqli_num_rows($result);
print"<div class='up-down gray small'>".$counter." Pages available</div>";

$sql=$query." LIMIT $start , $range ";
$result=query_sql($sql);


if(mysqli_num_rows($result)==0){ print"<div>No result for this. Try something else</div>"; }


while($f=mysqli_fetch_assoc($result)){ 
grid_post($f); 
}





print"<div class='clear'></div>";
print"<p>&nbsp;</p>";
//please never add limit to query
show_next_button($start,$range,$page,$query,'','');	
?>



<p>&nbsp;</p>

</div>
</div>









<?php include($k['f_dir'].'include/footer.php'); ?>