$(document).ready (function () {
	//My Account menu
	$("#myac").mouseenter(function () {
		$(this).toggleClass("active");
		$("#myacContent").fadeIn("fast");
	});
	$("#myacContent").mouseleave(function () {
		$(this).toggleClass("active");
		$("#myacContent").fadeOut("fast");
	});
	
	//Role toggle - used on header
	$("#roleViewToggle").click(function () {
		$("#roleList").slideToggle("fast");
	});
	
	//Toggle message recipients selector
	$("#msgRecToggle").click(function () {
		$("#courseSelect").slideToggle("fast");
	});
	
	//Toggle buttons
	$(".toggleButton > a").click(function (ev) {
		$(this).parent().find("a").removeClass("on");
		$(this).addClass("on");
		ev.preventDefault();
	});
	
	//Hide error messages when corrective action is being taken
	$("#post").focus(function () {
		$("#error").fadeOut(250, function () {
			$("#error").remove();
		});
	});
	$("input[name='selected_roles[]']").click(function () {
			$("#error").fadeOut(250, function () {
			$("#error").remove();
		});
	});
	
	
});