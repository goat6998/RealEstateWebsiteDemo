
jQuery(function($){
	
	$('.side_search_form').sidenav({edge: 'left', draggable: false});
	
	set_search_form($);
	$(window).resize(function(){
		set_search_form($);
	});
	
	//検索プルダウン
	$('select').formSelect();
	
	//物件タイプ選択
	set_action_accordion( $ );
	
	$('#modal-search').modal({ endingTop: 0 });
	
	set_hide_form_params($, '.checkbox_main_wrap_station', '.get_home_station');
	set_hide_form_params($, '.checkbox_wrap_out_area', '.get_home_area');
	
	$('button[type="submit"]').click(function(){
		set_form_action($)
		$(this,'form').submit();
	});
	
	
});


//フォームリセット
function set_hide_form_params($, wrap_element, remove_element ){
	if( $(remove_element).length ){
		$( wrap_element ).find('input').click(function(){
			$( remove_element ).remove();
		});
	}
}


//指定エレメント＞フォームdisabled
function check_input_disabled( $, element ){
	if( $( element ).val()=='' ){
		$( element ).prop('disabled', true);
	}
}

//指定エレメント＞フォームdisabled
function check_select_disabled( element ){
	if( $( element ).prop('selected')==false && $( element ).val()=='' ){
		$( element ).prop('disabled', true);
	}
}


function set_form_action($){
	check_input_disabled( $, 'input[name="property_name"]');
	
	$('form').find('select').each(function(){
		if( $(this).val()=='' ){
			$(this).prop('disabled', true);
		}
	});
}


function set_search_form($){
	
	var device_width;
	if( location.pathname.search('property_list') == -1 ){
		device_width = 960;
	}else{
		device_width = 1248;
	}
	
	if( window.innerWidth <= 540 ){
		set_side_search_form($);
	}
	
	set_search_form_category_title($);
	
	set_side_form_category( $, '.slide_open_station', '.slide_close_station', '.side_form_station' );
	set_side_form_category( $, '.slide_open_area', '.slide_close_area', '.side_form_area' );
	
	$('body').append( $('.search_form_station_sp').detach() );
	$('body').append( $('.search_form_area_sp').detach() );
	
	//家賃、価格検索フォーム＞物件一覧
	set_search_price( $ );
	$('.accordion_body').find('input').click(function(){
		set_search_price( $ );
	});
	
	if( $(window).width() <= 280 ){
		$('.checkbox_property_type_child').removeClass('s6').addClass('s12');
		$('.checkbox_facility').removeClass('s4').addClass('s6');
		$('.checkbox_property_category').removeClass('s4').addClass('s6');
	}else{
		$('.checkbox_property_type_child').removeClass('s12').addClass('s6');
		$('.checkbox_facility').removeClass('s6').addClass('s4');
		$('.checkbox_property_category').removeClass('s6').addClass('s4');
	}
	
}


function set_side_search_form($){
	$('.side_form_open').click(function(){
		$('html').css('overflow','hidden');
	});
	
	$('.sidenav-close').click(function(){
		$('html').css('overflow','auto');
	});
	
	$('.remodal-confirm, .side_form_close, .slide_close_station, .slide_close_area').click(function(){
		setTimeout(function(){
			$('body').css('overflow','hidden');
		},0);
	});
	
}


function set_side_form_category( $, open_element, close_element, side_element ){
	var side_search_form = $( side_element ).sidenav({edge: 'left', draggable: false});
	var instance_station = M.Sidenav.getInstance( side_search_form );
	
	var device_width;
	if( location.pathname.search('property_list') == -1 ){
		device_width = 960;
	}else{
		device_width = 1248;
	}
	
	if( window.innerWidth <= device_width ){
		$( close_element + ', .side_form_close').click(function(){
			instance_station.close();
		});
	}
}


function set_search_form_category_title($){
	if( window.innerWidth <= 540 ){
		//検索フォーム＞スマホ用＞スライド＞カテゴリー
		$('.modal-footer').find('div:eq(1)').addClass('side_form_close');
		$('.search_form_station_tablet').find('a').removeClass('search_title_station');
		$('.search_form_area_tablet').find('a').removeClass('search_title_area');
		$('.search_form_station_sp_wrap').children('a').addClass('search_title_station');
		$('.search_form_area_sp_wrap').children('a').addClass('search_title_area');
	}else{
		$('.search_form_station_sp_wrap').find('a').removeClass('search_title_station');
		$('.search_form_area_sp_wrap').find('a').removeClass('search_title_area');
		$('.search_form_station_wrap').children('a').addClass('search_title_station');
		$('.search_form_area_wrap').children('a').addClass('search_title_area');
	}
}


//家賃、価格＞物件一覧
function set_search_price( $ ){
	var price_val = [];
	var select_price = $('.select_price');
	var element_rentals = $('.price_title_rentals, .price_low_rentals, .price_high_rentals');
	var element_rentals_select = $('.price_low_rentals select[name=price_low], .price_high_rentals select[name=price_high]');
	var element_real_estate = $('.price_title_real_estate, .price_low_real_estate, .price_high_real_estate');
	var element_real_estate_select = $('.price_low_real_estate select[name=price_low], .price_high_real_estate select[name=price_high]');
	var property_type = null;
	$('.accordion_body').find('input').each(function(){
		if( $(this).prop('checked') ){
			
			if( $(this).val().indexOf('rentals')!= -1 ){
				property_type = 'rentals';
			}else{
				property_type = 'real_estate';
			}
			price_val.push( $(this).val() );
		}
	});
	
	if( price_val.length==0 ){
		select_price.hide();
		element_rentals.hide();
		element_real_estate.hide();
	}else{
		select_price.show();
		
		if( property_type=='rentals' ){
			element_real_estate.hide();
			element_real_estate_select.prop('disabled', true);
			element_rentals.show();
			element_rentals_select.prop('disabled', false);
		}else{
			element_rentals.hide();
			element_rentals_select.prop('disabled', true);
			element_real_estate.show();
			element_real_estate_select.prop('disabled', false);
		}
		
	}
}

//物件タイプ
function set_action_accordion( $ ){
	$('.accordion li .accordion_body').hide();
	
	$('.accordion li input').each(function(){
		if( $(this).prop('checked') ){
			$(this).parents('.accordion_body').show();
		}
	});
	
	$('.property_parent, .checkbox_children').click(function(){
		if( $(this).prop('checked') ){
			$(this).parents('.checkbox_parent_wrap').next('div').find('input').prop('checked',false);
			$(this).parents('.checkbox_parent_wrap').next('div').find('input').prop('disabled',true);
			
			$('.accordion_body').not($(this).parents('.accordion_body')).find('input').prop('checked', false);
			$('.accordion_body').not($(this).parents('.accordion_body')).find('input').prop('disabled', false);
		}else{
			$(this).parents('.checkbox_parent_wrap').next('div').find('input').prop('disabled',false);
		}
	});
	
	var checked_cnt = 0;
	var count = 0;
	$('.checkbox_children').click(function(){
		
		checked_cnt = $(this).parents('.checkbox_property_type_child_wrap').find('input:checked').length;
		count = $(this).parents('.checkbox_property_type_child_wrap').find('input').length;
		
		if( checked_cnt==count ){
			$(this).parents('.checkbox_property_type_child_wrap').prev('.checkbox_parent_wrap').find('.property_parent').prop('checked', true);
			$(this).parents('.checkbox_property_type_child_wrap').find('input').prop('checked', false);
			$(this).parents('.checkbox_property_type_child_wrap').find('input').prop('disabled', true);
		}
		
	});
	
	$('.accordion_header').click(function(){
	    $(this).next('.accordion_body').slideToggle('fast');
	    $(this).parents('li').toggleClass("active");
	    $('.accordion_header').not($(this)).next('.accordion_body').slideUp('fast');
	    $('.accordion_header').not($(this)).parents('li').removeClass("active");
	    return false;
	});
}




