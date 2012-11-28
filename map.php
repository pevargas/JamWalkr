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
      var addInitMarker = function (alatlng, name, id, tag1, tag2, tag3) {
          marker = new google.maps.Marker({ 
              position: alatlng,
              map: map,
              draggable: true,
              animation: google.maps.Animation.DROP
          });

          var contentString = "<h2>" + name + "</h2>";          
          makeInfoWindowEvent(map, infowindow, contentString, marker);

          //id = marker.__gm_id
          markers[id] = marker; 

          google.maps.event.addListener(marker, "rightclick", function (point) { id = this.__gm_id; delMarker(id) });
          google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
          });
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
            "<input type='text' name='tag1' placeholder='Tag 1'/><br/>" +
            "<input type='text' name='tag2' placeholder='Tag 2'/><br/>" +
            "<input type='text' name='tag3' placeholder='Tag 3'/><br/>" +
            "<input type='text' name='lat' value='"+alatlng.lat()+"' style='display:none;'/><br/>" +
            "<input type='text' name='lng' value='"+alatlng.lng()+"' style='display:none;'/>" +
            "<button type='submit' class='btn btn-primary'>Save</button></form>";
          
          makeInfoWindowEvent(map, infowindow, contentString, marker);

          //map.panTo(alatLng);
          id = marker.__gm_id
          markers[id] = marker; 

          google.maps.event.addListener(marker, "rightclick", function (point) { id = this.__gm_id; delMarker(id) });
          google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
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
        addInitMarker(new google.maps.LatLng(<?=$row['lat']?>, <?=$row['lng']?>), "<?=$row['name']?>", <?=$row['id']?>, "tag1", "tag2", "tag3");
<?php } ?>
    }

    google.maps.event.addDomListener(window, 'load', initialize);
  </script>

  <style type="text/css">
    #map_canvas {
      margin: 0;
      padding: 0;
      height: 400px;
      width: 100%;
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
      	  <li><a href="./8tracks.php"><i class="icon-headphones icon-white"></i></a></li>
      	  <li class="active"><a href="./map.php"><i class="icon-map-marker icon-white"></i></a></li>
      	</ul>
      </div>
    </div>
  </div>
  
  <div class="container-fluid" style="margin-top: 50px;">
    <div class="row-fluid">
      <div class="span2 visible-desktop">
      	<ul class="nav nav-pills nav-stacked">
      	  <li><a href="./index.php"><i class="icon-home"></i> Home</a></li>
      	  <li><a href="./8tracks.php"><i class="icon-headphones"></i> 8Tracks API</a></li>
      	  <li class="active"><a href="./map.php"><i class="icon-map-marker"></i> Google Maps API</a></li>
      	</ul>
      </div>
      <div class="span7">
    	  <h1>Google Maps API</h1>
    	  <div id="map_canvas"></div>
      </div>
      <div class="span3">
      <?php 
        $sql = 'SELECT * FROM `Buildings` LIMIT 0, 30 ';
        $rs = mysql_query($sql);
        
        if (!$rs) { die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>"); } ?>

        <ul>
          <?php while($row = mysql_fetch_array($rs)) { ?>
            <li>
              <strong><?=$row['name'];?></strong> (<?=$row['lat']?>,<?=$row['lng']?>)
              <?php $sql2 = "SELECT * FROM `Tags` WHERE `building` = '".$row['id']."'";
                $rs2 = mysql_query($sql2);
                if (!$rs2) { die("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Error: </strong>" . mysql_error() . "</strong></div>"); } 
                $tags = '';  ?>
                <ul>
                <?php while($row2 = mysql_fetch_array($rs2)) { $tags += $row2['tag']; ?>
                  <li><?=$row2['tag'];?></li>
                <?php } ?>
                </ul>
                <form class="form-search" method="post" action="8tracks.php">
                <input type="text" name="tag" value=/>
                <button type="submit" class="btn">Music!</button></div>
          </form>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</body>
</html>
