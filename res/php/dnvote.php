
<?php
  include("auth.php");
  // Increments a rating by one, given the tag name and the building id
  /* Get building id and tag name that was clicked */
  $tid  = $_REQUEST['tid'];

  /* Connect to database */
  $con = mysql_connect($mysql_host, $username, $password);
  if (!$con) { die(mysql_error()); }
  $db = mysql_select_db($database);

  /* Find and update corresponding tag */
  $sql = 'UPDATE Tags SET `rating` = `rating` - 1 WHERE `id` = '.$tid;
  $rs = mysql_query($sql);
  if (!$rs) { die(mysql_error()); }

?>