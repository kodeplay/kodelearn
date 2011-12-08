$(document).ready(function() {

    // Confirm Delete
    $('form').submit(function (event) {
        if ($(this).hasClass('selection-required') && $("input[type='checkbox']:checked").length === 0) {
            alert('Please select atleast 1 entry and try again');
            return false;
        }
        if ($(this).attr('action').indexOf('delete',1) != -1) {
            if (!confirm ('Delete cannot be undone! Are you sure you want to do this?')) {
                return false;
            }
        }
    });

    KODELEARN.modules.load();

    if($('#filter').val()){
        $("#filter_select").val($('#select_val').val());
    }

    $('.ui-icon-closethick').live('click', function(){
        $('.lightoverlay').hide();
    });

});

/**
 * KODELEARN is the global namespace
 */
var KODELEARN = KODELEARN || { };

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

KODELEARN.modules.add('sidebar' , (function () {
    return {
        el: $('.sidebar'),
        init: function () {
                // var win = $(window);
                // var el = $('.sidebar');
                // if(el.size()){
                //      window.onscroll = function() {
                //              var eltop = el.position().top;
                //              var winscroll = win.scrollTop();
                //              var adminbar = $(".roleContainer").outerHeight();
                //              if(adminbar === "NaN") {
                //                      adminbar = 0;
                //              }
                //              if(winscroll > (178 + +adminbar)){
                //                      el.css({position: 'fixed', top: 0});
                //              } else {
                //                      el.css({position: 'absolute', top: (178+ +adminbar)});
                //              }
                //      };
                //      this.highlight();
                // }
        },
        highlight: function (controller) {

                if(typeof controller === 'undefined') controller = KODELEARN.config.controller;

                $('.sidemenu a[href*="'+controller+'"]').parent().addClass('active');
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
                if($('#filter').val()){
                        url += '/' + $('#filter_select').val() + '/' + encodeURIComponent($('#filter').val());

                }
                location = url;
            });
            $('#filter').keypress(function(e){
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

KODELEARN.modules.add('user', (function () {
    return {
        init: function () {
            var $batch_tr = $("#batch-list"),
            $course_tr = $("#course-list");
            $("select[name='role_id']","#user-form").change(function () {
                $batch_tr.addClass('hidden');
                $course_tr.addClass('hidden');
                var role_name = $("select[name='role_id'] option:selected").text().toLowerCase();
                if (role_name === 'student') {
                    $batch_tr.removeClass('hidden');
                    $course_tr.removeClass('hidden');
                }
                if (role_name === 'teacher') {
                    $course_tr.removeClass('hidden');
                }
            }).trigger('change');
        }
    }
})());

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

            $('#error').remove();
            var warning = '<div id="error" class="formMessages"><span class="fmIcon bad"></span> <span class="fmText"><ul>';

            for(var i = 0; i < msgArr.length ; i++ ){
                warning += '<li>'+msgArr[i]+'</li>';
            }

            warning += '</ul></span><span class="clear">&nbsp;</span></div>';
            beforeDiv.before(warning);
            scroll(0,0);
            $('#error').slideDown(200);

        },
        showAjaxSuccess : function (beforeDiv,msgArr){

            $('#success').remove();
            var warning = '<div id="success" class="formMessages"><span class="fmIcon good"></span> <span class="fmText"><ul>';

            for(var i = 0; i < msgArr.length ; i++ ){
                warning += '<li>'+msgArr[i]+'</li>';
            }

            warning += '</ul></span><span class="clear">&nbsp;</span></div>';
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
        },
        showMap: function (roomId){
                $("#ajax-loader").show();
        KODELEARN.helpers.request.ajax({
            url: KODELEARN.config.base_url+"room/show_map/id/" + roomId,
            async: true,
            success: function (resp) {
                        $("#ajax-loader").hide();
                        $('#maps div').html(resp.html);
                        $('#maps').show();

            }
        });

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
                var event_type = $("select[name='event_type']").val();
                if (events) {
                    var request = new ajaxLoad({
                        'container': '#day-events',
                        'controller': 'calendar',
                        'action': 'day_events/year/'+year+'/month/'+month+'/day/'+day+'/type/'+event_type,
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
            $("#jumper_go").click(function () {
                var month = $("select[name='jump_month']").val(),
                year = $("select[name='jump_year']").val();
                var event_type = $("select[name='event_type']").val();
                new ajaxLoad({
                    'container': '#calendar-wrapper',
                    'controller': 'calendar',
                    'action': 'calendar?month='+month+'&year='+year+'&event_type='+event_type,
                    'callback': function (resp) {
                        that.day_events();
                        that.ajaxify();
                    }
                });
            });

            $("#current_day").live('click', function () {
                var event_type = $("select[name='event_type']").val();
                new ajaxLoad({
                    'container': '#calendar-wrapper',
                    'controller': 'calendar',
                    'action': 'calendar?event_type='+event_type,
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
               
                KODELEARN.helpers.request.post({
                    url: KODELEARN.config.base_url+"post/add/",
                    data: formdata,
                    async: true,
                    error_container: $("#post-form"),
                    success: function (resp) {
                        $('#post').val("");
                        $('#feeds').prepend(resp.html);
                        $("#link_share").val('0');
                        $("#loader").html("");
                        $("#link").html("");
                        $("#loader").css('display', 'none');
                        $("#link").css('display', 'none'); 
                    }
                });
            });
        }
    };
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
};

KODELEARN.helpers.request = {

    ajax: function (o) {
        var options = {
            async: false,
            type: 'get',
            data: { },
            success: function () { }
        };
        $.extend(options, o);
        $.ajax({
            url: options.url,
            type: options.type,
            data: options.data,
            dataType: 'json',
            async: options.async,
            success: function (resp) {
                options.success(resp);
            }
        });
    },

    get: function (o) {
        var options = {
            data: { },
            async: false,
            success: function (resp) { },
            access_denied: function (resp) {
                window.location.href = KODELEARN.config.base_url+'error/access_denied';
            }
        };
        $.extend(options, o);
        this.ajax({
            url: options.url,
            type: 'GET',
            data: options.data,
            async: options.async,
            success: function (resp) {
                if (resp.success) {
                    options.success(resp);
                } else if (resp.reason === 'access_denied') {
                    options.access_denied(resp);
                }
            }
        });
    },

    post: function (o) {
        var options = {
            data: { },
            async: false,
            error_container: $("#event_form"),
            success: function (resp) { },
            access_denied: function (resp) {
                window.location.href = KODELEARN.config.base_url+'error/access_denied';
            },
            error: function (resp) {
                KODELEARN.modules.get('ajax_message').showAjaxError(options.error_container, resp.errors);
            }
        };
        $.extend(options, o);
        this.ajax({
            url: options.url,
            type: 'POST',
            data: options.data,
            async: options.async,
            success: function (resp) {
                if (resp.success) {
                    options.success(resp);
                } else if (resp.errors) {
                    options.error(resp);
                } else if (resp.reason === 'access_denied') {
                    options.access_denied(resp);
                }
            }
        });
    }
};

// formblocks - used for those forms in which dynamic fields can be added and removed
// eg. a question can have many hints. so for adding/editing/removing hints, each hint
// will be a form block
// for usage eg. refer: modules/question/views/question/form.php
KODELEARN.helpers.Formblocks = function (opts) {
    var options = {
        listElem: '', // ul or table element
        itemElem: '', // li or a td depending upon the listElem
        addBtn: '', // button for adding a block
        rmBtn: '.rm-block', // button element for block removal
        min: 1, // min number of blocks,
        tmpl: '', // template of the block to be appended to the list
        onAdd: function () { }
    };
    $.extend(options, opts);
    $(options.addBtn).click(function () {
        if (options.tmpl !== '') {
            $(options.listElem).append(options.tmpl);
        }
        options.onAdd.call(this);
    });
    $(options.itemElem).live('mouseover mouseout', function (event) {
        if (event.type == 'mouseover') {
            if ($(this).siblings().length > (options.min-1)) {
                $(this).children().filter(options.rmBtn).show();
            }
        } else if (event.type == 'mouseout') {
            $(this).children().filter(options.rmBtn).hide();
        }
    });
    $(options.rmBtn, options.listElem).live('click', function () {
        $(this).parent().fadeOut(200, function () {
            $(this).remove();
        });
    });
}

KODELEARN.helpers.editor = {

    /**
     * Function to insert anything inside a textarea at the position
     * of the caret
     * @param myField the textarea dom object
     * @param myValue String to be inserted
     */
    insertAtCursor: function (myField, myValue) {
        //IE support
        if (document.selection) {
            myField.focus();
            sel = document.selection.createRange();
            sel.text = myValue;
        }
        //MOZILLA/NETSCAPE support
        else if (myField.selectionStart || myField.selectionStart == '0') {
            var startPos = myField.selectionStart,
            endPos = myField.selectionEnd,
            before = myField.value.substring(0, startPos),
            after = myField.value.substring(endPos, myField.value.length);
            myField.value = before + myValue + after;
        } else {
            myField.value += myValue;
        }
    }
}

KODELEARN.helpers.editor.mathEditor = (function () {
    var current_status = false;
    var expr = {
        // In order - Name, tex, description, caret position
        // \ char in tex needs to be escaped using another \
        '{}' : ['{..}', '\\{ \\}', 'Curly braces {...}', 2],
        '[]' : ['[..]', '\\[ \\]', 'Curly braces [...]', 2],
        'ineq': ['!=', '\\not=', 'Not equal to', 5],
        'leq' : ['<=', '\\leq', 'Less than or equal to', 5],
        'geq' : ['>=', '\\leq', 'Less than or equal to', 5],
        'sqrt': ['Square Root', '\\sqrt{arg}', 'square root of arg', 6],
        'root': ['nth Root', '\\sqrt[n]{arg}', 'nth root of arg', 6],
        'frac': ['Fraction', '\\frac{num}{den}', 'num=numerator, den=denominator', 6],
        'fact': ['Factorial', 'n!', 'Factorial of n', 0],
        'mod': ['Modulus', '|n|', 'Modulus of n', 1],
        'pow': ['Power', 'a^n', 'A raised to the power of n', 0],
        'sub': ['Subscript', 'x_i', 'x subscript i', 0],
        'pi' : ['pi', '\\pi', 'pi=3.1416', 0],
        'theta': ['Theta', '\\theta', 'Greek letter theta', 0],
        'sin': ['sine', '\\sin \\theta', 'sine of theta', 6],
        'cos': ['cos', '\\cos \\theta', 'cosine of theta', 6],
        'tan': ['tan', '\\tan \\theta', 'tan of theta', 6],
        'sec': ['sec', '\\sec \\theta', 'sec of theta', 6],
        'cot': ['cot', '\\cot \\theta', 'cot of theta', 6],
        'cosec': ['cosec', '\\mathrm{cosec} \\theta', 'cot of theta', 8],
        'deg': ['Degrees', '^\\circ', 'Degrees', 0],
        'infty': ['Infinity', '\\infty', 'Infinity', 0],
        'dots' : ['Dots', '\\cdots', 'To imply \'and so on\'', 0],
        'ln': ['ln', '\\ln', 'Natural Logarithm', 0],
        'log': ['log', '\\log_a x', 'Logarithm to the base of a', 5],
        'limit': ['Limit', '\\lim_{x\\to 0}', 'Limit x tends to 0', 6],
        'sum': ['Summation', '\\displaystyle\\sum_{i=1}^n x_i', 'Summation x(i) for i = 1 to n', 25],
        'mat': ['Matrix', '\\begin{bmatrix} 1 & 0 & 0 \\\\0 & 1 & 0 \\\\0 & 0 & 1 \\end{bmatrix}', 'An identity matrix, add data accordingly', 0],
        'deriv': ['Derivative', '\\frac{d}{dx} y', 'dy by dx', 13],
        'pderiv': ['Partial Derivative', '\\frac{\\partial}{\\partial x} y', 'dy by dx', 28],
        'int_i': ['Indefinite Integral', '\\int y\\, \\mathrm{d}x', 'y=integrand, {d}x=variable of integration', 6],
        'int_d': ['Definite Integral', '\\int^b_a y\\, \\mathrm{d}x', 'y=integrand, b=upper limit, a=lower limit, {d}x=variable of integration', 9]
    }

    function buildMathMenu() {
        var html = '<ul class="math-editor-menu">';
        for (k in expr) {
            html += '<li><a class="btn_'+k+'" rel="'+k+'" title="'+expr[k][2]+'">'+expr[k][0]+'</a></li>';
        }
        html += '</ul><div class="clear"></div><p class="tex-help">Please click on an expression above.</p>';
        return html;
    }

    /**
     * Function to insert anything inside a textarea at the position
     * of the caret
     * @param elem the textarea dom object
     * @param tex String to be inserted
     * @param caret_pos The position of the caret after the insertion is complete
     */
    function insertTex(elem, tex, caret_pos) {
        if (elem.selectionStart || elem.selectionStart == '0') {
            var startPos = elem.selectionStart,
            endPos = elem.selectionEnd,
            before = elem.value.substring(0, startPos),
            after = elem.value.substring(endPos, elem.value.length);
            // check if the point of insertion is already between latex begin/end ($$..$$)
            var dollar_split = before.split('$$').length;
            if (dollar_split > 0 && dollar_split%2) {
                tex = '$$'+tex+'$$';
            }
            elem.value = before + tex + after;
            var cp = elem.value.substring(0, startPos).length + caret_pos;
            elem.focus();
            elem.setSelectionRange(cp, cp);
        } else {
            elem.value += tex;
            elem.focus();
            elem.setSelectionRange(caret_pos, caret_pos);
        }
    }

    var menu_html = buildMathMenu();

    $(".act-math-link").live('click', function () {
        var $textarea = $(this).siblings().filter('textarea');
        $textarea.before(menu_html);
        $(this).after('<div class="tex-editor-preview"></div>');
        $textarea.change(function () {
            $(this).siblings().filter('.tex-editor-preview').text($(this).val());
            MathJax.Hub.Typeset();
        }).trigger('change');
        $(this).hide();
    });

    $(".math-editor-menu>li>a").live('click', function () {
        var exp = $(this).attr('rel'),
        tex = expr[exp][1],
        caret_pos = expr[exp][3],
        $ul = $(this).parent().parent(),
        $ta = $ul.siblings().filter('textarea'),
        $tex_help = $ul.siblings().filter('.tex-help');
        insertTex($ta[0], tex, caret_pos+2);
        $ta.trigger('change');
        $tex_help.text('Tex editing help: '+expr[exp][2]);
    });

    return function (elem) {
        $elem = $(elem);
        return {
            initialize: function () {
                $elem.after('<br/><a class="act-math-link">Add math expressions ?</a>');
                // check if the textarea already contains a math expression
                // if yes, show preview right away
                if (this.containsMath()) {
                    $elem.siblings().filter(".act-math-link").trigger('click');
                }
            },

            // checks whether the textarea contains any math
            containsMath: function () {
                var content = $elem.val();
                return content.split('$$').length > 1 || /\$\$.+\$\$/.test(content);
            }
        }
    }
}) ();

KODELEARN.helpers.tmpl_manipulation = {

    // hide the side bar and shift the page content to left
    hideSidebar: function (shift_page_content) {
        $(".sidebar").hide();
        if (shift_page_content) {
            $(".pagecontent").removeClass('r').css('width', '100%');
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
        title: "Events for "+d+" - "+m+" - "+y
    });return false;
};

KODELEARN.modules.add('document', (function () {
    return {
        init: function () {
                return;
        },
        del: function (Id) {
            KODELEARN.helpers.request.get({
                url: KODELEARN.config.base_url+"document/delete/id/" + Id,
                async: true,
                success: function (resp) {
                        KODELEARN.modules.get('ajax_message').showAjaxSuccess($('.documentsContainer'), resp.msg);
                        $('#doc'+Id).fadeOut(500);
                }
            });
        },
        edit: function (Id) {
                $("#ajax-loader").show();
                KODELEARN.helpers.request.get({
                url: KODELEARN.config.base_url+"document/edit/id/" + Id,
                async: true,
                success: function (resp) {
                                $('#document_from').remove();
                                $('#edit_document').html(resp.html);
                                $("#ajax-loader").hide();
                }
            });
        },
        save: function () {

                data = $('#document_form').serializeArray();
                KODELEARN.helpers.request.post({
                url: KODELEARN.config.base_url+"document/edit/",
                async: true,
                error_container: $("#document_form"),
                data: data,
                success: function (resp) {
                                KODELEARN.modules.get('ajax_message').showAjaxSuccess($("#document_form"),resp.msg);
                                setTimeout('window.location.reload()', 2500);
                }
            });
        }
    }
})());

function delete_selfpost(self,id) {
	$.ajax(
	{
		type: "GET",
		dataType:"html",
		url:     KODELEARN.config.base_url+"post/selfDelete/id/" + id,
		success: function(data1)
				{
					$(self).parent().parent().parent().parent().parent().css('display','none');
				}
	});
	
}

function delete_post(self,id) {
	$.ajax(
	{
		type: "GET",
		dataType:"html",
		url:     KODELEARN.config.base_url+"post/delete/id/" + id,
		success: function(data1)
				{
					$(self).parent().parent().parent().parent().parent().css('display','none');
				}
	});
	
}

function show_comment_entry_box(self, usr_img, feed_id) {
	$(self).css('display','none');
	var content = "<table style='width: 60%; background: #eee; border-top: 1px solid #fff;'>";
	content += "<tr><td class='pad5' style='width: 40px;'><img src='"+ usr_img +"' style='width: 40px; height: 40px;' /></td>";
	content += "<td class='vatop pad5'><input type='text' class='text-comment' onkeypress='onCommentPost(this, event, "+ feed_id +");' style='resize: none; height: 14px; font-size: 12px; padding: 5px; width: 95%;' /><p class='pad5' style='font-size: 11px; color: #777;'>Press Enter to post your comment.</p></td></tr>";
	content += "</table>";
	$(self).parent().parent().parent().children().find('.comments').append(content);
	$(self).parent().parent().parent().children().find('.comments').children().find('.text-comment').focus();
}

function onCommentPost(self, e, feed_id) {
	
	var key = e.keyCode;
	if (key == 13) {
		if($(self).val() == "") {
			return false;
		}	
		$.ajax(
		{
			type: "POST",
			dataType:"json",
			url:     KODELEARN.config.base_url+"post/comment",
			data: "id=" + feed_id + "&data=" + $(self).val(),
			success: function(data)
					{
						var content = "<tr class='del-comm' style='border-top: 1px solid #fff;'><td class='pad5' style='width: 40px;'><img src='"+ data.img +"' style='width: 40px; height: 40px;' /></td>";
						content += "<td class='vatop pad5' style='width: 350px;'><a style='font-size: 14px; font-weight: bold;'>"+ data.name +"</a><span class='hpad10' style='font-size: 12px;'>"+ data.text +"</span><p class='vpad10' style='font-size: 11px; color: #777;'>"+ data.time +"</p></td>";
						content += "<td class='vatop w2 pad5'>";
						content += "<a onclick='delete_selfcomment(this, "+ data.comment_id +");' class='del-comment' style='font-size: 11px; font-weight: bold; display: none; cursor: pointer;'>X</a>";
						content += "</td></tr>";
						$(self).parent().parent().parent().parent().parent().find('.new-comments').append(content);
						$(self).val('');
					}
		});
	}
}

function showViewLimit(self) {
	$(self).parent().parent().parent().parent().children().find('.comments').children().children().children('.view-limit').css('display', 'block')
}

function delete_selfcomment(self,id) {
	$.ajax(
	{
		type: "GET",
		dataType:"html",
		url:     KODELEARN.config.base_url+"post/selfdelete_comment/id/" + id,
		success: function(data1)
				{
					$(self).parent().parent().remove();
				}
	});
	
}

function delete_comment(self,id) {
	$.ajax(
	{
		type: "GET",
		dataType:"html",
		url:     KODELEARN.config.base_url+"post/deletecomment/id/" + id,
		success: function(data1)
				{
					$(self).parent().parent().remove();
				}
	});
}
