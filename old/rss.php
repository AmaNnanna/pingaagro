<?php header("Content-Type: application/rss+xml; charset=ISO-8859-1");
include('dir.php');
print'<?xml version="1.0" encoding="ISO-8859-1" ?>'; ?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
<atom:link href="<?php print $k['full_dir']; ?>rss.xml" rel="self" type="application/rss+xml" />

 <title><?php print $k['site_name']; ?></title>
  <link><?php print $k['full_dir']; ?></link>
  <description><?php print $k['site_desc']; ?></description>
  <category>Places</category>
  <image>
  <url><?php print $k['cdn']; ?>css/logo.png</url>
  <title><?php print $k['site_name']; ?></title>
  <link><?php print $k['full_dir']; ?></link>
</image>
<?php 

$source="rssfeed";
$sql="SELECT * FROM `page` WHERE `status`='1'  ORDER BY `lastepoch` DESC LIMIT 0, 20 ";
$result=query_sql($sql);
$no=0;
while($f=mysqli_fetch_assoc($result)){
	
	
	$title=$f['title'];
	$time=$f['lastepoch']; $url=$k['full_dir']."page-".$f['id']."?source=".$source;
	print"
	<item>
    <title>".$f['title']."</title>
    <link>".$url."</link>
    <description>".str_replace(' & ',' and ',html_entity_decode(substr($title,0,400)))."</description>
	<comments>".$url."</comments>
	<pubDate>".gmdate('r', $time)."</pubDate>
	<guid>".$url."&amp;guid=".$time."</guid>
	<author>".$k['site_email']." (".$k['website'].")</author>
    </item>
	";
	
	
}

?>  
</channel>
</rss>