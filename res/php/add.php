<?php
	include("res/php/auth.php");

	if ( (isset($_REQUEST["lat"]) || !($_REQUEST["lat"] == "")) && (isset($_REQUEST["lon"]) || !($_REQUEST["lon"] == "")) ) { 
			
		$building_name = $_REQUEST['name'];
		$lat		   = $_REQUEST['lat'];
		$lon		   = $_REQUEST['lon'];

		mysql_connect($mysql_host,$username,$password);
		$con = mysql_connect($mysql_host,$username,$password);	     
		if (!$con) {
			die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
		}

		$query = "INSERT INTO Buildings VALUES ('', '$building_name', '$lat', '$lon')";
	    $result = mysql_query($query);

	    if (!$result) {
   			die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
   		}else{
			echo "Success! Added " . $building_name . " at (" . $lat . ", " . $lon . ")";
		}

	}
?>