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
	  <li class="active"><a href="./lastfm.php"><i class="icon-music icon-white"></i></a></li>
	</ul>
      </div>
    </div>
  </div>
  
  <div class="container-fluid" style="margin-top: 50px;">
    <div class="row-fluid">
      <div class="span12">
	<h1>Last.fm API</h1>

	<?php
	   $ch = curl_init();
	   curl_setopt($ch, CURLOPT_URL, "http://www.colorado.edu/");
	   curl_setopt($ch, CURLOPT_HEADER, true);
	   curl_setopt($ch, CURLOPT_NOBODY, true);
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	   $data = curl_exec($ch);
	   curl_close($ch)
	   echo $data;
	?>
	<?php echo "Blerg..."; ?>


      </div>
    </div>
  </div>
  <?php include ('res/js/scripts.js'); ?>
</body>
</html>
