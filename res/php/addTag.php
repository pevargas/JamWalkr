<?php
	// Add Tag function: Adds one additional tag to a given building.
	include("auth.php");
			
		$bid = $_REQUEST['bid'];
 		
 		/* Connect to database */
 		$con   = mysql_connect($mysql_host, $username, $password);
		if (!$con) { die(mysql_error()); }
		$db = mysql_select_db($database);

		/* Adds tag */
	 	if (isset($_REQUEST["tag"]) && ($_REQUEST["tag"] != "")) { 
	  		$sql = "INSERT INTO Tags VALUES ('', '".strtolower($_REQUEST['tag'])."', '".$bid."', '1');";
	  		$rs = mysql_query($sql);
	  		if (!$rs) { die(mysql_error()); }
	  		// Return inserted information
    		json_encode($rs);
	  	}  
	
?>