<!-- Increments a rating by one, given the tag name and the building id -->
<?php
	/* Get building id and tag name that was clicked */
	$build_id = $_REQUEST['build_id'];
	$tag_name = $_REQUEST['tag_name'];

	/* Connect to database */
	$con = mysql_connect($mysql_host, $username, $password);
	if (!$con) { die(mysql_error()); }
	$db = mysql_select_db($database);

	/* Find and update corresponding tag */
	$sql = "UPDATE Tags SET rating = rating + 1 WHERE `building` = '".$building_id."' AND 'tag_name' = '".$tag_name."'";
    $rs = mysql_query($sql);
    if (!$rs) { die(mysql_error()); }

?>