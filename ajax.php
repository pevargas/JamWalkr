<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?>

  <style type="text/css">
  .control-conatiner { height: 20px; width: 20px; padding: 0px; }
  #control { margin: 0px; }
  .data { display: none; }

  
  </style>
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


      // Grab Mix ID
      $.getJSON(mix, function(data) {
        $("#msg").append("<div class='alert alert-success'><strong>Success!</strong> AJAX went through for mix id.</div>");

        if (data.status === '200 OK') { $("#mid").append(mid = data.mixes[0].id); }
        else { $(this).append("<div class='alert alert-error'><strong>Failure</strong> 8Tracks rejected the request for a mix id.</div>"); }
      });

      // Grab Play Token
      $.getJSON(purl, function(data) {
        $("#msg").append("<div class='alert alert-success'><strong>Success!</strong> AJAX went through for play token.</div>");

        if (data.status === '200 OK') { $("#ptok").append(ptok = data.play_token); }
        else { $(this).append("<div class='alert alert-error'><strong>Failure</strong> 8Tracks rejected the request for a play token.</div>"); }
      });

      $("#msg").ajaxError(function(evt, request, settings){
        $(this).append("<div class='alert alert-error'><strong>Error requesting page: </strong>" + settings.url + "</div>");
      });

      /*$("#msg").ajaxStop({
        $(this).append("They all completed.");
      });*/

      //while (mid == '' && ptok == '') { $.delay(1000); }
      //var play  = etbase+"/sets/"+ptok+"/play.jsonp"+etkey+"&mix_id="+mid;
      //alert(play);

    /*if (tags != '') {
      
      //$song = play_track ($mid, $ptok, $purl);
    }*/
    }
  });

  // Autocomplete BEGIN
  $(function() {
    $("input#tag").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: etbase + "/tags.jsonp" + etkey + "&q=" + request.term,
          dataType: "jsonp",
          success: function(data) {
            response($.map(data.tags, function(item) {
              return { label: item.name, value: item.name }
            }));
          }
        });
      },
      minLength: 2,
      open: function() { $(this).addClass( "ui-autocomplete-loading" ); },
      close: function() { $(this).removeClass( "ui-autocomplete-loading" ); }
    });
  });
  // Autocomplete END

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
      <div class="span2 visible-desktop">
        <ul class="nav nav-pills nav-stacked">
          <li><a href="./index.php"><i class="icon-home"></i> Home</a></li>
          <li class="active"><a href="./ajax.php"><i class="icon-music"></i> AJAX</a></li>
          <li><a href="./8tracks.php"><i class="icon-headphones"></i> 8Tracks API</a></li>
          <li><a href="./map.php"><i class="icon-map-marker"></i> Google Maps API</a></li>
        </ul>
      </div>
      <div class="span10">
        <h1>8Tracks API</h1>
        
  <?php if (!isset($_REQUEST["tag"]) || ($_REQUEST["tag"] == "")) { ?>
          <form class="form-search" method="post" action="ajax.php">
            <div class="input-append">
              <input type="text" class="input-medium search-query" name="tag" id="tag" placeholder="mood, genre, or artist" autofocus="autofocus" />
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
          <span id="mid">Mid:</span>
          <span id="ptok">Ptok:</span>

          <p class="result"></p>

          <video id="player" class="data" onload="init()"></video>

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
