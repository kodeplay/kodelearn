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
	
	//Select all, select none and select inverters
	/*	We read the select target from .selectAll's parent element
		through its data-selectTarget atttribute.
		It contains the ID of checkboxes' container element.
		Then we select all, deselect all, or invert selection 
		based on what was clicked.
	*/
	$(".selectAll").click(function () {
		/*var p = $(this).parent();
		p = $(p).data("selecttarget");
		var selector = "#" + p;
		$(selector).filter(":checkbox").each(function () {
			$(this).attr("checked", "");
		});		*/
	});
	
	//Toggle buttons
	$(".toggleButton > a").click(function (ev) {
		$(this).parent().find("a").removeClass("on");
		$(this).addClass("on");
		ev.preventDefault();
	});
	
});