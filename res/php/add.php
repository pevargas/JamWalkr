<?php
	// Add function: checks for validity, then connects to database and adds in the new building and its tags 
	include("auth.php");

	if ((isset($_REQUEST["lat"]) && ($_REQUEST["lat"] != "")) && 
		  (isset($_REQUEST["lng"]) && ($_REQUEST["lng"] != ""))) { 
			
		$build = $_REQUEST['name'];
		$lat	 = $_REQUEST['lat'];
		$lng	 = $_REQUEST['lng'];
 		
 		$con   = mysql_connect($mysql_host, $username, $password);
		if (!$con) { die(mysql_error()); }
		$db = mysql_select_db($database);
		//if (!$db) { die(mysql_error()); }
		
		$sql = "INSERT INTO Buildings VALUES ('', '".$build."', '".$lat."', '".$lng."')";
	  $rs = mysql_query($sql);
	  if (!$rs) { die(mysql_error()); }

  	$sql = "SELECT * FROM `Buildings` WHERE `name` = '".$build."'";
		$rs = mysql_query($sql);

	  if (!$rs) { die(mysql_error()); }
	  $row = mysql_fetch_array($rs);

	  $bid = $row['id'];

	  if (isset($_REQUEST["tag1"]) && ($_REQUEST["tag1"] != "")) { 
	  	$sql = "INSERT INTO Tags VALUES ('', '".strtolower($_REQUEST['tag1'])."', '".$bid."', '1');";
	  	$rs = mysql_query($sql);
	  	if (!$rs) { die(mysql_error()); }
	  }
	  if (isset($_REQUEST["tag2"]) && ($_REQUEST["tag2"] != "")) { 
	  	$sql = "INSERT INTO Tags VALUES ('', '".strtolower($_REQUEST['tag2'])."', '".$bid."', '1');";
	  	$rs = mysql_query($sql);
	  	if (!$rs) { die(mysql_error()); }
	  }
	  if (isset($_REQUEST["tag3"]) && ($_REQUEST["tag3"] != "")) { 
	  	$sql = "INSERT INTO Tags VALUES ('', '".strtolower($_REQUEST['tag3'])."', '".$bid."', '1');";
	  	$rs = mysql_query($sql);
	  	if (!$rs) { die(mysql_error()); }
	  }

	  // Return inserted information  
		$sql = "SELECT * FROM `Tags` WHERE `building` = '".$bid."'";
    $rs = mysql_query($sql);
    if (!$rs) { die("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>"); } 
    $tagarr    = array();
    $ratingarr = array();
   	$tidarr    = array();
    while($row2 = mysql_fetch_array($rs)) { 
      $tagarr[] = $row2['tag'];
      $ratingarr[] = $row2['rating'];
      $tidarr[] = $row2['id'];
   	}
    $array = array(
    	"lat"  			=> $lat,
    	"lng"  			=> $lng,
    	"name" 			=> $build,
    	"id"   			=> $bid,
    	"tagarr" 		=> $tagarr,
    	"ratingarr" => $ratingarr,
    	"tidarr" 		=> $tidarr,
    );

	  echo json_encode($array);
	}
?>