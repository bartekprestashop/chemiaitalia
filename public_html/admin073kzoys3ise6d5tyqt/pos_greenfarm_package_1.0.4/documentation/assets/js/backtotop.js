$(document).ready(function(){

	// hide #back-top first
	$("#back-top").hide();
	
	// scroll body to 0px on click
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 150) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});
		$('#back-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 1000);
			return false;
		});
	});

});
