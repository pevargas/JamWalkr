<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?>
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
	<a class="brand" href="./index.php">JamWalkr</a>
	<ul class="nav">
	  <li><a href="./index.php"><i class="icon-home icon-white"></i></a></li>
	  <li class="active"><a href="./lfm.php"><i class="icon-music icon-white"></i></a></li>
	  <li><a href="./8tracks.php"><i class="icon-headphones icon-white"></i></a></li>
	  <li><a href="./map.php"><i class="icon-map-marker icon-white"></i></a></li>
	  <li><a href="./database.php"><i class="icon-hdd icon-white"></i></a></li>
	</ul>
      </div>
    </div>
  </div>
  
  <div class="container-fluid" style="margin-top: 50px;">
    <div class="row-fluid">
      <div class="span3 visible-desktop">
      	<ul class="nav nav-pills nav-stacked">
      	  <li><a href="./index.php"><i class="icon-home"></i> Home</a></li>
      	  <li class="active"><a href="./lfm.php"><i class="icon-music"></i> Last.fm API</a></li>
      	  <li><a href="./8tracks.php"><i class="icon-headphones"></i> 8Tracks API</a></li>
      	  <li><a href="./map.php"><i class="icon-map-marker"></i> Google Maps API</a></li>
      	  <li><a href="./database.php"><i class="icon-hdd"></i> MySQL Database</a></li>
      	</ul>
      </div>
      <div class="span9">
      	<h1>Last.fm API</h1>
      	<?php
      	   # var_dump(curl_version());
      	   $lfmmethod = "chart.getTopArtists";
      	   $url = $lfmbase . "?method=" . $lfmmethod . $lfmkey;
      	   echo "<p class='lead'>" . $lfmmethod . "</p>";	   

      	   $response = get_page($url);
      	   $xml = new SimpleXMLElement($response);
      	   
      	   $data = $xml->artists->artist; 
      	   for ($i = 0; $i < sizeof($data); $i++) {  
      	     $name = (string) $data[$i]->name;
      	     $link = (string) $data[$i]->url;
      	     $img  = $data[$i]->children();
      	     $img  = (string) $img->image[3];
      	    
      	     echo "<div class='media'>";
      	     echo "<a href='" . $link . "' class='pull-left' target='_blank
      '>";
                   echo "<img src='" . $img . "' alt='" . $name . "' class='media-object thumbnail'/></a>";
      	     echo "<div class='media-body'>";
      	     echo "<h2 class='media-heading'>" . $name . "</h2>";
      	     echo "</div></div>";
      	  } 
      	  #echo "<pre>" . var_dump($xml) . "</pre>"; ?>
      </div>
    </div>
  </div>
</body>
</html>
