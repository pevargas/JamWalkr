$(function() { 

  // Function that updates time; Also reports back to Sound Exchange.
  $("video").bind("timeupdate", function() {
    var timepast = this.currentTime;
    var duration = this.duration;
    // Width as a percentage for the visual aspect
    var width    = String(100*(timepast / duration));
    // Display time in human time
    var minutes  = parseInt(timepast / 60)%60;
    var seconds  = parseInt(timepast)%60;
    $("#current").html(minutes +":"+(seconds < 10 ? "0" + seconds : seconds));
    document.getElementById("time").setAttribute("style", "width:" + width + "%");

    if (30.0 < timepast && !reported) {
      var report = etbase+"/sets/"+ptok+"/report.jsonp"+etkey+"&mix_id="+mid+"&track_id="+gData.set.track.id;
      $.ajax({
        url: report,
        dataType: "jsonp",
        success: function() {
          console.log("Reported \""+gData.set.track.name+"\" to SoundExchange.");
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $("#msg").append("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
        },
        open: function() { $("#brand").addClass( "ui-autocomplete-loading" ); },
        close: function() { $("#brand").removeClass( "ui-autocomplete-loading" ); }
      });
      reported = true;
    }
  }); // time update function

  // Grabs next song once finished.
  $("video").bind("ended", function(){
    // Debugging
    var next = etbase+"/sets/"+ptok+ (gData.set.at_last_track ? "/next_mix.jsonp" : "/next.jsonp") +etkey+"&mix_id="+mid;
    $.ajax({
      url: next,
      dataType: "jsonp",
      success: function(data) { 
        gData = data;
        $("video").attr("src", data.set.track.url);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        $("#msg").append("<div class='alert alert-error fade in'><button type='button' class='close' data-dismiss='alert'>×</button><strong>"+textStatus+"</strong> "+errorThrown+"</div>");
      },
      open: function() { $("#brand").addClass( "ui-autocomplete-loading" ); },
      close: function() { $("#brand").removeClass( "ui-autocomplete-loading" ); }
    });
  }); // song ended function

  // Song changed so update information
  $("video").bind("durationchange", function(){
    // Reset reported flag
    reported = false;
    // Autoplay song
    $("video").get(0).play();
    //$("#msg").append("<img src='"+getArt(mid)+"'/>");
    // Make sure button is correct state
    var button = document.getElementById('control');
    button.setAttribute("class", "icon-pause icon-white");
    // Update track info
    $("#info").html("<i class='icon-music icon-white'></i> "+gData.set.track.name+" <i class='icon-user icon-white'></i> "+gData.set.track.performer + " <i class='icon-volume-up icon-white'></i> "+bName);
  }); // Updated track information function

  // Bind the space bar to toggle music
  $('body').keyup(function(e){
    if(e.keyCode == 32) { // user has pressed space
      toggleMusic();
    }
  });
  // Music END

  // Autocomplete BEGIN
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
  // Autocomplete END
});