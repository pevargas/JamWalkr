<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    include("res/php/auth.php");
    include("res/php/loadfunc.php"); 
    include("res/php/links.php");
  ?>

  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
  <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js"></script>

  <script>
  $(function () {
    function dist (lat1, lon1, lat2, lon2) {
      var R = 6371; // km
      console.log('('+lat1+', '+lon1+') ('+lat2+', '+lon2+')');
      lat1 = lat1 * (Math.PI / 180);
      lon1 = lon1 * (Math.PI / 180);
      lat2 = lat2 * (Math.PI / 180);
      lon2 = lon2 * (Math.PI / 180);
      var d = Math.acos(Math.sin(lat1)*Math.sin(lat2) + 
                  Math.cos(lat1)*Math.cos(lat2) *
                  Math.cos(lon2-lon1)) * R;

      return (d * 0.621371).toFixed(2); // Convert to miles
    }

    $.ajax({
      url: 'res/php/newquery.php', 
      data: '',
      dataType: 'json',
      success: function(data) {
        console.log(data);
        for (var i = 0; i < data.length; ++i) {
          $('#output').append('<li>' + data[i].name + ' | ' + dist(40.0150, -105.2700, data[i].lat, data[i].lng) + 'mi</li>'); 
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $(".msg").append("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
      }
    });
  }); 

  </script>
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
	<a class="brand" href="./index.php">JamWalkr</a>
	<ul class="nav">
	  <li><a href="./index.php"><i class="icon-home icon-white"></i></a></li>
	  <li class="active"><a href="./lfm.php"><i class="icon-music icon-white"></i></a></li>
	  <li><a href="./8tracks.php"><i class="icon-headphones icon-white"></i></a></li>
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
      	  <li class="active"><a href="./lfm.php"><i class="icon-music"></i> Last.fm API</a></li>
      	  <li><a href="./8tracks.php"><i class="icon-headphones"></i> 8Tracks API</a></li>
      	  <li><a href="./map.php"><i class="icon-map-marker"></i> Google Maps API</a></li>
      	  <li><a href="./database.php"><i class="icon-hdd"></i> MySQL Database</a></li>
      	</ul>
      </div>
      <div class="span9">
      	<h1>Mobile</h1>
        <p class="msg"></p>
        <ul id="output" data-role="listview">
        </ul>
      </div>
    </div>
  </div>
</body>
</html>
