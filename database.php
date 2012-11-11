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
	  <!-- CHANGE USERNAME AND PASSWORD FOR NOW FOR LOCALHOST USE -->
	  <?php
	     $username="root";
	     $password="guest";
	     $database="JamWalkr";
	     ?> 	  

	  <?php
	     
	     mysql_connect(localhost,$username,$password);
	     $con = mysql_connect(localhost,$username,$password);	     
	     if (!$con) {
	       die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
	     }
	     
	     if (mysql_query("CREATE DATABASE $database",$con)) {
	       echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Success! </strong>Database created</strong></div>";
	     }
	     else {
	       echo "<div class='alert'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Warning: </strong>" . mysql_error() . "</strong></div>";
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
	    //$sql = 'INSERT INTO `test` ( `title` , `BODY` ) ' . "VALUES ( '$title', '$body' )"
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
	    
	    echo "<p style='font-weight: bold; text-align:center;'>Last.fm Database<p/>";
	    
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
      </div>
    </div>
  </div>
</body>
</html>
