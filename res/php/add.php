<!-- Add function: checks for validity, then connects to database and adds in the new building and its tags -->
<?php
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

	  if (isset($_REQUEST["tag1"]) && ($_REQUEST["tag1"] != "")) { 
	  	$sql = "INSERT INTO Tags VALUES ('', '".strtolower($_REQUEST['tag1'])."', '".$row['id']."', '1');";
	  	$rs = mysql_query($sql);
	  	if (!$rs) { die(mysql_error()); }
	  }
	  if (isset($_REQUEST["tag2"]) && ($_REQUEST["tag2"] != "")) { 
	  	$sql = "INSERT INTO Tags VALUES ('', '".strtolower($_REQUEST['tag2'])."', '".$row['id']."', '1');";
	  	$rs = mysql_query($sql);
	  	if (!$rs) { die(mysql_error()); }
	  }
	  if (isset($_REQUEST["tag3"]) && ($_REQUEST["tag3"] != "")) { 
	  	$sql = "INSERT INTO Tags VALUES ('', '".strtolower($_REQUEST['tag3'])."', '".$row['id']."', '1');";
	  	$rs = mysql_query($sql);
	  	if (!$rs) { die(mysql_error()); }
	  }

	}
?>