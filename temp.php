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
$xml = simplexml_load_file($url);

$tracks = $xml->recenttracks->track;
 
for ($i = 0; $i < 3; $i++) {
    $nowplaying = $tracks[$i]->attributes()->nowplaying;
    $trackname = $tracks[$i]->name;
    $artist = $tracks[$i]->artist;
    $url = $tracks[$i]->url;
    $date = $tracks[$i]->date;
    $img = $tracks[$i]->children();
    $img = $img->image[0];
 
    echo "<a href='" . $url . "' target='TOP'>";
 
    if ($nowplaying == "true") {
        echo "Now playing: ";
    }
 
    echo "<img src='" . $img . "' alt='album' />
        $artist . " - " . $trackname . " @ " . $date . "
    </a>
    ";
}