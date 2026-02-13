jQuery(document).ready(function($) {
	
	
	if(POS_HOME_PRODUCTTAB_PAGINATION==null || POS_HOME_PRODUCTTAB_PAGINATION =="") {POS_HOME_PRODUCTTAB_PAGINATION = false} else { POS_HOME_PRODUCTTAB_PAGINATION = true}
	if(POS_HOME_PRODUCTTAB_NAV==null || POS_HOME_PRODUCTTAB_NAV =="") {POS_HOME_PRODUCTTAB_NAV = false} else {POS_HOME_PRODUCTTAB_NAV = true}
	var productTabslider = $(".product-tabs-container-slider .productTab-item ");
	productTabslider.owlCarousel({
			smartSpeed: POS_HOME_PRODUCTTAB_SPEED,
			dots :POS_HOME_PRODUCTTAB_PAGINATION,
			nav : POS_HOME_PRODUCTTAB_NAV,
			scrollPerPage: true,
			addClassActive: true,
			responsive:{
				0:{
					items:1,
				},
				480:{
					items:2,
				},
				768:{
					items:3,
				},
				992:{
					items:4,
				},
				1200:{
					items:POS_HOME_PRODUCTTAB_ITEMS,
				}
			}
		});
		checkClasses();
		productTabslider.on('translated.owl.carousel', function(event) {
			checkClasses();
		});

		function checkClasses(){
			$('.product-tabs-container-slider .tab_content').each(function(){
				var total = $(this).find('.owl-stage .owl-item.active').length;
				$(this).find('.owl-item').removeClass('firstActiveItem');
				$(this).find('.owl-item').removeClass('lastActiveItem');
				$(this).find('.owl-item.active').each(function(index){
					if (index === 0) { $(this).addClass('firstActiveItem'); }
					if (index === total - 1 && total>1) {
						$(this).addClass('lastActiveItem');
					}
				}) 
			});
		}
		$(".tab_content").hide();
	$(".tab_content:first").show(); 
	$("ul.tabs_slider li span").click(function() {
		$("ul.tabs_slider li").removeClass("active");
		$(this).parent().addClass("active");
		$(".tab_content").hide();
		var activeTab = $(this).parent().attr("rel"); 
		$("#"+activeTab) .fadeIn().addClass("animatetab");  
	});
});
