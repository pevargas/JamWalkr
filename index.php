<!DOCTYPE html>
<html lang="en">
<head>
  <?php include("res/auth.php");
        include("res/loadfunc.php"); 
	include("res/links.php") ?>
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
	<a class="brand" href="./index.php">JamWalkr</a>
	<ul class="nav">
	  <li class="active"><a href="./index.php"><i class="icon-home icon-white"></i></a></li>
	  <li><a href="./lfm.php"><i class="icon-music icon-white"></i></a></li>
	  <li><a href="./8tracks.php"><i class="icon-headphones icon-white"></i></a></li>
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
	  <li class="active"><a href="./index.php"><i class="icon-home"></i> Home</a></li>
	  <li><a href="./lfm.php"><i class="icon-music"></i> Last.fm API</a></li>
	  <li><a href="./8tracks.php"><i class="icon-headphones"></i> 8Tracks API</a></li>
	  <li><a href="./map.php"><i class="icon-map-marker"></i> Google Maps API</a></li>
	  <li><a href="./database.php"><i class="icon-hdd"></i> MySQL Database</a></li>
	</ul>
      </div>
      <div class="span9">
	<h1>JamWalkr</h1>
	<p class="lead">The Music Tagging Project</p>

	<p>For Deliverable I, select the tabs to the left. In this deliverable we should be able to:</p>
	<ul>
	  <li>Load and display a webpage</li>
	  <li>Map Control (Pan, Zoom, etc.)</li>
	  <li>Interact with the MySQL database</li>
	  <li>Demonstrate connection with the Last.fm API and 8tracks API</li>
	</ul>
      </div>
    </div>
  </div>
</body>
</html>
