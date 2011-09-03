/**
 * Javascript file if for all globally reusable stuff
 * @author Team Kodeplay
 */


var ajaxLoad = function(opts) {

    this.options = {
	'container' : '#middle-content',
	'controller' : 'index',
	'action'    : '',
	'onBefore'    : function() {  }, //will be called before the request is sent
	'loadingGif' : true, //loading image enabled or disabled while response arrives
	'response'   : 'html',   //the type of response expected
	'callback'   : function(resp) {  },
	'scrollTop'  : { 'enabled' : true , 'val' : 0   },
	'history'    : true,  //the action will get appended to the url
	'loginReq' : false
    };

    $.extend(this.options,opts);

    this.before();
    this.request();
};

ajaxLoad.prototype.before = function() {

    if (this.options.loadingGif) {
    	$("#ajax-loader").show();
    }

    if (typeof this.options.onBefore == 'function') {
	this.options.onBefore.call(this,this);
    }
};

ajaxLoad.prototype.request = function() {
    var o = this;
    var url = KODELEARN.config.base_url+""+this.options.controller+"/"+this.options.action;
    $.get(url,function(resp) {
	if ('html' == o.options.response) {
	    $(o.options.container).html(resp);
	}
	if (typeof o.options.callback == 'function') {
	    o.options.callback.call(this,resp);
	}
	$("#ajax-loader").hide();
    });
};

var verticalScroll = function(opts){
	
	this.options = {
			$link : $("#vert-link"),
			controller : 'ajax',
			action:'',
			$appendTO: $('#middle'),
			height:'auto',
			width:'auto',
		    start : 0,    //from where fetching of data will take place
			response : 'html' //how the response id going to be
	};
	
	$.extend(this.options,opts);
	
	if((this.options.action == '' || this.options.action == null)){
		alert('if');
		return false;
	}
	
	var that = this;
	
	this.options.$link.bind('click',function(){
		
		var url = KODELEARN.config.base_url+that.options.controller+"/"+that.options.action+"/start/"+that.options.start;
		
		$("#ajax-loader").show();
		
		$.get(url, function(data){
			
			html = '<div>' + data + '</div>';
			
			if($(html).children().size()){
				that.options.start = that.options.start + 5;
				that.options.$appendTO.append(data);
			}
			else {
				that.options.$link.parent().remove();
			}
		}, 'html');
		
		$("#ajax-loader").hide();
		
	});	
};

