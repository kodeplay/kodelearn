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
	
	//Role actions toggle - used on permissions page
	$(".roleAction").click(function () {
		$(this).toggleClass("yes");
		$(this).toggleClass("no");
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
	
});