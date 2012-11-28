<?php
	include("res/php/auth.php");

	if (isset($_REQUEST["sql"]) && ($_REQUEST["sql"] != "")) { 
		
		mysql_connect($mysql_host,$username,$password);
		$con = mysql_connect($mysql_host,$username,$password);	     
		if (!$con) {
			die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
		}

    echo $_REQUEST["sql"];
		//mysql_query($_REQUEST["sql"]);

	}
?>
