$(document).ready(function() {
    
    // Confirm Delete
    $('form').submit(function () {
        if ($(this).attr('action').indexOf('delete',1) != -1) {
            if (!confirm ('Delete cannot be undone! Are you sure you want to do this?')) {
                return false;
            }
        }
    });

    KODELEARN.modules.load();    
});

/**
 * KODELEARN is the global namespace
 */
var KODELEARN = KODELEARN || { };

KODELEARN.config = {
    
    base_url:  'http://kodelearn.kp/'
    
};

KODELEARN.modules = {
    
    /**
     * Object containing all modules
     */
    collection: { },

    /**
     * Method to add a module to the collection
     * @param String key unique identifier for the module
     * @param Object module (must have an init function as a property)
     */
    add: function (key, module) {
        this.collection[key] = module;
    },

    /**
     * Method to load all the modules by calling their init method
     * Typically, it will be only called once in the callback of 
     * document.ready event
     */
    load: function () {
        for (var i in this.collection) {
            module = this.collection[i];
            module.init.call(module);
        }
    },

    /**
     * Get the module object from the unique key
     * @param String key
     * @return Object 
     */
    get: function (key) {
        return this.collection[key];
    },

    /**
     * Get all the modules
     * @return Object
     */
    get_collection: function () {
        return this.collection;
    }
};

KODELEARN.modules.add('add_datepicker' , (function () {    
    
    return {
        init: function () { 
    	    $('.date').datepicker({dateFormat: 'yy-mm-dd'});
        }
    }; 
})());

KODELEARN.modules.add('add_timepicker' , (function () {    
    
    return {
        init: function () { 
    	    $('.time').timepicker({});
        }
    }; 
})());

KODELEARN.modules.add('filter', (function () {
    
    return {
	init: function () {
	    
	    $('#trigger_filter').click(function(){
		var url = $('#filter_url').val();
		
		$('input[name*="filter_"]').each(function (){
		    if($(this).val()){
			url += '/' + $(this).attr('name') + '/' + encodeURIComponent($(this).val());
		    }
		});
		location = url;
	    });
	    $('tr.filter td input').keypress(function(e){
		var key;      
		if(window.event)
		    key = window.event.keyCode; //IE
		else
		    key = e.which; //firefox      

		return (key != 13);
	    });
	    
	}
    };
    
})());

KODELEARN.modules.add('toggle_buttons', (function () {
    
    return {
	init: function () {
	    
	    //Toggle buttons
	    $(".toggleButton > a").click(function (ev) {
		$(this).parent().find("a").removeClass("on");
		$(this).addClass("on");
		$(".toggleButton >input").val($(this).attr('data'));
		ev.preventDefault();
	    });
	}
    };
    
})());

KODELEARN.modules.add('time_slider', (function () {
    
    return {
	init: function () {
	    //do something
	},
	getTime: function (hours, minutes) {
    	    var time = null;
    	    minutes = minutes + "";
    	    if (hours < 12) {
    	        time = "AM";
    	    }
    	    else {
    	        time = "PM";
    	    }
    	    if (hours == 0) {
    	        hours = 12;
    	    }
    	    if (hours > 12) {
    	        hours = hours - 12;
    	    }
    	    if (minutes.length == 1) {
    	        minutes = "0" + minutes;
    	    }
    	    return hours + ":" + minutes + " " + time;
    	},
        slideTime: function (event, ui){
            var that = KODELEARN.modules.get('time_slider');
            var minutes0 = parseInt($("#" + event.target.id).slider("values", 0) % 60);
            var hours0 = parseInt($("#" + event.target.id).slider("values", 0) / 60 % 24);
            var minutes1 = parseInt($("#" + event.target.id).slider("values", 1) % 60);
            var hours1 = parseInt($("#" + event.target.id).slider("values", 1) / 60 % 24);
            $("#" + event.target.id + "_from").val(parseInt($("#" + event.target.id).slider("values", 0)));
            $("#" + event.target.id + "_to").val(parseInt($("#" + event.target.id).slider("values", 1)));
            $("#" + event.target.id + "_time").text(that.getTime(hours0, minutes0) + ' - ' + that.getTime(hours1, minutes1));
        }		
    };

})());

;
KODELEARN.modules.add('course', (function () {
    
    return {
	init: function () {
	    //do something
	},
	getCourseStudents : function(courseId, container){
	    
	    $('#' + container).html('<p class="tip">Please wait... Loading Course Students</p>');
	    
	    $.post(KODELEARN.config.base_url + "course/get_students",  {'course_id' : courseId},
		   function(data){
		       $('#' + container).html(data.html);
		   }, "json");

	    
	}
    };

})());
KODELEARN.modules.add('ajax_message', (function () {
    return {
	init : function () {
	    
	},
	showAjaxError: function (beforeDiv,msgArr){
	    
	    $('#warning').remove();
	    var warning = '<div class="block-error" id="error"><ul>';
	    
	    for(var i = 0; i < msgArr.length ; i++ ){		
		warning += '<li>'+msgArr[i]+'</li>';	
	    }		
	    
	    warning += '</ul></div>';
	    beforeDiv.before(warning);
	    scroll(0,0);
	    $('#error').slideDown(200);
	    setTimeout('$("#error").slideUp()', 3000);
	    
	},
	showAjaxSuccess : function (beforeDiv,msgArr){
	    
	    $('#warning').remove();
	    var warning = '<div class="block-success" id="success"><ul>';
	    
	    for(var i = 0; i < msgArr.length ; i++ ){		
		warning += '<li>'+msgArr[i]+'</li>';	
	    }		
	    
	    warning += '</ul></div>';
	    beforeDiv.before(warning);
	    scroll(0,0);
	    $('#success').slideDown(200);
	    setTimeout('$("#success").slideUp()', 2000);
	    
	}	
    };
})());

KODELEARN.modules.add('rooms', (function () {
    
    return {
	init: function () {
	    //do something
	},
	getAvaliableRooms: function (data){
	    $('#loading').fadeIn();
	    var data = $('form').serializeArray();
	    $.post(KODELEARN.config.base_url + "event/get_avaliable_rooms",  data, function(data){
		$('select[name="room_id"]').replaceWith(data.element);
		$('#loading').fadeOut();
	    }, "json");
	}
    };

})());


function ajaxRequest(controller,action){	
    
    var l = new ajaxLoad({
	'controller' : controller,
	'action' : action
    });	    
}

KODELEARN.modules.add('calendar', (function () {
    
    return {

	init: function () {
            this.day_events();
            this.ajaxify();
            this.jumper();
	},

        day_events: function () {
            var $days = $(".calendar>tbody>tr>td"),
            $eventlist = $("#day-events");
	    $days.unbind('click').bind('click', function () {
                var html = $(this).data('events_html');
                $days.removeClass('curr');
                // if cached, inject into the container and return
                if (html) {
                    $(this).addClass('curr');
                    $eventlist.html(html);
                    return true;
                }
                var id = $(this).attr('id'),
                date = id.split('-').slice(1),
                year = date[0],
                month = date[1],
                day = date[2],
                // supress request in case no event present
                events = $(this).children().filter('ul').length,
                that = this;
                if (events) {
                    var request = new ajaxLoad({
                        'container': '#day-events',
                        'controller': 'calendar',
                        'action': 'day_events/year/'+year+'/month/'+month+'/day/'+day,
                        'callback': function (resp) { 
                            // cache results (entire html) in data
                            $(that).data('events_html', resp).addClass('curr');
                        }                        
                    });
                } else {
                    $eventlist.html('<h1>Events for '+date.join('-')+'</h1><ul><li>No events scheduled.</li></ul>');
                }
            });
        },

        /**
         * Method to convert the prev and next month links to ajax actions
         */
        ajaxify: function () {
            var $prev = $(".calendar>caption>span.prev>a"),
            $next = $(".calendar>caption>span.next>a"),
            urlhelper = KODELEARN.helpers.url,
            that = this,
            cb = function (e) {
                e.preventDefault();
                var month = urlhelper.get_param('month', $(this).attr('href')),
                year = urlhelper.get_param('year', $(this).attr('href'));
                new ajaxLoad({
                    'container': '#calendar-wrapper',
                    'controller': 'calendar',
                    'action': 'calendar?month='+month+'&year='+year,
                    'callback': function (resp) {
                        that.day_events();
                        that.ajaxify();
                    }
                });
            };
            $next.unbind('click').bind('click', cb);
            $prev.unbind('click').bind('click', cb);
        },

        jumper: function () {
            var that = this;
            $("#calendar-jumper>a.button").click(function () {
                var month = $("select[name='jump_month']").val(),
                year = $("select[name='jump_year']").val();
                new ajaxLoad({
                    'container': '#calendar-wrapper',
                    'controller': 'calendar',
                    'action': 'calendar?month='+month+'&year='+year,
                    'callback': function (resp) {
                        that.day_events();
                        that.ajaxify();
                    }
                });
            });
        }
    };
    
})());

KODELEARN.modules.add('post', (function () {
    return {
        init : function () {
            $("select[name='post_setting']", "#post-form").change(function () {
                $(this).siblings().addClass('hidden');
                var setting = $(this).val();
                $(this).siblings().filter('select').attr('disabled', true);
                switch (setting) {
                case "batch":
                    $(this).siblings().filter('select[name=\'batch\']').removeClass('hidden').attr('disabled', false);
                    $(this).siblings().filter('ul').removeClass('hidden');
                    break;
                case "course":
                    $(this).siblings().filter('select[name=\'course\']').removeClass('hidden').attr('disabled', false);
                    $(this).siblings().filter('ul').removeClass('hidden');
                    break;
                case "role":
                    $(this).siblings().filter('ul').removeClass('hidden');
                    break;
                case "everyone":
                default:
                    var a = $('input[type=\'checkbox\']', "#post-form").attr('checked', false);
                    $(this).siblings().addClass('hidden');
                    break;
                }
            }).trigger('change');
            $("a.button", "#post-form").click(function () {
                var formdata = $("form[name='post_status']").serializeArray();
                $.ajax({
                    url: KODELEARN.config.base_url+"post/add/",
                    type: "POST",
                    dataType: "html",
                    data: formdata,
                    async: false,
                    success: function (resp) {
                        alert('ho');
                    }                    
                });
            });
        }
    }
})());

KODELEARN.helpers = { };

KODELEARN.helpers.url = {
    
    // get the GET params from the url as an object
    get_param: function (name, url) {
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regexS = "[\\?&]" + name + "=([^&#]*)";
        var regex = new RegExp(regexS);
        url = !url ? window.location.href : url;
        var results = regex.exec(url);
        if (results == null) {
            return "";
        }
        else {
            return decodeURIComponent(results[1].replace(/\+/g, " "));
        }
    }
}

var Feeds = { };

Feeds.show = function(d,m,y) {
	$("#ajax-loader").show();
	$.get(KODELEARN.config.base_url + "calendar/day_events/year/"+ y +"/month/"+ m +"/day/"+ d,  {},	
        function(html){
		    $('#feed_event').html(html);
		    $("#ajax-loader").hide();
		
        }, "html");
	$( "#feed_event" ).dialog({
        resizable: false,
        modal: true,
        title: "Event for "+d+" - "+m+" - "+y
    });return false;
};
