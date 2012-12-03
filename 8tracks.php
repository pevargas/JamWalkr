<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?>

  <script type="text/javascript">
  function listen() {
    var myplayer = document.getElementById('player');
    var timepast = myplayer.currentTime;
    var duration = myplayer.duration;
    var width    = String(100*(timepast / duration));
    document.getElementById('time').setAttribute("style", "width:" + width + "%");
    if (timepast <= 0) {
      var url = document.getElementById("src").innerHTML;
      myplayer.setAttribute("src", url);
      myplayer.play();
    }
    if (30 < timepast && timepast < 31) {
      var url = document.getElementById('back').innerHTML;
      document.getElementById('report').innerHTML = "<?= report_back(" + url + ");?>";
      document.getElementById('sent').setAttribute("class", "muted");
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
</head>
<body onload="listen()">
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="./index.php">JamWalkr</a>
        <ul class="nav">
          <li><a href="./index.php"><i class="icon-home icon-white"></i></a></li>
          <li class="active"><a href="./8tracks.php"><i class="icon-headphones icon-white"></i></a></li>
          <li><a href="./map.php"><i class="icon-map-marker icon-white"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="container-fluid" style="margin-top: 50px;">
    <div class="row-fluid">
      <div class="span2 visible-desktop">
        <ul class="nav nav-pills nav-stacked">
          <li><a href="./index.php"><i class="icon-home"></i> Home</a></li>
          <li class="active"><a href="./8tracks.php"><i class="icon-headphones"></i> 8Tracks API</a></li>
          <li><a href="./map.php"><i class="icon-map-marker"></i> Google Maps API</a></li>
        </ul>
      </div>
      <div class="span10">
        <h1>8Tracks API</h1>
        
  <?php if (!isset($_REQUEST["tag"]) || ($_REQUEST["tag"] == "")) { ?>
          <form class="form-search" method="post" action="8tracks.php">
            <div class="input-append">
              <input type="text" class="input-medium search-query" name="tag" placeholder="tag or mood" autofocus="autofocus"/>
              <button type="submit" class="btn">Search</button>
            </div>
          </form>
  <?php } else { 
          $tags = urlencode($_REQUEST["tag"]);
          if ((($mid = most_pop_mix ($tags)) != false) && (($ptok = play_token ()) != false)) {
            $purl   = $etbase."/sets/".$ptok."/play.xml".$etkey."&mix_id=".$mid;
              
            $song = play_track ($mid, $ptok, $purl);
            ?>
          <p class="lead">You're listening to the "<?=$_REQUEST["tag"];?>" tag.</p>
          <div class="data">
            <span id="music"></span>
            <span id="src"><?=$song['url'];?></span>
            <span id="back"><?=$song['back'];?></span>
            <span id="next"><?=$song['next'];?></span>
            <span id="report"></span>
          </div>
          <video id="player" class="data"></video>

            <div>
              <button class="btn btn-jam control-conatiner pull-left">
                  <i onclick="toggleMusic()" id="control" class="icon-pause icon-white"></i>
                </button> 
              <div class="progress progress-jam progress-striped active">
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
