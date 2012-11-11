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
	  <li><a href="./lfm.php"><i class="icon-music icon-white"></i></a></li>
	  <li><a href="./8tracks.php"><i class="icon-headphones icon-white"></i></a></li>
	  <li class="active"><a href="./map.php"><i class="icon-map-marker icon-white"></i></a></li>
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
	  <li><a href="./8tracks.php"><i class="icon-headphones"></i> 8Tracks API</a></li>
	  <li class="active"><a href="./map.php"><i class="icon-map-marker"></i> Google Maps API</a></li>
	  <li><a href="./database.php"><i class="icon-hdd"></i> MySQL Database</a></li>
	</ul>
      </div>
      <div class="span9">
	<h1>Google Maps API</h1>
	  <iframe width="600" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/?ie=UTF8&amp;ll=40.015652,-105.263786&amp;spn=0.055217,0.110378&amp;t=m&amp;z=13&amp;output=embed"></iframe>
	
      </div>
    </div>
  </div>
</body>
</html>
