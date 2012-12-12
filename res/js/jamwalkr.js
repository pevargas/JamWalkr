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
        },
        open: function() { $(".brand").addClass( "ui-autocomplete-loading" ); },
        close: function() { $(".brand").removeClass( "ui-autocomplete-loading" ); }
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
          },
          open: function() { $(".brand").addClass( "ui-autocomplete-loading" ); },
          close: function() { $(".brand").removeClass( "ui-autocomplete-loading" ); }
        });
    }
    window.setTimeout (function() { listen(data, mid, ptok); }, 1000);
  }

  function getArt(mid) {
    var mix = etbase + "/mixes/" + mid + ".jsonp" + etkey;
    $.ajax({
      url: mix,
      dataType: "jsonp",
      success: function(data) {
        $("#msg").append("<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button><strong>Success!</strong></div>");
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $("#msg").append("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
      }
    });
  }

  function toggleMusic() {
    var player = document.getElementById('player');
    var button = document.getElementById('control');
    if (player.paused) { player.play(); button.setAttribute("class", "icon-pause icon-white"); }
    else { player.pause(); button.setAttribute("class", "icon-play icon-white"); }
  }
  // Music END

  // Autocomplete BEGIN
  $(function() {
    $("#tag").autocomplete({
      source: function(request, response) {
        $.ajax({
          url: etbase + "/tags.jsonp" + etkey + "&q=" + request.term,
          dataType: "jsonp",
          success: function(data) {
            response($.map(data.tags, function(item) {
              return { label: item.name, value: item.name }
            }));
          },
          error: function(jqXHR, textStatus, errorThrown) {
            $("#msg").append("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
          }
        });
      },
      minLength: 2,
      open: function() { $(this).addClass( "ui-autocomplete-loading" ); },
      close: function() { $(this).removeClass( "ui-autocomplete-loading" ); }
    });
  });
  // Autocomplete END
});