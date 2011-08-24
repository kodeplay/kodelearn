var Events = { };

Events.edit = function(eventId) {
	
    $.post(KODELEARN.config.base_url + "event/edit/id/" + eventId,  {},
            function(html){
    			$('#edit_event').html(html);
            }, "html");
};

Events.test = function() {
	
	alert('testing');
	
};
