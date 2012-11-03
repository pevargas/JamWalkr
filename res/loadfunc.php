<?php function download_page ($path) {
  # Initialize cURL
  $curl = curl_init();
	   
  # We POST the data
  if (!curl_setopt($curl, CURLOPT_POST, 1)) {
    echo "<div class='alert alert-error fade in'>";
    echo "<button type='button' class='close' data-dismiss='alert'>x</button>";
    echo "<strong>Error: </strong> CURLOPT_POST failed.</div>"; 
  }
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
  # You can also bunch the above commands into an array if you choose using: curl_setopt_array
	   
  # Insert Data
  if(!curl_setopt($curl, CURLOPT_POSTFIELDS, '')) {
    echo "<div class='alert alert-error fade in'>";
    echo "<button type='button' class='close' data-dismiss='alert'>x</button>";
    echo "<strong>Error: </strong> CURLOPT_POSTFIELDS failed.</div>"; 
  }
  # Send the request
  $response = curl_exec($curl);
  # Free up the resources $curl is using
  curl_close($curl);

  return $response;
} ?>