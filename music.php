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
	<a class="brand pull-left" href="./index.php">JamWalkr</a>
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
      <div class="span12">
	<h1>Last.fm API</h1>
	<pre>
	  <?php
	     #var_dump(curl_version());
	     $curl = curl_init();
	     // You can also set the URL you want to communicate with by doing this:
	     // $curl = curl_init('http://localhost/echoservice');
	     
	     // We POST the data
	     curl_setopt($curl, CURLOPT_POST, 1);
	     // Set the url path we want to call
	     curl_setopt($curl, CURLOPT_URL, 'http://localhost/JamWalkr/mitch.txt');  
	     // Make it so the data coming back is put into a string
	     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	     // You can also bunch the above commands into an array if you choose using: curl_setopt_array
	     
	     // Insert Data
	     curl_setopt($curl, CURLOPT_POSTFIELDS, '');
	     // Send the request
	     $result = curl_exec($curl);
	     // Free up the resources $curl is using
	     curl_close($curl);
	     
	     echo $result;
	  ?>
	</pre>
      </div>
    </div>
  </div>
  <?php include ('res/js/scripts.js'); ?>
</body>
</html>
