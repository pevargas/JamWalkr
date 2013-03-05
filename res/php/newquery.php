<?php
	include("auth.php");
		
	mysql_connect($mysql_host,$username,$password);
	$con = mysql_connect($mysql_host,$username,$password);	     
	if (!$con) {
		die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
	}
  $db = mysql_select_db($database);
  $sql = 'SELECT * FROM `Buildings` LIMIT 0, 100 ';
  $rs = mysql_query($sql);
  
  if (!$rs) { die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>"); }

  $all = array();
  $i = 0;
  while($row = mysql_fetch_array($rs)) { 
    $all[$i++] = $row;
  }
  echo json_encode($all);

?>