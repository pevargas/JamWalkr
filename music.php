<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>JamWalkr</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php include("res/auth.php");
          include("res/loadfunc.php"); ?>

    <!-- Le styles -->
    <link href="res/css/bootstrap.css" rel="stylesheet">
    <link href="res/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
	<a class="brand" href="./index.php">JamWalkr</a>
	<ul class="nav">
	  <li><a href="./index.php"><i class="icon-home icon-white"></i></a></li>
	  <li class="active"><a href="./music.php"><i class="icon-music icon-white"></i></a></li>
	  <li><a href="./map.php"><i class="icon-road icon-white"></i></a></li>
	</ul>
      </div>
    </div>
  </div>
  
  <div class="container-fluid" style="margin-top: 50px;">
    <div class="row-fluid">
      <div class="span3">
	<ul class="nav nav-pills nav-stacked">
	  <li><a href="./index.php"><i class="icon-home"></i> Home</a></li>
	  <li class="active"><a href="./music.php"><i class="icon-music"></i> Music APIs</a></li>
	  <li><a href="./map.php"><i class="icon-road"></i> Google Map API</a></li>
	</ul>
      </div>      <div class="span9">
	<h1>Last.fm API</h1>
	<?php
	   # var_dump(curl_version());
	   $lfmmethod = "chart.getTopArtists";
	   $url = $lfmbase . "?method=" . $lfmmethod . $lfmkey;
	   echo "<p class='lead'>" . $lfmmethod . "</p>";	   

	   $response = download_page($url);
	   $xml = new SimpleXMLElement($response);
	
	   $data = $xml->artists->artist; 
	?>

	<ul class="thumbnails">
          <?php for ($i = 0; $i < sizeof($data); $i++) {  
	    $name = (string) $data[$i]->name;
	    $link = (string) $data[$i]->url;
	    $img  = $data[$i]->children();
	    $img  = (string) $img->image[3];
	    
	    echo "<a href='" . $link . "' target='_blank'>";
            echo "<li class='span3'><div class='thumbnail'>";
	    echo "<img src='" . $img . "' alt='" . $name . "'/>";
	    echo "<div class='caption'>";
            echo "<p>" . $name . "</p>";
	    echo "</div></li></a>";
	    
	  } ?>
	</ul>
	<?php
	   echo "<pre>";	  
	   var_dump($xml);
	   echo "</pre>";
	   ?>
      </div>
    </div>
  </div>
  <?php include ('res/js/scripts.js'); ?>
</body>
</html>
