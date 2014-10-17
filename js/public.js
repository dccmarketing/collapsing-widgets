jQuery(document).ready(function($){

	$(".widget-title").css("cursor", "pointer");

	$(".widget").each( function() {

		var widget = $(this);
		var title = widget.children(":first-child");
		var content = widget.children(":last-child");
		var plus_minus = $(this).children(".show_hide");

		title.click( function(){

			content.slideToggle(250);
			title.toggleClass("open");
			
			if ( title.hasClass( "open" ) ) {

				plus_minus.html("-");

			} else {

				plus_minus.html("+");

			}

		}); // title.click()

	}); // .widget

});