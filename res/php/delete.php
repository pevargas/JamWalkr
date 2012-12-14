<!-- Delete function: remove entry from db -->
<?php
	include("auth.php");

	$con   = mysql_connect($mysql_host, $username, $password);
	if (!$con) { die(mysql_error()); }
	$db = mysql_select_db($database);

	$build = $_REQUEST['name'];

	$result = mysql_query("DELETE * FROM 'Buildings' WHERE WHERE `name` = '".$build."'" );          //query
	if (!$result) { die(mysql_error()); }
  	$array = mysql_fetch_row($result);   
	

	echo json_encode($array);

?>