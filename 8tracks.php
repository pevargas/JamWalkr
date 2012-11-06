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
	  <li><a href="./lfm.php"><i class="icon-music icon-white"></i></a></li>
	  <li class="active"><a href="./8tracks.php"><i class="icon-headphones icon-white"></i></a></li>
	  <li><a href="./map.php"><i class="icon-map-marker icon-white"></i></a></li>
	  <li><a href="./database.php"><i class="icon-hdd icon-white"></i></a></li>
	</ul>
      </div>
    </div>
  </div>
  
  <div class="container-fluid" style="margin-top: 50px;">
    <div class="row-fluid">
      <div class="span3">
	<ul class="nav nav-pills nav-stacked">
	  <li><a href="./index.php"><i class="icon-home"></i> Home</a></li>
	  <li><a href="./lfm.php"><i class="icon-music"></i> Last.fm API</a></li>
	  <li class="active"><a href="./8tracks.php"><i class="icon-headphones"></i> 8Tracks API</a></li>
	  <li><a href="./map.php"><i class="icon-map-marker"></i> Google Maps API</a></li>
	  <li><a href="./database.php"><i class="icon-hdd"></i> MySQL Database</a></li>
	</ul>
      </div>      
      <div class="span9">
	<h1>8Tracks API</h1>
	<?php
	   $etmethod = "/mixes.xml";
	   $url = $etbase . $etmethod . $etkey;
	   echo "<p class='lead'>" . $etmethod . "</p>";
	   
	   $response = get_page($url);
	   $xml = new SimpleXMLElement($response);

	   $data = $xml->mixes->mix;
	   for ($i = 0; $i < sizeof($data); $i++) {
             $name = (string) $data[$i]->name;
             $desc = (string) $data[$i]->description;
	     $img  = (string) $data[$i]->{'cover-urls'}->sq250;
	     $link = (string) $data[$i]->path;

             echo "<div class='media'>";
	     echo "<a href='" . $etbase . $link . "' class='pull-left' target='_blank'>";
             echo "<img src='" . $img . "' alt='" . $name . "' class='media-object thumbnail'/></a>";
	     echo "<div class='media-body'>";
	     echo "<h2 class='media-heading'>" . $name . "</h2>";
	     echo "<p>" . $desc . "</p>";
	     echo "</div></div>";

           }

	   #echo "<pre>";
	   #echo var_dump($img) . "</pre>";
	?>
      </div>
    </div>
  </div>
  <?php include ('res/js/scripts.js'); ?>
</body>
</html>
