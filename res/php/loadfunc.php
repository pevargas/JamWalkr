<?php function get_page ($path) {
  # Initialize cURL
  $curl = curl_init();

  # Set the url path we want to call
  if(!curl_setopt($curl, CURLOPT_URL, $path)) {
    echo "<div class='alert alert-error fade in'>";
    echo "<button type='button' class='close' data-dismiss='alert'>x</button>";
    echo "<strong>Error: </strong> CURLOPT_URL failed.</div>"; 
  }
  # Make it so the data coming back is put into a string
  if(!curl_setopt($curl, CURLOPT_RETURNTRANSFER, true)) {
    echo "<div class='alert alert-error fade in'>";
    echo "<button type='button' class='close' data-dismiss='alert'>x</button>";
    echo "<strong>Error: </strong> CURLOPT_RETURNTRANSFER failed.</div>"; 
  }
	   
  # Send the request
  $response = curl_exec($curl);
  # Free up the resources $curl is using
  curl_close($curl);

  return $response;
}

function grab_mixes ($etbase, $etkey) {
  $etmethod = "/mixes.xml";
  $etsort   = "&sort=popular";
  $mix      = $etbase . $etmethod . $etkey . $etsort;
  $ret      = "<p class='lead'>" . $etmethod . "</p>";
           
  $response = get_page($mix);
  $xml = new SimpleXMLElement($response);

  if ($xml->status != "200 OK") {
    $ret .= "<div class='alert'>";
    $ret .= "<button type='button' class='close' data-dismiss='alert'>×</button>";
    $ret .= "<strong>" . $xml->status . "</strong> We done messed up...</div>";
  } else {
    $data = $xml->mixes->mix;
    for ($i = 0; $i < sizeof($data); $i++) {
      $name = (string) $data[$i]->name;
      $desc = (string) $data[$i]->description;
      $img  = (string) $data[$i]->{'cover-urls'}->sq250;
      $link = (string) $data[$i]->path;
      $tags = (string) $data[$i]->{'tag-list-cache'};
      $mid  = (string) $data[$i]->id;

      $ret .= "<div class='media'>";
      $ret .= "<a href='" . $etbase . $link . "' class='pull-left' target='_blank'>";
      $ret .= "<img src='" . $img . "' alt='" . $name . "' class='media-object thumbnail'/></a>";
      $ret .= "<div class='media-body'>";
      $ret .= "<h2 class='media-heading'>" . $name . "</h2>";
      $ret .= "<p>" . $desc . "</p><p>" . $tags . "</p>";
      $ret .= "<submit type='button' id='pickthis' value='" . $mid . "'/>";
      $ret .= "</div></div>";
    } 
  }

  #$ret .= "<pre>" . var_dump($img) . "</pre>";

  return $ret;
}

function report_back($url) { $response = get_page($url); }

function haz_errors ($url) {
  $xml = new SimpleXMLElement($url);

  if ($xml->status != "200 OK") {
    $ret  = "<div class='alert'>";
    $ret .= "<button type='button' class='close' data-dismiss='alert'>×</button>";
    $ret .= "<strong>" . $xml->status . "</strong> We done messed up...</div>";
    echo $ret;
    return true;
  }

  return false;
}

function most_pop_mix ($tags) {
  
}

function display_mix_info ($mix_id) {
  $curl = $etbase . "/mixes/" . $mix_id . ".xml" . $etkey;
  $response = get_page($curl);
  if (!haz_errors($response)) {
    $xml = new SimpleXMLElement($response);
    $data = $xml->mix;
    $name = (string) $data->name;
    $desc = (string) $data->description;
    $img  = (string) $data->{'cover-urls'}->sq250;
    $link = (string) $data->path;
    $tags = (string) $data->{'tag-list-cache'};
    $mid  = (string) $data->id;

    $ret .= "<div class='media'>";
    $ret .= "<a href='" . $etbase . $link . "' class='pull-left' target='_blank'>";
    $ret .= "<img src='" . $img . "' alt='" . $name . "' class='media-object thumbnail'/></a>";
    $ret .= "<div class='media-body'>";
    $ret .= "<h2 class='media-heading'>" . $name . "</h2>";
    $ret .= "<p>" . $desc . "</p><p>" . $tags . "</p>";
    $ret .= "</div></div>";
    echo $ret;
  }
}

?>