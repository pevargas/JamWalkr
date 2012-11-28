<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?>

  <script type="text/javascript">
  

  function bla() {}
    var myplayer = document.getElementById('player');
    var timepast = myplayer.currentTime;
    var duration = myplayer.duration;
    var width    = String(100*(timepast / duration));
    document.getElementById('time').setAttribute("style", "width:" + width + "%");
    /*if (timepast <= 0) {
      var url = document.getElementById("src").innerHTML;
      myplayer.setAttribute("src", url);
      myplayer.play();
    }*/
    if (30 < timepast && timepast < 31) {
      var url = document.getElementById('back').innerHTML;
      //document.getElementById('report').innerHTML = "<?= report_back(" + url + ");?>";
      //document.getElementById('sent').setAttribute("class", "muted");
    }
    window.setTimeout (function() { listen(); }, 1000);
  }
  function toggleMusic() {
    var player = document.getElementById('player');
    var button = document.getElementById('control');
    if (player.paused) { player.play(); button.setAttribute("class", "icon-pause icon-white"); }
    else { player.pause(); button.setAttribute("class", "icon-play icon-white"); }
  }
  </script>

  <style type="text/css">
  .control-conatiner { height: 20px; width: 20px; padding: 0px; }
  #control { margin: 0px; }
  .data { display: none; }
  </style>
  <script type="text/javascript">
  function initial() {
    var tags = document.getElementById('tags').innerHTML;
    if (tags != '') { 
      var lfmbase = "http://ws.audioscrobbler.com/2.0/";
      var lfmkey  = "&api_key=b15a0b92b58b210280fa88c5ae3bd038"; 
      var etbase  = "http://8tracks.com";
      var etkey   = "?api_key=efaea88b3f74c64c06351f6e76674f65bcc23ea0&api_version=2";

      document.getElementById('test').innerHTML = tags;
      // code for IE7+, Firefox, Chrome, Opera, Safari
      if (window.XMLHttpRequest) { xhr = new XMLHttpRequest(); }
      // code for IE6, IE5
      else { xhr = new ActiveXObject("Microsoft.XMLHTTP"); }

      var meth = "/mixes.xml";
      var sear = "&tag=" + tags + "&sort=popular";
      var mix  = etbase + meth + etkey + sear;

      xhr.open("GET", mix);
      xhr.send();
      xmlDoc = xhr.responseXML;
      alert(xmlDoc); 
      stat = xmlDoc.getElementsByTagName("id");
      alert(stat);
    }
    /*if (tags != '') {
      
    
      alert(tags);

  
        //$xml = new SimpleXMLElement($response);
        //$mid = (string) $xml->mixes->mix[0]->id;
        //return $mid;
        7}
      return false;
    }
      
      var purl  = etbase+"/sets/"+ptok+"/play.xml"+etkey+"&mix_id="+mid;

      //$song = play_track ($mid, $ptok, $purl);
    }*/
  }
  </script>
</head>
<body onload="initial()">
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
        
  <?php if (!isset($_REQUEST["tag"]) || ($_REQUEST["tag"] == "")) { ?>
          <form class="form-search" method="post" action="ajax.php">
            <div class="input-append">
              <input type="text" class="input-medium search-query" name="tag" placeholder="tag or mood" autofocus="autofocus"/>
              <button type="submit" class="btn">Search</button>
            </div>
          </form>
  <?php } else { 
          $tags = urlencode($_REQUEST["tag"]);
          if ((($mid = most_pop_mix ($tags)) != false) && (($ptok = play_token ()) != false)) { ?>
          <p class="lead">You're listening to the "<?=$_REQUEST["tag"];?>" tag.</p>

          <p id="test"></p>

          <div class="data">
            <span id="tags"><?=$tags?></span>
            <span id="report"></span>
          </div>

          <video id="player" class="data" onload="init()"></video>

            <div>
              <button class="btn btn-primary control-conatiner pull-left">
                  <i onclick="toggleMusic()" id="control" class="icon-pause icon-white"></i>
                </button> 
              <div class="progress progress-striped active">
                <div class="bar" id="time"></div>
              </div>         
            </div>

            <div><?= display_mix_info ($mid);?></div>

            <ul id="sent">
              <li><strong><?=$song['artist']?></strong> <?=$song['title']?></li>
            </ul>
      <?php } } ?>
      </div>
    </div>
  </div>
</body>
</html>
