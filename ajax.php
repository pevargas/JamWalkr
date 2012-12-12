<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?>

  <script type="text/javascript">
  var lfmbase = "http://ws.audioscrobbler.com/2.0/";
  var lfmkey  = "&api_key=b15a0b92b58b210280fa88c5ae3bd038"; 
  var etbase  = "http://8tracks.com";
  var etkey   = "?api_key=efaea88b3f74c64c06351f6e76674f65bcc23ea0&api_version=2";

  $(window).load(function() {
    var tags = $('#tags').html();
    if (tags != null) { 
      var sear    = "&tag=" + tags + "&sort=popular";
      var mix     = etbase + "/mixes.jsonp" + etkey + sear;
      var purl    = etbase + "/sets/new.jsonp" + etkey;
      var mid     = '';
      var ptok    = '';

      $.when(
        $.ajax({
          url: mix,
          dataType: "jsonp",
          success: function(data) { 
            $("#msg").append(mix);
            mid = data.mixes[0].id; },
          error: function(jqXHR, textStatus, errorThrown) {
            $("#msg").append("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
          }
        }), $.ajax({
          url: purl,
          dataType: "jsonp",
          success: function(data) { ptok = data.play_token; },
          error: function(jqXHR, textStatus, errorThrown) {
            $("#msg").append("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
          }
        })
      ).done(function(a1, a2){
        var play  = etbase+"/sets/"+ptok+"/play.jsonp"+etkey+"&mix_id="+mid;
        $.ajax({
          url: play,
          dataType: "jsonp",
          success: function(data) {
            $("#player").attr("src", data.set.track.url);
            $("#player").get(0).play();
            $("#info").prepend("<li class='current'><strong>"+data.set.track.name+"</strong> "+data.set.track.performer+"</li>");            
            listen(data, mid, ptok);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $("#msg").append("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
          }
        });
      });
    }

    function listen(data, mid, ptok) {
    var myplayer = document.getElementById('player');
    var timepast = myplayer.currentTime;
    var duration = myplayer.duration;
    var width    = String(100*(timepast / duration));

    var minutes  = parseInt(timepast / 60)%60;
    var seconds  = parseInt(timepast)%60;
    $("#current").html(minutes +":"+(seconds < 10 ? "0" + seconds : seconds));
    document.getElementById('time').setAttribute("style", "width:" + width + "%");
    if (30 < timepast && timepast < 31) {
      var report = etbase+"/sets/"+ptok+"/report.jsonp"+etkey+"&mix_id="+mid+"&track_id="+data.set.track.id;
      $.ajax({
        url: report,
        dataType: "jsonp",
        error: function(jqXHR, textStatus, errorThrown) {
          $("#msg").append("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
        }
      });
    } else if (width == 100) {
        var next = etbase+"/sets/"+ptok+"/next.jsonp"+etkey+"&mix_id="+mid;
        $.ajax({
          url: next,
          dataType: "jsonp",
          success: function(data) { 
            $("#player").attr("src", data.set.track.url);
            $("#player").get(0).play();
            $(".current").addClass("muted").removeClass("current");
            $("#info").prepend("<li class='current'><strong>"+data.set.track.name+"</strong> "+data.set.track.performer+"</li>");            
            listen(data, mid, ptok);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $("#msg").append("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
          }
        });
    }
    window.setTimeout (function() { listen(data, mid, ptok); }, 1000);
  }
  });

  function toggleMusic() {
    var player = document.getElementById('player');
    var button = document.getElementById('control');
    if (player.paused) { player.play(); button.setAttribute("class", "icon-pause icon-white"); }
    else { player.pause(); button.setAttribute("class", "icon-play icon-white"); }
  }
  </script>
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="./index.php">JamWalkr</a>
        <ul class="nav">
          <li><a href="./index.php"><i class="icon-home icon-white"></i></a></li>
          <li class="active"><a href="./ajax.php"><i class="icon-music icon-white"></i></a></li>
          <li><a href="./8tracks.php"><i class="icon-headphones icon-white"></i></a></li>
          <li><a href="./map.php"><i class="icon-map-marker icon-white"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
  
  <div class="container-fluid" style="margin-top: 50px;">
    <div class="row-fluid">
      <div class="span12">
        <h1>AJAX</h1>
        
  <?php if (!isset($_REQUEST["tag"]) || ($_REQUEST["tag"] == "")) { ?>
          <form class="form-search" method="post" action="ajax.php">
            <div class="input-append">
              <input type="text" class="input-medium search-query" name="tag" id="tag" class="tag" placeholder="mood, genre, or artist" autofocus="autofocus" />
              <button type="submit" class="btn">Search</button>
            </div>
          </form>
          <div id="test"></div>
  <?php } else { 
          $tags = urlencode($_REQUEST["tag"]);
          if ((($mid = most_pop_mix ($tags)) != false) && (($ptok = play_token ()) != false)) { ?>
          <p class="lead">You're listening to the "<?=$_REQUEST["tag"];?>" tag.</p>

          <div class="data">
            <span id="tags"><?=$tags?></span>
            <span id="report"></span>
          </div>

          <span id="msg"></span>
          <video id="player" class="data"></video>

            <div>
              <button class="btn btn-jam control-conatiner pull-left">
                <i onclick="toggleMusic()" id="control" class="icon-pause icon-white"></i>
              </button> 
              <div class="progress progress-jam progress-striped active">
                <div class="bar" id="time"><span id="current" class="badge badge-jam"></span></div>
              </div>         
            </div>

            <div><?= display_mix_info ($mid);?></div>

            <ul id="info">
            </ul>
      <?php } } ?>
      </div>
    </div>
  </div>
</body>
</html>
