<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

  <script type="text/javascript">
    function listen() {
      var myplayer = document.getElementById('player');
      var timepast = myplayer.currentTime;
      var duration = myplayer.duration;
      var width    = String(100*(timepast / duration));
      document.getElementById('time').setAttribute("style", "width:" + width + "%");
      if (30 < timepast && timepast < 31) {
        var url = document.getElementById('back').innerHTML;
        document.getElementById('report').innerHTML = "<?= report_back(" + url + ");?>";
        document.getElementById('sent').setAttribute("class", "muted");
      }
      window.setTimeout (function() { listen(); }, 1000);

    }
  </script>
</head>
<body onload="listen()">
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
      <div class="span3 visible-desktop">
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
            echo "<p class='lead'>You're listening to the \"" . $_REQUEST["tag"] . "\" tag.</p>";
            $tags = urlencode($_REQUEST["tag"]);
            $etmethod = "/mixes.xml";
            $etsearch = "&tag=" . $tags . "&sort=popular";
            $mix      = $etbase . $etmethod . $etkey . $etsearch;
            $response = get_page($mix);
            if (!haz_errors($response)) {
              $xml = new SimpleXMLElement($response);
              $mid = (string) $xml->mixes->mix[0]->id;
              //display_mix_info($mid);
              $purl = $etbase . "/sets/new.xml" . $etkey . "&api_version=2";
              $play = get_page($purl);
              if (!haz_errors($play)) {
                $pxml   = new SimpleXMLElement($play);
                $ptok   = $pxml->{'play-token'};
                $purl   = $etbase."/sets/".$ptok."/play.xml".$etkey."&api_version=2&mix_id=".$mid;
                $play   = get_page($purl);
                $pxml   = new SimpleXMLElement($play);
                $track  = $pxml->set->track;
                $url    = $track->url;
                $tid    = $track->id;
                $artist = $track->performer;
                $title  = $track->name;

                $back = $etbase."/sets/".$ptok."/report.xml".$etkey."&track_id=".$tid."&mix_id=".$mid; ?>
                <video src="<?=$url;?>" autoplay="autoplay" controls="controls" id="player">
                  Your browser does not support the video tag. Boo.
                </video>

                <div class="progress progress-striped active">
                  <div class="bar" id="time"></div>
                </div>
                <p id="sent"><strong><?=$artist?></strong> <?=$title?></p>

                <span id="back" style="display: none;"><?=$back;?></span>
                <span id="report" style="display:none;"></span>
      <?php }
          }
        }
      ?>
      </div>
    </div>
  </div>
</body>
</html>
