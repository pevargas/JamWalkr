<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?>   

   <style type="text/css">
    
  </style>

<?php 
  mysql_connect($mysql_host,$username,$password);
  $con = mysql_connect($mysql_host,$username,$password);       
  if (!$con) {
    die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
  }
  $db = mysql_select_db($database);
  ?>

<?php 
  $sql = 'SELECT * FROM `Buildings` LIMIT 0, 30 ';
  $rs = mysql_query($sql);
    
  if (!$rs) { die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>"); } ?>

  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
  <script type="text/javascript">
$(window).load(function() {
    var lfmbase = "http://ws.audioscrobbler.com/2.0/";
    var lfmkey  = "&api_key=b15a0b92b58b210280fa88c5ae3bd038"; 
    var etbase  = "http://8tracks.com";
    var etkey   = "?api_key=efaea88b3f74c64c06351f6e76674f65bcc23ea0&api_version=2";

    // Music BEGIN
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

function loadMix(tags) {
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
            success: function(data) { mid = data.mixes[0].id; },
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
    }

    var map;
    function initialize() {
      // Init map options
      var mapOptions = {
        zoom: 14,
        center: new google.maps.LatLng(40.0150, -105.2700),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

      // Markers
      var id;
      var markers = {};

      var infowindow = new google.maps.InfoWindow();

      // Add Init markers
      var addInitMarker = function (alatlng, name, id, tagarr, ratingarr) {
          marker = new google.maps.Marker({ 
              position: alatlng,
              map: map,
              draggable: true,
              animation: google.maps.Animation.DROP
          });

          var contentString = "<h3>" + name + "</h3>";
          var first = true;
          var playTags;
          for(var tag in tagarr){
            if (first) { playTags = tagarr[tag]; first = false; }
            else { playTags += "+" + tagarr[tag]; }
            contentString += "<span class='badge badge-jam'>" + tagarr[tag] + " ( " + ratingarr[tag] + " )</span> ";
          }
          contentString += "<p>"+playTags+"</p>";

          contentString += "<div>" +
              "<button class='btn btn-jam control-conatiner pull-left'>" +
                "<i onclick='loadMix("+playTags+")' id='control' class='icon-play icon-white'></i>" +
              "</button>" + 
              "<div class='progress progress-jam progress-striped active'>" +
                "<div class='bar' id='time'><span id='current' class='badge badge-jam'></span></div>" +
              "</div></div>";

          makeInfoWindowEvent(map, infowindow, contentString, marker);

          id = marker.__gm_id
          markers[id] = marker; 

          google.maps.event.addListener(marker, "rightclick", function (point) { 
            id = this.__gm_id; 
            delMarker(id);
          });
          google.maps.event.addListener(marker, 'click', function(point) {
            id = this.__gm_id;
            infowindow.open(map, markers[id]);
          });

          var circleSize = 1;
          for(var tag in tagarr){
             circleSize += Number(ratingarr[tag]);
          }

          var circleOptions = {
              strokeColor: "#8800CC",
              strokeOpacity: 0.8,
              strokeWeight: 2,
              fillColor: "#8800CC",
              fillOpacity: 0.35,
              map: map,
              center: alatlng,
              radius: 50 * circleSize
            };
            musicCircle = new google.maps.Circle(circleOptions);

      }

      // Add markers
      var addMarker = function (alatlng) {
          marker = new google.maps.Marker({ 
              position: alatlng,
              map: map,
              draggable: true,
              animation: google.maps.Animation.DROP
          });

          var contentString = "<form class='addPlace' method='get' action='res/php/add.php'>" + 
            "<input type='text' name='name' placeholder='Name of Building' autofocus='autofocus'/><br/>" +
            "<input type='text' name='tag1' id='tag' placeholder='mood, genre, or artist'/><br/>" +
            "<input type='text' name='tag2' id='tag' placeholder='mood, genre, or artist'/><br/>" +
            "<input type='text' name='tag3' id='tag' placeholder='mood, genre, or artist'/><br/>" +
            "<input type='text' name='lat' value='"+alatlng.lat()+"' style='display:none;'/><br/>" +
            "<input type='text' name='lng' value='"+alatlng.lng()+"' style='display:none;'/>" +
            "<button type='submit' class='btn btn-jam'>Save</button></form>";
          
          makeInfoWindowEvent(map, infowindow, contentString, marker);

          //map.panTo(alatLng);
          id = marker.__gm_id
          markers[id] = marker; 

          google.maps.event.addListener(marker, "rightclick", function (point) { id = this.__gm_id; delMarker(id) });
          google.maps.event.addListener(marker, 'click', function(point) {
            id = this.__gm_id;
            infowindow.open(map, markers[id]);
          });
      }

      // Delete marker on right click
      var delMarker = function (id) {
          marker = markers[id]; 
          marker.setMap(null);
      }

      function makeInfoWindowEvent(map, infowindow, contentString, marker) {
        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent(contentString);
          infowindow.open(map, marker);
        });
      }

      // Right click handler
      google.maps.event.addListener(map, "rightclick", function(event) {
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        var myLatlng = new google.maps.LatLng(lat, lng);
        addMarker(myLatlng);
      });


<?php while($row = mysql_fetch_array($rs)) { ?>
        <?php $sql2 = "SELECT * FROM `Tags` WHERE `building` = '".$row['id']."'";
          $rs2 = mysql_query($sql2);
          if (!$rs2) { die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>"); } 
          ?>
          var tagarr = [];
          var ratingarr = [];
          var i = 0;
        <?php while($row2 = mysql_fetch_array($rs2)) { ?>
            tagarr[i] = "<?=$row2['tag']?>";
            ratingarr[i] = "<?=$row2['rating']?>";
            i++;
        <?php } ?>
        addInitMarker(new google.maps.LatLng(<?=$row['lat']?>, <?=$row['lng']?>), "<?=$row['name']?>", <?=$row['id']?>, tagarr, ratingarr);
<?php } ?>
    
    $("#map_canvas").css("height", window.innerHeight - 40);
  
    }

    google.maps.event.addDomListener(window, 'load', initialize);

  </script>

</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <!-- Button to trigger modal -->
        <a href="#help" role="button" class="btn btn-jam" data-toggle="modal">Need Help?</a>
        <div class="pull-right"><a class="brand" href="./index.php">JamWalkr</a></div>
      </div>
    </div>
  </div>
  
  <span id="msg"></span>
  <video id="player" class="data"></video>
  <div id="map_canvas"></div>
 
  <!-- Modal -->
  <div id="help" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">Welcome to JamWalkr</h3>
    </div>
    <div class="modal-body">
      <p class="lead">What is JamWalkr?</p>
      <p>JamWalkr is a music tagging application. Users are encouraged to tag buildings with moods, genres or artists. As the number of tagged buildings grow, we can see how the citezens of a city thinks their city sounds.</p>

      <p class="lead">How do I participate?</p>
      <p>To add a point, simiply right click and fill out the form. You can view already tagged buildings by clicking on their markers. Please also vote on whether you agree with the tags buy voting up or down the specific tags.</p>
    </div>
    <div class="modal-footer">
      <button class="btn btn-jam" data-dismiss="modal" aria-hidden="true">Start Jammin'</button>
    </div>
  </div>

  <a href="http://www.000webhost.com/" target="_blank" class="host"><img src="http://www.000webhost.com/images/80x15_powered.gif" alt="Web Hosting" width="80" height="15" border="0" /></a>
</body>
</html>
