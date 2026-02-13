jQuery(document).ready(function($) {  
	if(POS_HOME_SELLER_PAGINATION==null || POS_HOME_SELLER_PAGINATION =="") {POS_HOME_SELLER_PAGINATION = false} else { POS_HOME_SELLER_PAGINATION = true}
	if(POS_HOME_SELLER_NAV==null || POS_HOME_SELLER_NAV =="") {POS_HOME_SELLER_NAV = false} else {POS_HOME_SELLER_NAV = true}
	var owl = $(".bestsellerSlide");
		owl.owlCarousel({
		autoPlay : false ,
		smartSpeed: POS_HOME_SELLER_SPEED,
		autoplayHoverPause: true,
		nav: POS_HOME_SELLER_NAV,
		dots : POS_HOME_SELLER_PAGINATION,
		responsive:{
			0:{
				items:1,
			},
			500:{
				items:2,
			},
			800:{
				items:3,
				nav:false,
			},
			992:{
				items:3,
			},
			1200:{
				items:POS_HOME_SELLER_ITEMS,
			}
		}
	});
});