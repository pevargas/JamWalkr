<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"/>
  <script type="text/javascript">
    $("#pickthis").click(function() {
      $.ajax({   
        type:"POST",
        url:"8tracks.php",
        data:{fileid:pickthisid},
        cache:false,
      });
    });​

    </script>
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
          $purl = $etbase . "/sets/new.xml" . $etkey . "&api_version=2";
          echo "<p class='lead'>" . $purl . "</p>";

          $play = get_page($purl);
          $pxml = new SimpleXMLElement($play);
          if ($pxml->status != "200 OK") {
            echo "<div class='alert'>";
            echo "<button type='button' class='close' data-dismiss='alert'>×</button>";
            echo "<strong>" . $pxml->status . "</strong> We done messed up...</div>";
          } else {
            $token = $pxml->{'play-token'};
            echo "<p>" . $token . "</p>";
            echo "<p>" . $_REQUEST['pickthis'] . "</p>";

            $purl = $etbase . "/sets/" . $token . "/play.xml" . $etkey;
            $play = get_page($purl);
          }

          $etmethod = "/mixes.xml";
          $etsort   = "&sort=popular";
          $mix      = $etbase . $etmethod . $etkey . $etsort;
          echo "<p class='lead'>" . $etmethod . "</p>";
      	   
          $response = get_page($mix);
          $xml = new SimpleXMLElement($response);

          if ($xml->status != "200 OK") {
            echo "<div class='alert'>";
            echo "<button type='button' class='close' data-dismiss='alert'>×</button>";
            echo "<strong>" . $xml->status . "</strong> We done messed up...</div>";
          } else {
            $data = $xml->mixes->mix;
            for ($i = 0; $i < sizeof($data); $i++) {
              $name = (string) $data[$i]->name;
              $desc = (string) $data[$i]->description;
              $img  = (string) $data[$i]->{'cover-urls'}->sq250;
              $link = (string) $data[$i]->path;
              $tags = (string) $data[$i]->{'tag-list-cache'};
              $mid  = (string) $data[$i]->id;

              echo "<div class='media'>";
              echo "<a href='" . $etbase . $link . "' class='pull-left' target='_blank'>";
              echo "<img src='" . $img . "' alt='" . $name . "' class='media-object thumbnail'/></a>";
              echo "<div class='media-body'>";
              echo "<h2 class='media-heading'>" . $name . "</h2>";
              echo "<p>" . $desc . "</p><p>" . $tags . "</p>";
              echo "<submit type='button' id='pickthis' value='" . $mid . "'/>";
              echo "</div></div>";
            }
          }

          echo "<pre>";
          echo var_dump($img) . "</pre>";
          ?>
      </div>
    </div>
  </div>
</body>
</html>
