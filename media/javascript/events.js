var Events = { };

Events.edit = function(eventId) {
	$("#ajax-loader").show();
    $.get(KODELEARN.config.base_url + "event/edit/id/" + eventId,  {},
            function(html){
    			$('#event_from').remove();
    			$('#edit_event').html(html);
    			$("#ajax-loader").hide();
            }, "html");
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