
jQuery(function($){
	
	set_resize_property_list($);
	$(window).resize(function(){
		set_resize_property_list($);
	});
	
});


//物件一覧
function set_resize_property_list($){
	
	var search_form_area = $('.checkbox_wrap_out_area').detach();
	var search_form_station = $('.checkbox_main_wrap_station').detach();
	
	var modal_footer_station = $('.checkbox_main_wrap_station').find('.modal-footer').detach();
	var modal_footer_area = $('.checkbox_wrap_out_area').find('.modal-footer').detach();
	
	if( $(window).width() <= 540 ){
		if( !$('.search_form_contents_station').find('.checkbox_main_wrap_station').length ){
			$('.search_form_contents_station').append( search_form_station );
			$('.search_form_contents_station').append( modal_footer_station );
		}
		if( !$('.search_form_contents_area').find('.checkbox_wrap_out_area').length ){
			$('.search_form_contents_area').append( search_form_area );
			$('.search_form_contents_area').append( modal_footer_area );
		}
		
	}else{
		if( !$('.search_modal_station').find('.checkbox_main_wrap_station').length ){
			$('.search_modal_station').append( search_form_station );
			$('.checkbox_main_wrap_station').append( modal_footer_station );
		}
		if( !$('.search_modal_area').find('.checkbox_wrap_out_area').length ){
			$('.search_modal_area').append( search_form_area );
			$('.checkbox_wrap_out_area').append( modal_footer_area );
		}
	}
	
	var search_form;
	if( window.innerWidth <= 1248 ){
		$('.property_list_main_wrap').removeClass('s8').addClass('s12');
		
		if( !$('.search_form_sp').find('#search').length ){
			search_form = $('.search_form').find('#search').detach();
			$('.search_form_sp').append( search_form );
		}
		
	}else{
		$('.property_list_main_wrap').removeClass('s12').addClass('s8');
		
		if( !$('.search_form').find('#search').length ){
			search_form = $('.search_form_sp').find('#search').detach();
			$('.search_form').append( search_form );
		}
		
	}
	
	
	if( window.innerWidth <= 888 ){
		$('.property_list_wrap').removeClass('m4').addClass('m6');
	}else{
		$('.property_list_wrap').removeClass('m6').addClass('m4');
	}
	
	
}

