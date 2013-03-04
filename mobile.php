<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?>

  <script type="text/javascript" src="./res/js/jquery.mobile-1.3.0.min.js"></script>
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
      	<h1>Mobile</h1>
      	<?php ?>
      </div>
    </div>
  </div>
</body>
</html>
