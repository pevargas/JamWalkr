<?php
  	$mysql_host = "mysql13.000webhost.com";
    $username="a9185905_smucker";
    $password="ProfessorWhite3308";
    $database="a9185905_jar";	

	mysql_connect($mysql_host,$username,$password);
	$con = mysql_connect($mysql_host,$username,$password);	     
	if (!$con) {
		die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>".mysql_error()."</strong></div>");
	}
	 
	mysql_select_db("JamWalkr", $con) or die("Unable to Connect");			     

	mysql_query("INSERT INTO Buildings (`Id`,`name`, `lat`, `lon`) VALUES ('','Wonderland Lake','40.050022','-105.288684')";
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };

	mysql_query("INSERT INTO Buildings (`Id`,`name`, `lat`, `lon`) VALUES ('','Random Home','40.048117','-105.252829')";
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };

	mysql_query("INSERT INTO Buildings (`Id`,`name`, `lat`, `lon`) VALUES ('','Casey's House',39.993890','-105.250207')";
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };

	mysql_query("INSERT INTO Buildings (`Id`,`name`, `lat`, `lon`) VALUES ('','Airport','40.037407','-105.234103')";
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };
	
	mysql_query("INSERT INTO Buildings (`Id`,`name`, `lat`, `lon`) VALUES ('','Cemetary','40.008355','-105.282896')";
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };

	

	$Building1_ID = mysql_query("SELECT 'name' FROM 'Buildings' WHERE 'Id' = '0'");
	$Building2_ID = mysql_query("SELECT 'name' FROM 'Buildings' WHERE 'Id' = '1'");
	$Building3_ID = mysql_query("SELECT 'name' FROM 'Buildings' WHERE 'Id' = '2'");
	$Building4_ID = mysql_query("SELECT 'name' FROM 'Buildings' WHERE 'Id' = '3'");
	$Building5_ID = mysql_query("SELECT 'name' FROM 'Buildings' WHERE 'Id' = '4'");


	mysql_query("INSERT INTO Tags (`Id`, `tag`, `building`, `rating`) VALUES ('','R&B','.$Building1_ID.','')";	
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };

	mysql_query("INSERT INTO Tags (`Id`, `tag`, `building`, `rating`) VALUES ('','Classical','.$Building2_ID.','')";
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };

	mysql_query("INSERT INTO Tags (`Id`, `tag`, `building`, `rating`) VALUES ('','Punk','.$Building3_ID.','')";	
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };

	mysql_query("INSERT INTO Tags (`Id`, `tag`, `building`, `rating`) VALUES ('','Indie','.$Building4_ID.','')";
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };

	mysql_query("INSERT INTO Tags (`Id`, `tag`, `building`, `rating`) VALUES ('','Metal','.$Building5_ID.', , '')";		
	if (!mysql_query("JamWalkr", $con)) { mysql_error("Query Fail") };


	echo "Database Creation Successful :-D Yay";
>		