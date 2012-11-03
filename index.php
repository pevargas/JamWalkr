<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>JamWalkr</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

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
	  <li class="active"><a href="./index.php"><i class="icon-home icon-white"></i></a></li>
	  <li><a href="./music.php"><i class="icon-music icon-white"></i></a></li>
	  <li><a href="./map.php"><i class="icon-road icon-white"></i></a></li>
	</ul>
      </div>
    </div>
  </div>
  
  <div class="container-fluid" style="margin-top: 50px;">
    <div class="row-fluid">
      <div class="span3">
	<ul class="nav nav-pills nav-stacked">
	  <li class="active"><a href="./index.php"><i class="icon-home"></i> Home</a></li>
	  <li><a href="./music.php"><i class="icon-music"></i> Music APIs</a></li>
	  <li><a href="./map.php"><i class="icon-road"></i> Google Map Apis</a></li>
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
  <?php include ('res/js/scripts.js'); ?>
</body>
</html>
