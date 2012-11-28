<?php
	include("res/php/auth.php");

	mysql_connect($mysql_host,$username,$password);
	$con = mysql_connect($mysql_host,$username,$password);	     
	if (!$con) { die('Could not connect: ' . mysql_error()); }
	$db = mysql_select_db($database) or die(mysql_error());	

	//$minx = 39.9848; $miny = -105.292;
	//$maxx = 40.0501; $maxy = -105.227;

	$sql = mysql_query("INSERT INTO Buildings VALUES ('','Wonderland Lake','40.050022','-105.288684')");
	if (!$sql) { mysql_error("Query Fail: " . mysql_error()) };

	$sql = mysql_query("INSERT INTO Buildings VALUES ('','Random Home','40.048117','-105.252829')");
	if (!$sql) { mysql_error("Query Fail: " . mysql_error()) };

	$sql = mysql_query("INSERT INTO Buildings VALUES ('','Casey's House',39.993890','-105.250207')");
	if (!$sql) { mysql_error("Query Fail: " . mysql_error()) };

	$sql = mysql_query("INSERT INTO Buildings VALUES ('','Airport','40.037407','-105.234103')");
	if (!$sql) { mysql_error("Query Fail: " . mysql_error()) };
	
	$sql = mysql_query("INSERT INTO Buildings VALUES ('','Cemetary','40.008355','-105.282896')");
	if (!$sql) { mysql_error("Query Fail: " . mysql_error()) };	

	$Building1_ID = mysql_query("SELECT name FROM Buildings WHERE Id = '0'");
	$Building2_ID = mysql_query("SELECT name FROM Buildings WHERE Id = '1'");
	$Building3_ID = mysql_query("SELECT name FROM Buildings WHERE Id = '2'");
	$Building4_ID = mysql_query("SELECT name FROM Buildings WHERE Id = '3'");
	$Building5_ID = mysql_query("SELECT name FROM Buildings WHERE Id = '4'");

	mysql_query("INSERT INTO Tags (`Id`, `tag`, `building`, `rating`) VALUES ('','R&B','.$Building1_ID.','')");	
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };

	mysql_query("INSERT INTO Tags (`Id`, `tag`, `building`, `rating`) VALUES ('','Classical','.$Building2_ID.','')");
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };

	mysql_query("INSERT INTO Tags (`Id`, `tag`, `building`, `rating`) VALUES ('','Punk','.$Building3_ID.','')");	
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };

	mysql_query("INSERT INTO Tags (`Id`, `tag`, `building`, `rating`) VALUES ('','Indie','.$Building4_ID.','')");
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };

	mysql_query("INSERT INTO Tags (`Id`, `tag`, `building`, `rating`) VALUES ('','Metal','.$Building5_ID.', , '')");		
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };


	echo "Database Creation Successful :-D Yay";
>		