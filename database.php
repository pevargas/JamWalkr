<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>JamWalkr</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- The styles America RULES-->
    <link href="res/css/bootstrap.css" rel="stylesheet">
    <link href="res/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
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
	  <li><a href="./8tracks.php"><i class="icon-headphones icon-white"></i></a></li>
	  <li><a href="./map.php"><i class="icon-map-marker icon-white"></i></a></li>
	  <li class="active"><a href="./database.php"><i class="icon-hdd icon-white"></i></a></li>
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
	  <li><a href="./map.php"><i class="icon-map-marker"></i> Google Maps API</a></li>
	  <li class="active"><a href="./database.php"><i class="icon-hdd"></i> MySQL Database</a></li>
	</ul>
      </div>      <div class="span9">
	<h1>MySQL Database</h1>
	<pre>
		
		
		<!-- CHANGE USERNAME AND PASSWORD FOR NOW FOR LOCALHOST USE -->
		<?php
			$username="root";
			$password="password";
			$database="JamWalkr";
		?> 
		
		

		<?php

			include("res/auth.php");
			include("res/loadfunc.php");
			mysql_connect(localhost,$username,$password);


			$con = mysql_connect(localhost,$username,$password);

			if (!$con)
			  {
			  die('Could not connect: ' . mysql_error());
			  }

			if (mysql_query("CREATE DATABASE $database",$con))
			  {
			  echo "Database created";
			  }
			else
			  {
			  echo "Error creating database: " . mysql_error();
			  }
  
			@mysql_select_db($database) or die( "Unable to select database in setup.php");
 
			 $query="CREATE TABLE Artists (id int(6) PRIMARY KEY NOT NULL auto_increment, name varchar(30) NOT NULL, img varchar(60) NOT NULL)";
			 mysql_query($query);
 
			# var_dump(curl_version());
			   $lfmmethod = "chart.getTopArtists";
			   $url = $lfmbase . "?method=" . $lfmmethod . $lfmkey;
			   echo "<p class='lead'>" . $lfmmethod . "</p>";	   

			   $response = get_page($url);
			   $xml = new SimpleXMLElement($response);
			   
			   $data = $xml->artists->artist; 
			   for ($i = 0; $i < sizeof($data); $i++) { 
			
				 $name = (string) $data[$i]->name;
				 $img  = $data[$i]->children();
				 $img  = (string) $img->image[3];
				
				 $query = "INSERT INTO Artists VALUES ('', '$name', '$img')";
				 //$sql = 'INSERT INTO `test` ( `title` , `BODY` ) ' . "VALUES ( '$title', '$body' 
				 mysql_query($query);
				 }

				mysql_close(); 
				
				// run initializer to set $username, $password, $database
				mysql_connect(localhost,$username,$password);
				@mysql_select_db($database) or die( "Unable to select database");
				$query="SELECT * FROM Artists";
				$result=mysql_query($query);
				
				// recover ALL the things from this broad query
				$num=mysql_numrows($result); 	

		echo "<b><center>Last.fm Database</center></b><br><br>";

		?>

		
		<?php
		$i=0;
		while ($i < $num) {
			$name=mysql_result($result,$i,"name");
			$img=mysql_result($result,$i,"img");
		?>
		
		
		<?php
		 echo "<div class='media'>";
             echo "<img src='" . $img . "' alt='" . $name . "' class='media-object thumbnail'/></a>";
	     echo "<div class='media-body'>";
	     echo "<h2 class='media-heading'>" . $name . "</h2>";
	     echo "</div></div>";
		?>
		

		<?php
		++$i;
		} 
		?>
	</pre>
      </div>
    </div>
  </div>
  <?php include ('res/js/scripts.js'); ?>
</body>
</html>
