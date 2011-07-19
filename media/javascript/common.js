$(document).ready(function(){
    
    // Confirm Delete
    $('form').submit(function(){
        if ($(this).attr('action').indexOf('delete',1) != -1) {
            if (!confirm ('Delete cannot be undone! Are you sure you want to do this?')) {
                return false;
            }
        }
    });

    KODELEARN.modules.load();    
});

var KODELEARN = KODELEARN || { };

KODELEARN.modules = {
    
    list: { },

    add: function (key, module) {
        this.list[key] = module;
    },

    load: function () {
        for (var i in this.list) {
            module = this.list[i];
            module.init.call(module);
        }
    },

    get: function (key) {
        return this.list[key];
    },

    get_list: function () {
        return this.list;
    }
};

KODELEARN.modules.add('roles', (function () {

    return {
        init: function () { 
            // toggle on click
            $(".roleAction").click(function () {                
                if ($(this).hasClass('yes')) {
                    $(this).removeClass('yes').addClass('no');                    
                    $(this).children().filter("input:checkbox").attr('checked', false);
                } else if ($(this).hasClass('no')) {
                    $(this).removeClass('no').addClass('yes');
                    $(this).children().filter("input:checkbox").attr('checked', true);
                }
            });
            // allow all
            $(".allowAll").click(function () {
                $(this).parent().siblings().eq(1).children().filter('div').each(function () {
                    $(this).removeClass('no').addClass('yes');
                    $(this).children().filter("input:checkbox").attr('checked', true);
                });
            });
            // deny all
            $(".denyAll").click(function () {
                $(this).parent().siblings().eq(1).children().filter('div').each(function () {
                    $(this).removeClass('yes').addClass('no');
                    $(this).children().filter("input:checkbox").attr('checked', false);
                });
            });   
            // allow everything
            $("#allowEverything").click(function () { 
                $(".roleAction").each(function () { 
                    $(this).removeClass('no').addClass('yes');
                    $(this).children().filter("input:checkbox").attr('checked', true);
                });
            });
            // deny everything
            $("#denyEverything").click(function () { 
                $(".roleAction").each(function () { 
                    $(this).removeClass('yes').addClass('no');
                    $(this).children().filter("input:checkbox").attr('checked', false);
                });
            });
            // submit the form on clicking save
            $(".saveAcl").click(function () {
                $("form#acl-form").submit();
            });
        },
    }
})());

