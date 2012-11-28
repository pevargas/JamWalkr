<?php
	include("auth.php");

	if ((isset($_REQUEST["lat"]) && ($_REQUEST["lat"] != "")) && 
		(isset($_REQUEST["lng"]) && ($_REQUEST["lng"] != ""))) { 

		$building_name = $_REQUEST['name'];
		$lat		   = $_REQUEST['lat'];
		$lng		   = $_REQUEST['lng'];

		mysql_connect($mysql_host,$username,$password);
		$con = mysql_connect($mysql_host,$username,$password);	     
		if (!$con) {
			die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
		}
		@mysql_select_db($database) or die( "Unable to select database in setup.php");

		$query = "INSERT INTO Buildings VALUES ('', '$building_name', '$lat', '$lng')";
	    $result = mysql_query($query);

	    if (!$result) {
   			die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
   		}
		
		echo "Success! Added " . $building_name . " at (" . $lat . ", " . $lng . ")\n";

	}

	if((isset($_REQUEST["tag1"]) && ($_REQUEST["tag1"] != "")) && 
		(isset($_REQUEST["tag2"]) && ($_REQUEST["tag2"] != "")) &&
		(isset($_REQUEST["tag3"]) && ($_REQUEST["tag3"] != "")) ){

		$tag1 = $_REQUEST['tag1'];
		$tag2 = $_REQUEST['tag2'];
		$tag3 = $_REQUEST['tag3'];		

		$building_id = mysql_query("SELECT id FROM Buildings WHERE name = ". $building_name .");

		if (!$building_id) {
   			die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
   		}

		$query = "INSERT INTO Tags VALUES ('', '$building_id', '$tag1', 0)";
	    $result = mysql_query($query);

	    if (!$result) {
   			die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
   		}else{
   			echo "Added tag 1 " . $tag1 . "";
   		}

   		$query = "INSERT INTO Tags VALUES ('', '$building_id', '$tag2', 0)";
	    $result = mysql_query($query);

	    if (!$result) {
   			die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
   		}else{
   			echo "Added tag 2 " . $tag2 . "";

   		}

   		$query = "INSERT INTO Tags VALUES ('', '$building_id', '$tag3', 0)";
	    $result = mysql_query($query);

	    if (!$result) {
   			die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
   		}else{
   			echo "Added tag 3 " . $tag3 . "";

   		}

	}
?>