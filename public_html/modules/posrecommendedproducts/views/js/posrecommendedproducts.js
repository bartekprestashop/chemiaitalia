$(document).ready(function() {
	var $recommendedproductconf = $('.recommended-product');
	var items       = parseInt($recommendedproductconf.attr('data-items'));
	var lazyload    = parseInt($recommendedproductconf.attr('data-lazyload'));
	var speed     	= parseInt($recommendedproductconf.attr('data-speed'));
	var autoPlay    = parseInt($recommendedproductconf.attr('data-autoplay'));
	var time    	= parseInt($recommendedproductconf.attr('data-time'));
	var arrow       = parseInt($recommendedproductconf.attr('data-arrow'));
	var pagination  = parseInt($recommendedproductconf.attr('data-pagination'));
	var move        = parseInt($recommendedproductconf.attr('data-move'));
	var pausehover  = parseInt($recommendedproductconf.attr('data-pausehover'));
	var md          = parseInt($recommendedproductconf.attr('data-md'));
	var sm          = parseInt($recommendedproductconf.attr('data-sm'));
	var xs          = parseInt($recommendedproductconf.attr('data-xs'));
	var xxs         = parseInt($recommendedproductconf.attr('data-xxs'));
	
	if(autoPlay==1) {
		if(time){
			autoPlay = time;
		}else{
			autoPlay = '3000';
		}
	}else{
		autoPlay = false;
	}
	if(lazyload){lazyload = true}else{lazyload=false}
	if(pausehover){pausehover = true}else{pausehover=false}
	if(move){move = false}else{move=true}
	if(arrow){arrow =true}else{arrow=false}
	if(pagination==1){pagination = true}else{pagination=false}

	var recommendedproductslide = $(".recommended-product .recommendedproductslide");
	recommendedproductslide.owlCarousel({
		lazyLoad: lazyload,
		autoplay : autoPlay ,
		smartSpeed: speed,
		autoplayHoverPause: pausehover,
		addClassActive: true,
		scrollPerPage: move,
		nav : arrow,
		dots : pagination,
		responsive : {
		    0 : {
		        items : xxs,
		    },
		    480 : {
		        items : xs, 
		    },
		    768 : {
		        items : sm,
		    },
		    992 : {
		        items : md,
		    },
		    1200 : {
		        items : items,
		    }
		}
	});
	checkClasses();
    recommendedproductslide.on('translated.owl.carousel', function(event) {
        checkClasses();
    });

    function checkClasses(){
		var total = $('.recommended-product .recommendedproductslide .owl-stage .owl-item.active').length;
        $('.recommended-product ').each(function(){
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

});

