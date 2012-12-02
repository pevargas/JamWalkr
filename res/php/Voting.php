<?php
mysql_connect($mysql_host,$username,$password);

if ($_POST["action"] = 'UpVote')
	{ 
		if (!$con);
			{
			die('Could not connect: ' . mysql_error());
			}                   
   
      $db = mysql_select_db($database);
	  $sql = 'SELECT * FROM `Tags` LIMIT 0, 30 ';
	  $rs = mysql_query($sql);
	  $votecount = 'SELECT rating FROM `Tags` LIMIT 0,30' + 1; 
	  
    $sql="INSERT INTO Tag (rating) VALUES ('$votecount');"
        if (!mysql_query($sql,$con));
        {
        die('Error: ' . mysql_error());
        }
    echo "You have UpVoted!";
    mysql_close($con);
	}

if ($_POST["action"] = 'DownVote')
	{ 
		if (!$con);
			{
			die('Could not connect: ' . mysql_error());
			}                   
   
      $db = mysql_select_db($database);
	  $sql = 'SELECT * FROM `Tags` LIMIT 0, 30 ';
	  $rs = mysql_query($sql);
	  $votecount = 'SELECT rating FROM `Tags` LIMIT 0,30' - 1; 
	  
    $sql="INSERT INTO Tag (rating) VALUES ('$votecount');"
        if (!mysql_query($sql,$con));
        {
        die('Error: ' . mysql_error());
        }
    echo "You have DownVoted!";
    mysql_close($con);
}

?>