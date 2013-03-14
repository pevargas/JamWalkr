<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?> 

<?php 
  mysql_connect($mysql_host,$username,$password);
  $con = mysql_connect($mysql_host,$username,$password);       
  if (!$con) {
    die("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>");
  }
  $db = mysql_select_db($database);
  ?>

<?php 
  $sql = 'SELECT * FROM `Buildings` LIMIT 0, 30 ';
  $rs = mysql_query($sql);
    
  if (!$rs) { die("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>"); } ?>

  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>
  <script type="text/javascript">

  /* Functions involved with music BEGIN */
  // Global Variables involved in playing music
  var reported = false;
  var mid      = '';
  var ptok     = '';
  var gData    = {};
  var bName    = 'Building Name';
  // API keys and information
  var lfmbase  = "http://ws.audioscrobbler.com/2.0/";
  var lfmkey   = "&api_key=b15a0b92b58b210280fa88c5ae3bd038"; 
  var etbase   = "http://8tracks.com";
  var etkey    = "?api_key=efaea88b3f74c64c06351f6e76674f65bcc23ea0&api_version=2";

  function loadMix(tag, name) {
    // encode tags in URL formating
    var tags = encodeURIComponent(tag);

    // Make sure there are tags
    if (tags != null) { 
      // Build ajax url string
      var sear    = "&tag=" + tags + "&sort=popular";
      var mix     = etbase + "/mixes.jsonp" + etkey + sear;
      var purl    = etbase + "/sets/new.jsonp" + etkey;

      $.when(
        $.ajax({ // Grab the mix id
          url: mix,
          dataType: "jsonp",
          success: function(data) {
            console.log(data);
            if (data.total_entries >= 1) {
              mid = data.mixes[0].id;
              console.log("Grabbed Mix ID: " + data.mixes[0].name + " ("+mid+")");
            } else {
              $("#msg").append("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>8Tracks Error</strong> Unable to find playlist with those tags.</div>");  
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $("#msg").append("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
          },
          open: function() { $("#brand").addClass( "ui-autocomplete-loading" ); },
          close: function() { $("#brand").removeClass( "ui-autocomplete-loading" ); }
        }), $.ajax({ // Grab the play token
          url: purl,
          dataType: "jsonp",
          success: function(data) { 
            ptok = data.play_token; 
            console.log("Grabbed Play Token: "+ptok);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $("#msg").append("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
          },
          open: function() { $("#brand").addClass( "ui-autocomplete-loading" ); },
          close: function() { $("#brand").removeClass( "ui-autocomplete-loading" ); }
        })
      ).done(function(a1, a2){ // Make sure both ajax calls complete successfully
        // Construct call play url string
        var play  = etbase+"/sets/"+ptok+"/play.jsonp"+etkey+"&mix_id="+mid;
        $.ajax({ // Get current track
          url: play,
          dataType: "jsonp",
          success: function(data) {
            gData = data;
            $("video").attr("src", data.set.track.url);
            bName = name;
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $("#msg").append("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
          },
          open: function() { $("#brand").addClass( "ui-autocomplete-loading" ); },
          close: function() { $("#brand").removeClass( "ui-autocomplete-loading" ); }
        });
      });
    }
  } // loadMix()

  // Play/Pause Button
  function toggleMusic() {
    var player = document.getElementById('player');
    var button = document.getElementById('control');
    if (player.paused) { player.play(); button.setAttribute("class", "icon-pause icon-white"); }
    else { player.pause(); button.setAttribute("class", "icon-play icon-white"); }
  } // toggleMusic()
  /* Functions involved with music END */

  /* Functions involved with voting BEGIN */
  function upVote(tid) {
    $.ajax({
      url: "res/php/upvote.php",
      data: "tid="+tid,
      success: function(data) {
        $("#msg").append("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Thank you!</strong> Your vote has been recieved</div>");
        console.log(data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $("#msg").append("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
      },
      open: function() { $("#brand").addClass( "ui-autocomplete-loading" ); },
      close: function() { $("#brand").removeClass( "ui-autocomplete-loading" ); }
    });
  } // upVote()

  function dnVote(tid) {
    $.ajax({
      url: "res/php/dnvote.php",
      data: "tid="+tid,
      success: function(data) {
        $("#msg").append("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Thank you!</strong> Your vote has been recieved.</div>");
        console.log(data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $("#msg").append("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
      },
      open: function() { $("#brand").addClass( "ui-autocomplete-loading" ); },
      close: function() { $("#brand").removeClass( "ui-autocomplete-loading" ); }
    });
  } // dnVote()
  /* Functions involved with voting END */

  // Add a Building
  function addBuilding() {
    var name = "name="  + encodeURIComponent($("input#name").val());
    var tag1 = "&tag1=" + encodeURIComponent($("input#tag1").val());
    var tag2 = "&tag2=" + encodeURIComponent($("input#tag2").val());
    var tag3 = "&tag3=" + encodeURIComponent($("input#tag3").val());
    var lat  = "&lat="  + $("input#lat").val();
    var lng  = "&lng="  + $("input#lng").val();
    $.ajax({
      url: "res/php/add.php",
      data: name+tag1+tag2+tag3+lat+lng,
      success: function(data) {
        $("#msg").append("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Thank you!</strong> The building has been created.</div>");
        console.log(data);

        var lat       = data[0];
        var lng       = data[1];
        var name      = data[2];
        var id        = data[3];
        var tagarr    = data[4]; 
        var ratingarr = data[5]; 
        var tidarr    = data[6];

        var first = true;
        var playTags;
        var dispTags = "";
        for(var tag in tagarr){
          if (first) { playTags = tagarr[tag]; first = false; }
          else if (tag < 3) { playTags += "+" + tagarr[tag]; }
          dispTags += "<p><span class='label label-jam'><a href='#' onclick='upVote("+tidarr[tag]+")'><i class='icon-white icon-thumbs-up'></i></a>";
          dispTags += " [ " + ratingarr[tag] + " ] ";
          dispTags += "<a href='#' onclick='dnVote("+tidarr[tag]+")'><i class='icon-white icon-thumbs-down'></i></a></span>";
          dispTags += "<span class='badge badge-jam'>" + tagarr[tag] + "</span></p>";
        }
        var contentString = "<div>" +
          "<button class='btn btn-jam' onclick='loadMix(\""+playTags+"\", \""+name+"\")'>" +
            "<h3>" + name + "<i class='icon-white icon-chevron-right'></i></h3>" +
          "</button></div>";
        contentString += dispTags;

        $("#output").html(contentString);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $("#msg").append("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
      },
      open: function() { $("#brand").addClass( "ui-autocomplete-loading" ); },
      close: function() { $("#brand").removeClass( "ui-autocomplete-loading" ); }
    });
  } // addBuilding()
  
/* Start of map code */

    /* Find where user is, specifically ask for it */
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(success);
    } else {
      error('Geo Location is not supported');
    }
    var usrLat;
    var usrLng;
    var usrLatLng;
    var geocoder;
    var geoAddress;
    function success(position) {
      usrLat = position.coords.latitude;
      usrLng = position.coords.longitude;
      usrLatLng = new google.maps.LatLng(usrLat, usrLng);
      geocoder = new google.maps.Geocoder();
      geocoder.geocode({'latLng': usrLatLng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[1]) {
            geoAddress = results[0].formatted_address;
            initialize();
          }
        } else {
          console.log("Geocoder failed due to: " + status + "\n usrLat: " + usrLat +"\n usrLng: " + usrLng);
        }
      });
    }
    /* End of user geolocation*/

    var map;
    function initialize() {
      // Init map options
      var mapOptions = {
        zoom: 16,
        center: new google.maps.LatLng(usrLat, usrLng),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

      // Markers
      var id;
      var markers = {};

      var infowindow = new google.maps.InfoWindow();

      // Add Init markers
      var addInitMarker = function (alatlng, name, id, tagarr, ratingarr, tidarr) {

          var image = "jam.png";
          marker = new google.maps.Marker({ 
              position: alatlng,
              map: map,
              icon: image,
              animation: google.maps.Animation.DROP
          });

          var first = true;
          var playTags;
          var dispTags = "";
          for(var tag in tagarr){
            if (first) { playTags = tagarr[tag]; first = false; }
            else { playTags += "+" + tagarr[tag]; }
            dispTags += "<p><span class='label label-jam'><a href='#' onclick='upVote("+tidarr[tag]+")'><i class='icon-white icon-thumbs-up'></i></a>";
            dispTags += " [ " + ratingarr[tag] + " ] ";
            dispTags += "<a href='#' onclick='dnVote("+tidarr[tag]+")'><i class='icon-white icon-thumbs-down'></i></a></span>";
            dispTags += "<span class='badge badge-jam'>" + tagarr[tag] + "</span></p>";
          }
          var contentString = "<div>" +
            "<button class='btn btn-jam' onclick='loadMix(\""+playTags+"\", \""+name+"\")'>" +
              "<h3>" + name + "<i class='icon-white icon-chevron-right'></i></h3>" +
            "</button></div>";
          contentString += dispTags;

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
          // Circle size proportional to ratings
          for(var tag in tagarr){ circleSize += Number(ratingarr[tag]); }

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


      } // addInitMarker()

      // Add markers
      var addMarker = function (alatlng) {
          var image = "jam.png";
          marker = new google.maps.Marker({ 
              position: alatlng,
              map: map,
              draggable: false,
              icon: image,
              animation: google.maps.Animation.DROP
          });

          var geocoder = new google.maps.Geocoder();
          var geoAddress;
          geocoder.geocode({'latLng': alatlng}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              if (results[1]) {
                geoAddress = results[0].formatted_address;
                var contentString = "<div id='output'>" +
                "<h2>When you're at...</h2>"+ 
                "<input type='text' name='name' id='name' value='"+ geoAddress + "' autofocus='autofocus'/><br/>" +
                "<p class='lead'>...what does it remind you of?</p>"+
                "<input type='text' name='tag1' id='tag1' placeholder='mood, genre, or artist' required='required'/><br/>" +
                "<input type='text' name='tag2' id='tag2' placeholder='mood, genre, or artist'/><br/>" +
                "<input type='text' name='tag3' id='tag3' placeholder='mood, genre, or artist'/><br/>" +
                "<input type='text' name='lat' id='lat' value='"+alatlng.lat()+"' style='display:none;'/><br/>" +
                "<input type='text' name='lng' id='lng' value='"+alatlng.lng()+"' style='display:none;'/>" +
                "<button type='submit' onclick='addBuilding()' class='btn btn-jam'>Save</button></div>";
              
                makeInfoWindowEvent(map, infowindow, contentString, marker);
              }
            } else {
              console.log("Geocoder failed in addMarker due to: " + status);
            }
          });
          
          //map.panTo(alatLng);
          id = marker.__gm_id
          markers[id] = marker; 

          google.maps.event.addListener(marker, "rightclick", function (point) { id = this.__gm_id; delMarker(id) });
          google.maps.event.addListener(marker, 'click', function(point) {
            id = this.__gm_id;
            infowindow.open(map, markers[id]);
          });
      } // addMarker()

      

      function makeInfoWindowEvent(map, infowindow, contentString, marker) {
        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent(contentString);
          infowindow.open(map, marker);
        });
      } // makeInfoWindowEvent()

      // Right click handler
      google.maps.event.addListener(map, "rightclick", function(event) {
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        var myLatlng = new google.maps.LatLng(lat, lng);
        addMarker(myLatlng);
      });

      

      // Retrieve information to be displayed in infopane from database. Gets lat, long, name, id, and the related tags (and their ratings)
<?php while($row = mysql_fetch_array($rs)) { ?>
        <?php $sql2 = "SELECT * FROM `Tags` WHERE `building` = '".$row['id']."'";
          $rs2 = mysql_query($sql2);
          if (!$rs2) { die("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>"); } 
          ?>
          var tagarr    = [];
          var ratingarr = [];
          var tidarr    = [];
          var i         = 0;
        <?php while($row2 = mysql_fetch_array($rs2)) { ?>
            tagarr[i] = "<?=$row2['tag']?>";
            ratingarr[i] = "<?=$row2['rating']?>";
            tidarr[i] = "<?=$row2['id']?>";
            i++;
        <?php } ?>
        addInitMarker(new google.maps.LatLng(<?=$row['lat']?>, <?=$row['lng']?>), "<?=$row['name']?>", <?=$row['id']?>, tagarr, ratingarr, tidarr);
<?php } ?>

    
    
    
    /* Assign map to be entirty of window */
    $("#map_canvas").css("height", window.innerHeight - 40);
    $("#map_canvas").css("width", window.innerWidth);

     $(document).ready(function() {
        // Add user's marker
        console.log("Adding user location" + usrLatLng);
        addMarker(usrLatLng);
      });
  
    } // initialize()

    /* Assign map to be entirty of window on resize BEGIN */
    window.onresize = function() {
      $("#map_canvas").css("height", window.innerHeight - 40);
      $("#map_canvas").css("width", window.innerWidth);
    }
    /* Assign map to be entirty of window on resize END */

    google.maps.event.addDomListener(window, 'load', initialize);

   

  </script>

</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <!-- Button to trigger modal -->
        <div class="row-fluid">
          <div class="span3 track">
            <button class="btn btn-jam control-conatiner pull-left">
              <i onclick="toggleMusic()" id="control" class="icon-white"></i>
            </button>
            <div class="progress progress-jam progress-striped active">
              <div class="bar" id="time"><span id="current" class="badge badge-jam">0:00</span></div>
            </div>
          </div>
          <div class="span6 info" id="info">
            <i class="icon-music icon-white"></i> Track Name <i class="icon-user icon-white"></i> Artist <i class="icon-volume-up icon-white"></i> You're listening to the sounds of <strong>Building Name</strong>
          </div>
          <div class="span3">
            <a href="#help" role="button" class="btn btn-jam" data-toggle="modal" id="helpBtn">Need Help?</a>
            <div class="pull-right"><a class="brand" id="brand" href="./index.php">JamWalkr</a></div>
          </div>
        </div>
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
      <p>JamWalkr is a music tagging application. Users are encouraged to tag buildings with moods, genres or artists. As the number of tagged buildings grow, we can see how the citizens of a city thinks their city sounds.</p>

      <p class="lead">How do I participate?</p>
      <p>To add a point, simiply right click and fill out the form. You can view already tagged buildings by clicking on their markers. Please also vote on whether you agree with the tags by voting up or down the specific tags.</p>
    </div>
    <div class="modal-footer">
      <button class="btn btn-jam" data-dismiss="modal" aria-hidden="true">Start Jammin'</button>
    </div>
  </div>
  <a href="http://www.000webhost.com/" target="_blank" class="host"><img src="http://www.000webhost.com/images/80x15_powered.gif" alt="Web Hosting" width="80" height="15" border="0" /></a>
</body>
</html>
