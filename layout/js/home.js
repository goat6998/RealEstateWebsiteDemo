
jQuery(function($){
	$('.parallax').parallax();
	set_swiper_property();
	set_swiper_archive();
	set_swiper_media();
	
	$('#widget_main_media_link').find('li').wrapInner('<div></div>');
	$('#widget_main_media_link').find('a').attr('target','_blank');
	
	set_search_form_home($);
	$(window).resize(function(){
		set_search_form_home($);
	});
	
});


function set_search_form_home($){
	
	if( window.innerWidth <= 540 ){
		$('body').append( $('#home_search').detach().hide() );
		$('body').append( $('.search_form_station_wrap').detach() );
		$('body').append( $('.search_form_area_wrap').detach() );
		$('.search_form_contents_station').append( $('.checkbox_main_wrap_station').detach() );
		$('.search_form_contents_area').append( $('.checkbox_wrap_out_area').detach() );
	}else{
		if( window.innerWidth > 540 && window.innerWidth <= 960 ) {
			$('.search_form_station_tablet').append( $('.search_form_station_wrap').detach() );
			$('.search_form_area_tablet').append( $('.search_form_area_wrap').detach() );
		}else{
			$('.search_form_pc').append( $('#home_search').detach().show() );
			$('.form_select_station_pc').append( $('.search_form_station_wrap').detach() );
			$('.form_select_area_pc').append( $('.search_form_area_wrap').detach() );
			set_home_price($);
			set_property_layout($);
		}
		$('.search_modal_station').append( $('.checkbox_main_wrap_station').detach() );
		$('.search_modal_area').append( $('.checkbox_wrap_out_area').detach() );
	}
}


//家賃、価格＞トップページ
function set_home_price( $ ){
	
	var element_rentals = $('.front_price_low_rentals, .front_price_high_rentals');
	var element_rentals_select = $('.front_price_low_rentals select[name="price_low"], .front_price_high_rentals select[name="price_high"]');
	var element_real_estate = $('.front_price_low_real_estate, .front_price_high_real_estate');
	var element_real_estate_select = $('.front_price_low_real_estate select[name="price_low"], .front_price_high_real_estate select[name="price_high"]');
	
	element_rentals.show();
	element_real_estate.hide();
	element_real_estate_select.prop('disabled', true);
	
	$('.search_property_type').change(function(){
		var property_type_val = $(this).val();
		
		if( property_type_val!="" && property_type_val.search('rentals')!= -1 ){
			element_real_estate_select.prop('disabled', true);
			element_real_estate.hide();
			element_rentals_select.prop('disabled', false);
			element_rentals.show();
		}else{
			element_rentals_select.prop('disabled', true);
			element_rentals.hide();
			element_real_estate_select.prop('disabled', false);
			element_real_estate.show();
		}
		
	});
}


function set_property_layout($){
	
	var floor_plan_all = $('.floor_plan_all').text();
	$('.btn_remodal_property_layout').text( floor_plan_all );
	if( !$('.btn_remodal_property_layout').find('i').length ){
		$('.btn_remodal_property_layout').append('<i class="material-icons right">arrow_drop_down</i>');
	}
	
	var property_layout_label = {};
	var property_layout_check = {};
	$('input[name="property_layout"]').click(function(){
		
		if( $('.send_property_layout').find('input').length ){
			$('.send_property_layout').find('input').remove();
		}
		
		$('.checkbox_property_layout').each(function( key, value ){
			if( $(value).find('input').prop('checked') ){
				property_layout_label[key] = $(value).find('span').text();
				property_layout_check[key] = $(value).find('input').val();
			}else{
				delete property_layout_label[key];
				delete property_layout_check[key];
			}
		});
		
		var property_layout_len = Object.keys(property_layout_label).length;
		
		console.log( property_layout_label );
		console.log( property_layout_check );
		
		var set_property_layout_label = [];
		
		if( property_layout_len > 0 ){
			$.each(property_layout_check, function( key, value ){
				var send_property_layout = '<input type="hidden" name="property_layout[]" value="'+ value +'">';
				$('.send_property_layout').append( send_property_layout );
				
				set_property_layout_label.push( property_layout_label[key] );
				$('.btn_remodal_property_layout').text( set_property_layout_label.join(', ') );
			});
		}else{
			$('.btn_remodal_property_layout').text( floor_plan_all );
		}
		
	});
	
	$('.reset_property_layout').click(function(){
		$('input[name="property_layout"]').prop('checked', false);
	});
}


function set_swiper_property(){
	
	var swiper = new Swiper('.swiper_front', {
		slidesPerView: 1,
		spaceBetween: 10,
		centeredSlides: true,
		init: true,
		pagination: {
			clickable: true,
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		breakpoints: {
			414: {
				slidesPerView: 1
			},
			500: {
				slidesPerView: 1.5
			},
			768: {
				slidesPerView: 2,
				centeredSlides: false
			},
			1023: {
				slidesPerView: 3,
				centeredSlides: false
			},
			1241: {
				slidesPerView: 4,
				centeredSlides: false,
				spaceBetween: 15
			}
		}
	});
}


function set_swiper_archive(){
	var swiper = new Swiper('.swiper_archive', {
		slidesPerView: 1,
		spaceBetween: 10,
		pagination: {
			clickable: true,
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		breakpoints: {
			320: {
				slidesPerView: 1,
				spaceBetween: 10,
			},
			480: {
				slidesPerView: 2,
				spaceBetween: 10,
			},
			560: {
				slidesPerView: 3,
				spaceBetween: 15,
			},
			960: {
				slidesPerView: 4,
				spaceBetween: 15,
			},
		}
    });
}


function set_swiper_media(){
	var swiper = new Swiper('.swiper_media', {
		slidesPerView: 1,
		spaceBetween: 10,
		pagination: {
			clickable: true,
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
		breakpoints: {
			414: {
				slidesPerView: 1,
				spaceBetween: 10,
			},
			540: {
				slidesPerView: 2,
				spaceBetween: 10,
			},
			768: {
				slidesPerView: 2,
				spaceBetween: 10,
			},
			1024: {
				slidesPerView: 3,
				spaceBetween: 15,
			},
			1280: {
				slidesPerView: 4,
				spaceBetween: 15,
			}
		}
    });
}
