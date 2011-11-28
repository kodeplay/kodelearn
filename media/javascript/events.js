var Events = { };

Events.edit = function(eventId, lectureId) {
    $("#ajax-loader").show();
    $.get(KODELEARN.config.base_url + "event/edit/id/" + eventId + "/lectId/" + lectureId,  {},
          function(resp){
              if (resp.success) {
    	          $('#event_from').remove();
    	          $('#edit_event').html(resp.html);
    	          $("#ajax-loader").hide();
              } else if (resp.reason === 'access_denied') {
                  window.location.href = KODELEARN.config.base_url+'error/access_denied';
              }
          }, "json");
};

Events.save = function() {    
    data = $('#event_form').serializeArray();
    $.post(KODELEARN.config.base_url + "event/edit/",  data, function(data){
    	if(data.success){
    	    var msg = data.message;
    	    KODELEARN.modules.get('ajax_message').showAjaxSuccess($("#event_form"),msg);
    	    setTimeout('window.location.reload()', 2500);
    	} else {
    	    msg = data.errors;
    	    KODELEARN.modules.get('ajax_message').showAjaxError($("#event_form"),msg);
    	}
    }, "json");
};

Events.switchEvent = function(eventId){
    $('#event_from').dialog( "destroy" );
    $('#event_from').remove();
    this.edit(eventId);    
};