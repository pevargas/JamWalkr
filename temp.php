	   curl_setopt($ch, CURLOPT_URL, "index.php");
	   curl_setopt($ch, CURLOPT_HEADER, true);
	   curl_setopt($ch, CURLOPT_NOBODY, true);
	   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


	<?php
	   $ch = curl_init();
	   curl_setopt($ch, CURLOPT_URL, "index.php");
	   $data = curl_exec($ch);
	   curl_close($ch)
	   echo $data;
	?>
