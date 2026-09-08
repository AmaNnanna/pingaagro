<?php header("Content-Type: application/xml; charset=ISO-8859-1");
include('dir.php');
print'<?xml version="1.0" encoding="ISO-8859-1" ?>'; ?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"

         xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"

         xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

   <url>

      <loc><?php print $k['full_dir']; ?></loc>


      <changefreq>daily</changefreq>

      <priority>1.0</priority>

   </url>


    <url>

      <loc><?php print $k['full_dir']; ?>category/</loc>


      <changefreq>daily</changefreq>

      <priority>0.8</priority>

   </url>

   
     <url>

      <loc><?php print $k['full_dir']; ?>about</loc>


      <changefreq>monthly</changefreq>

      <priority>0.5</priority>

   </url>
   
     <url>

      <loc><?php print $k['full_dir']; ?>contact</loc>


      <changefreq>monthly</changefreq>

      <priority>0.4</priority>

   </url>
   
    <url>

      <loc><?php print $k['full_dir']; ?>pages</loc>


      <changefreq>weekly</changefreq>

      <priority>0.3</priority>

   </url>  
    
   
    <url>

      <loc><?php print $k['full_dir']; ?>terms</loc>


      <changefreq>monthly</changefreq>

      <priority>0.2</priority>

   </url>
   
    



</urlset>