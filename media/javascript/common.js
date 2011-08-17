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

KODELEARN.getCourseStudents = function(courseId, container){
	
	$('#' + container).html('<p class="tip">Please wait... Loading Course Students</p>');
	
    $.post(KODELEARN.config.base_url + "course/get_students",  {'course_id' : courseId},
            function(data){
    			$('#' + container).html(data.html);
            }, "json");

	
};

