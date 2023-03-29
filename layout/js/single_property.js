


//single property
jQuery(function($){
	
	set_resize_single_property($);
	$(window).resize(function(){
		set_resize_single_property($);
	});
	
	$('.tabs').tabs();
	
	$('.tooltipped').tooltip();
	
	set_swiper_property_detail();
	
	setTimeout(function(){
		$('#vdbanner').css('margin','');
	}, 1000);
	
	if( $('.catchphrase_pc').length ){
		$('#photo').css('height','780px');
	}else{
		$('#photo').css('height','740px');
	}
	
});


//物件画像
function set_swiper_property_detail(){
	var galleryThumbs = new Swiper('.gallery-thumbs', {
		spaceBetween: 10,
		slidesPerView: 1,
		loop: false,
		freeMode: true,
//		loopedSlides: 5, //looped slides should be the same
		watchSlidesVisibility: true,
		watchSlidesProgress: true,
		breakpoints: {
			280: {
				slidesPerView: 3
			},
			320: {
				slidesPerView: 4
			},
			360: {
				slidesPerView: 4
			},
			375: {
				slidesPerView: 5
			},
			414: {
				slidesPerView: 5
			},
			768: {
				slidesPerView: 6
			},
			1240: {
				slidesPerView: 7
			}
		}
	});
	var galleryTop = new Swiper('.gallery-top', {
		spaceBetween: 10,
		loop: false,
//		loopedSlides: 5, //looped slides should be the same
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		thumbs: {
			swiper: galleryThumbs,
		},
	});
}


//物件詳細
function set_resize_single_property($){
	
	var swiper_gallery_wrap = $('.swiper_gallery_wrap').detach();
	var catchphrase = $('.catchphrase_wrap').detach();
	var googlemap = $('.googlemap').detach();
	var facility_wrap = $('.facility_wrap').detach();
	var post_content = $('.post_content').detach();
	
	var property_print = $('.property_print_wrap').detach();
	if( window.innerWidth <= 828 ){
		$('.property_print_sp').append( property_print );
	}else{
		$('.property_print_pc').append( property_print );
	}
	
	if( window.innerWidth <= 1024 ){
		$('.single_property_sidebar').removeClass('col s4');
		$('.single_property_main_contents').removeClass('s8').addClass('s12');
		$('.swiper_gallery_wrap_sp').append(swiper_gallery_wrap);
		$('.catchphrase_sp').append(catchphrase);
		$('.googlemap_sp').append(googlemap);
		$('.facility_wrap_sp').append(facility_wrap);
		$('.post_content_sp').append(post_content);
	}else{
		$('.single_property_sidebar').addClass('col s4');
		$('.single_property_main_contents').removeClass('s12').addClass('s8');
		$('.swiper_gallery_wrap_pc').append(swiper_gallery_wrap);
		$('.catchphrase_pc').append(catchphrase);
		$('.googlemap_wrap_pc').append(googlemap);
		$('.facility_wrap_pc').prepend(facility_wrap);
		$('.post_content_pc').append(post_content);
	}
	
	if( window.innerWidth <= 1130 ){
		$('.tabs_wrap').removeClass('s8').addClass('s12');
		$('.add_favorites_wrap').removeClass('s4').addClass('s12');
	}else{
		$('.tabs_wrap').removeClass('s12').addClass('s8');
		$('.add_favorites_wrap').removeClass('s12').addClass('s4');
	}
	
	if( window.innerWidth <= 1200 ){
		$('.post_content_pc').removeClass('s7').addClass('s12');
		$('.facility_wrap_pc').removeClass('s5').addClass('s12');
	}else{
		$('.post_content_pc').removeClass('s12').addClass('s7');
		$('.facility_wrap_pc').removeClass('s12').addClass('s5');
	}

}

