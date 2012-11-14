<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="./index.php">JamWalkr</a>
        <ul class="nav">
          <li><a href="./index.php"><i class="icon-home icon-white"></i></a></li>
          <li><a href="./lfm.php"><i class="icon-music icon-white"></i></a></li>
          <li class="active"><a href="./8tracks.php"><i class="icon-headphones icon-white"></i></a></li>
          <li><a href="./map.php"><i class="icon-map-marker icon-white"></i></a></li>
          <li><a href="./database.php"><i class="icon-hdd icon-white"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="container-fluid" style="margin-top: 50px;">
    <div class="row-fluid">
      <div class="span3">
        <ul class="nav nav-pills nav-stacked">
          <li><a href="./index.php"><i class="icon-home"></i> Home</a></li>
          <li><a href="./lfm.php"><i class="icon-music"></i> Last.fm API</a></li>
          <li class="active"><a href="./8tracks.php"><i class="icon-headphones"></i> 8Tracks API</a></li>
          <li><a href="./map.php"><i class="icon-map-marker"></i> Google Maps API</a></li>
          <li><a href="./database.php"><i class="icon-hdd"></i> MySQL Database</a></li>
        </ul>
      </div>
      <div class="span9">
        <h1>8Tracks API</h1>
        

        <?php
          if (!isset($_REQUEST["tag"]) || ($_REQUEST["tag"] == "")) {
            echo "<form class='form-search' method='post' action='8tracks.php'>" .
                 "<input type='text' class='input-medium search-query' name='tag' placeholder='tag' autofocus='autofocus'/>" .
                 "<button type='submit' class='btn'>Search</button></form>";
          } else {
            $tag = $_REQUEST["tag"];
            echo $tag;

            $etmethod = "/mixes.xml";
            $etsearch = "&tag=" . $tag . "&sort=popular";
            $mix      = $etbase . $etmethod . $etkey . $etsearch;
            $ret      = "<p class='lead'>" . $mix . "</p>";
                     
            $response = get_page($mix);
            $xml = new SimpleXMLElement($response);

            if ($xml->status != "200 OK") {
              $ret .= "<div class='alert'>";
              $ret .= "<button type='button' class='close' data-dismiss='alert'>×</button>";
              $ret .= "<strong>" . $xml->status . "</strong> We done messed up...</div>";
            } else {
              $data = $xml->mixes->mix;
              $name = (string) $data[0]->name;
              $desc = (string) $data[0]->description;
              $img  = (string) $data[0]->{'cover-urls'}->sq250;
              $link = (string) $data[0]->path;
              $tags = (string) $data[0]->{'tag-list-cache'};
              $mid  = (string) $data[0]->id;

              $ret .= "<div class='media'>";
              $ret .= "<a href='" . $etbase . $link . "' class='pull-left' target='_blank'>";
              $ret .= "<img src='" . $img . "' alt='" . $name . "' class='media-object thumbnail'/></a>";
              $ret .= "<div class='media-body'>";
              $ret .= "<h2 class='media-heading'>" . $name . "</h2>";
              $ret .= "<p>" . $desc . "</p><p>" . $tags . "</p>";
              $ret .= "</div></div>";
            }

            echo $ret;
            
            $purl = $etbase . "/sets/new.xml" . $etkey . "&api_version=2";
            echo "<p class='lead'>" . $purl . "</p>";

            $play = get_page($purl);
            $pxml = new SimpleXMLElement($play);
            if ($pxml->status != "200 OK") {
              echo "<div class='alert'>".
                   "<button type='button' class='close' data-dismiss='alert'>×</button>".
                   "<strong>" . $pxml->status . "</strong> We done messed up...</div>";
            } else {
              $token = $pxml->{'play-token'};
              echo "<p>" . $token . "</p>".
                   "<p>" . $purl . "</p>";

              $purl = $etbase . "/sets/" . $token . "/play.xml" . $etkey . "&api_version=2&mix_id=" . $mid;
              $play = get_page($purl);
	      $pxml = new SimpleXMLElement($play);
              echo "<pre>" . $pxml . "</pre>";

	      $song = $pxml->set->year->url;
              echo "<pre>" . $song . "</pre>";
            }
          }

          #echo grab_mixes($etbase, $etkey);

	  

	  ?>

      </div>
    </div>
  </div>
</body>
</html>
