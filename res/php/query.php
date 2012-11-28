<?php
	include("auth.php");
		
	mysql_connect($mysql_host,$username,$password);
	$con = mysql_connect($mysql_host,$username,$password);	     
	if (!$con) {
		die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
	}

  $sql = 'SELECT * FROM `Buildings` LIMIT 0, 30 ';

  $response = mysql_query($sql);

  echo var_dump($response);

?>