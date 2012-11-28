<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
  <script>
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
      // Add markers
      var addMarker = function (alatLng) {
          marker = new google.maps.Marker({ 
              position: alatLng,
              map: map,
              draggable: true,
              animation: google.maps.Animation.DROP
          });
          //map.panTo(alatLng);
          id = marker.__gm_id
          markers[id] = marker; 


          google.maps.event.addListener(marker, "rightclick", function (point) { id = this.__gm_id; delMarker(id) });
      }

      // Delete marker on right click
      var delMarker = function (id) {
          marker = markers[id]; 
          marker.setMap(null);
      }

      // Right click handler
      google.maps.event.addListener(map, "rightclick", function(event) {
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        var myLatlng = new google.maps.LatLng(lat, lng);
        addMarker(myLatlng);
      });

    }
    google.maps.event.addDomListener(window, 'load', initialize);
  </script>
  <style>
    #map_canvas {
      margin: 0;
      padding: 0;
      height: 400px;
      width: 500px;
    }
  </style>
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
      	<a class="brand" href="./index.php">JamWalkr</a>
      	<ul class="nav">
      	  <li><a href="./index.php"><i class="icon-home icon-white"></i></a></li>
      	  <li><a href="./lfm.php"><i class="icon-music icon-white"></i></a></li>
      	  <li><a href="./8tracks.php"><i class="icon-headphones icon-white"></i></a></li>
      	  <li class="active"><a href="./map.php"><i class="icon-map-marker icon-white"></i></a></li>
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
      	  <li><a href="./8tracks.php"><i class="icon-headphones"></i> 8Tracks API</a></li>
      	  <li class="active"><a href="./map.php"><i class="icon-map-marker"></i> Google Maps API</a></li>
      	  <li><a href="./database.php"><i class="icon-hdd"></i> MySQL Database</a></li>
      	</ul>
      </div>
      <div class="span9">
    	  <h1>Google Maps API</h1>
    	  <div id="map_canvas" width="500" height="500"></div>
      </div>
    </div>
  </div>
</body>
</html>
