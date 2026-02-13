$(document).ready(function() {
		$(document).off('mouseenter').on('mouseenter', '.pos-slideshow', function(e){
		$('.pos-slideshow .timethai').addClass('pos_hover');
		});

		 $(document).off('mouseleave').on('mouseleave', '.pos-slideshow', function(e){
		   $('.pos-slideshow .timethai').removeClass('pos_hover');
		 });
		if(POSSLIDESHOW_NAV==1){
			var slide_navigation = true;
		}else{
			var slide_navigation = false;
		};
		if(POSSLIDESHOW_PAGI==1){
			var slide_pagination = true;
		}else{
			var slide_pagination = false;
		};
        $('#pos-slideshow-home').nivoSlider({
			effect: 'random',
			slices: 15,
			boxCols: 8,
			boxRows: 4,
			animSpeed: 600,
			pauseTime: POSSLIDESHOW_SPEED,
			startSlide: 0,
			directionNav: slide_navigation,
			controlNav: slide_pagination,
			controlNavThumbs: false,
			pauseOnHover: true,
			manualAdvance: false,
			prevText: '<i class="material-icons">chevron_left</i>',
			nextText: '<i class="material-icons">chevron_right</i>',
                        afterLoad: function(){
                         $('.pos-loading').css("display","none");
                        },     
                        beforeChange: function(){ 
                            $('.bannerSlideshow1').removeClass("pos_in"); 
                            $('.bannerSlideshow2').removeClass("pos_in"); 
                            $('.bannerSlideshow3').removeClass("pos_in"); 
                        }, 
                        afterChange: function(){ 
                             $('.bannerSlideshow1').addClass("pos_in"); 
                            $('.bannerSlideshow2').addClass("pos_in"); 
                            $('.bannerSlideshow3').addClass("pos_in"); 
                        }
 		});
    });