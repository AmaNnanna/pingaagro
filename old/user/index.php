<?php 
include('dir.php');
$page_name="user";




//CRITERIA FOR SEARCH

//From a specific search keyword
$q=get_get('q');
$q_q="";
$sort_query="";
if($q!=''){	
$q_q=" && ( (MATCH(`search`) AGAINST('".$q."')) || `search` LIKE '%".(str_replace(' ','%%',$q))."%'  )  "; 
$sort_query=" MATCH(`search`) AGAINST('".$q."') DESC, ";
}


//From Type... male or female
$type=get_get('type');
$q_type="";
if($type!=''){	
$q_type=" && `gender`='".$type."' "; 
}






$meta_title=$q." ".$type." Members";
$meta_description="Browse our members";
$meta_img="";
include($k['f_dir'].'include/header.php');



?>

















<h1 class='title title-font'><?php print $q; ?> Members</h1>






<form action='<?php print $k['full_dir']; ?>user/' method='get'>

<input type='text' value='<?php print $q; ?>' name='q' placeholder='search members with keyword' title='Keyword' class='input'/>


<select name='type' class='input'>
<option value=''>--All Members--</option>
<option value='Male'<?php select_button_default($type,'Male'); ?>>Male</option>
<option value='Female'<?php select_button_default($type,'Female'); ?>>Female</option>
</select>


<input type='submit' value='Go' class='submit' name='go'>
</form>















<?php

$start=get_page_count();
$range=100;
$page=$k['full_dir']."user/?q=".$q."&type=".$type."&start=";




$query="SELECT * FROM `account` WHERE `status`='1' 
".$q_q.$q_type."  ORDER BY ".$sort_query." `follower` DESC,`view` DESC, `lastepoch` DESC, `id` DESC  ";



//show result count
$result=query_sql($query);
$counter=mysqli_num_rows($result);
print"<div class='up-down gray small'>".$counter." Results available</div>";

$sql=$query." LIMIT $start , $range ";
$result=query_sql($sql);
if(mysqli_num_rows($result)==0){ display_t_m("Invite the person you searched for to join!"); }

while($f=mysqli_fetch_assoc($result)){ 

profile_mini($f);

}





print"<div class='clear'></div>";
print"<p>&nbsp;</p>";
//please never add limit to query
show_next_button($start,$range,$page,$query,'','');	
?>



<p>&nbsp;</p>















<?php include($k['f_dir'].'include/footer.php'); ?>