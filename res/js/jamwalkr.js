$(window).load(function() { 

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

 } );