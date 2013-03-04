<!--
  map.php

  by Mitchell Goudy
  (mitchell.a.goudy@gmail.com)

  with help from: Casey Chevalier, Ivona Andrzejewski, and Patrick Vargas 

  This file should be helpful for a newcomer to learn some of the features
  the Google Maps API offers, and how they can use it effectively in their
  own applications.
-->

<!DOCTYPE html>
<html lang="en">
  <head>

    <!--
    Some basic styling to define what the map will look like
    -->
    <style type="text/css">
      body, html {
        height: 100%;
        width: 100%;
      }

      div#map_canvas{
        width: 100%; height: 100%;
        margin: 0;
        margin-top: 0px;
        padding: 0;
      }

    </style>

    <!--
    The API itself is hostly reliably by Google. This line is all you need to 
    start using it.
    -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

    <!--
    Here's where we will use the API, and write some functionality for it
    -->
    <script type="text/javascript">
      var map;

      /*  This will wait until the page is fully loaded, then call an 
       *  'initialize' function, which we'll define later. This is
       *  crucial to preventing race conditions as various scripts
       *  are loaded on the page.
       */
      google.maps.event.addDomListener(window, 'load', initialize);

      function initialize() {

        // Init map options
        var mapOptions = {
          // How zoomed in the map will be
          zoom: 14, 
          // The intial center of the map, I chose Boulder here
          center: new google.maps.LatLng(40.0150, -105.2700),
          // What sort of map it will be
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        // Define which element on the page we want our map to associate with
        map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

        //That is actually all we need for a basic map. To make things interesting,
        //let's add some markers to our map.

        // Marker variables
        var id; //id/handle give to each marker so that we may access it later
        var markers = {}; // array of all markers
        var infowindow = new google.maps.InfoWindow(); // A window we can open for each marker

        /*
         *  We need to create a 'listener', a script that will run on the page,
         *  and wait until a action occurs. in this case, I'll listen for a 
         *  right click, and then run some code when that happens
         */
        google.maps.event.addListener(map, "rightclick", function(event) {

          //We can capture the lat/long data of where the right click happened
          var lat = event.latLng.lat();
          var lng = event.latLng.lng();

          //Create a LatLng object. This is really just a simple data structure
          //with a lat and long field that we want ot associate together
          var myLatlng = new google.maps.LatLng(lat, lng);

          //Call an addMarker function to add a marker where we clicked
          addMarker(myLatlng);
        });

        // Add marker function
        var addMarker = function (alatlng) {
          //Define a new marker object          
          marker = new google.maps.Marker({
              //The position we captured earlier
              position: alatlng,
              //The map we've been using
              map: map,
              //Make the marker draggable after it's been placed
              draggable: true,
              //Add a fun animation when it is placed
              animation: google.maps.Animation.DROP
          });

          // Here's some content we're going to associate with the marker, and display when the
          // marker is clicked on
          var contentString = "<h3>Hello!</h3>" + 
                              "<p>This frame can contain any of the HTML content you would put anywhere else on the page</p>"+
                              "<button>Like a button!</button>"+
                              "<input value=' or a text input field'></input>";
          
          // Associate our content with our marker and make a handler for it
          makeInfoWindowEvent(map, infowindow, contentString, marker);

          // Create a unique id for the marker and add it to the marker array
          id = marker.__gm_id
          markers[id] = marker; 

          // Now let's add a listener for when an existing marker is right clicked
          google.maps.event.addListener(marker, "rightclick", function (point) {
            //Recall the id we want with the 'this' handle
            id = this.__gm_id;
            //Call a delete marker function
            delMarker(id);
          });

          // And one more listener for the left click on an existing marker
          google.maps.event.addListener(marker, 'click', function(point) {
            //Recall the id we want with the 'this' handle
            id = this.__gm_id;
            //open an 'infowindow', which will show that content we defined earlier
            infowindow.open(map, markers[id]);
          });
        }

        // Here's the delete function that gets called when you right click a marker
        var delMarker = function (id) {
          //lookup which marker it is we want to kill, from our markers array
          marker = markers[id];
          //And eliminate it!
          marker.setMap(null);
        }

        // Here's where we get our marker ready to display some content when it's clicked
        function makeInfoWindowEvent(map, infowindow, contentString, marker) {
          //Once again, define a page listener for when the marker is clicked
          google.maps.event.addListener(marker, 'click', function() {
            // set what the actual content is we want to display
            infowindow.setContent(contentString);
            //and show it!
            infowindow.open(map, marker);
          });
        }
      }
      /*
      *  That's it!
      *  There are millions of things you can do from here, take a look at the API
      *  docs for more ideas, and good luck! (https://developers.google.com/maps/)
      */
    </script>
  </head>
  <body>
    <!-- Here's the target for all of our map scripting-->
    <div id="map_canvas"></div>

  </body>
</html>