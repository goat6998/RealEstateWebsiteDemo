
jQuery(function($){
	
	$('.timepicker').timepicker();
	
	check_login_form( $ );
	
	check_required( $ );
	
	$('.privacy_policy_agree').click(function(){
		$('.inquiry_form_submit').prop('disabled',false);
	});
	
	resize_property_inquiry($);
	$(window).resize(function(){
		resize_property_inquiry($);
	});
	
});


//お問い合わせフォーム
function resize_property_inquiry($){
	
	if( window.innerWidth <= 414 ){
		$('.desired_date_wrap').removeClass('s6').addClass('s12');
		$('.desired_time_wrap').removeClass('s6').addClass('s12');
		$('.desired_date2_wrap').removeClass('s6').addClass('s12');
		$('.desired_time2_wrap').removeClass('s6').addClass('s12');
	}else{
		$('.desired_date_wrap').removeClass('s12').addClass('s6');
		$('.desired_time_wrap').removeClass('s12').addClass('s6');
		$('.desired_date2_wrap').removeClass('s12').addClass('s6');
		$('.desired_time2_wrap').removeClass('s12').addClass('s6');
	}
	
	if( window.innerWidth <= 768 ){
		$('.inquiry_property_wrap').removeClass('offset-s3 s6 offset-s2 s8').addClass('s12');
	}else if( window.innerWidth >= 768 && window.innerWidth <= 1200 ){
		$('.inquiry_property_wrap').removeClass('offset-s3 s6 s12').addClass('offset-s2 s8');
	}
	
	if( window.innerWidth <= 768 ){
		$('.stay_in_japan').removeClass('s6').addClass('s12');
		$('.have_pets').removeClass('s6').addClass('s12');
		$('.number_of_residents').removeClass('s6').addClass('s12');
		$('.full_name_wrap').removeClass('s6').addClass('s12');
		$('.user_email_wrap').removeClass('s6').addClass('s12');
		$('.nationality_wrap').removeClass('s6').addClass('s12');
		$('.phone_wrap').removeClass('s6').addClass('s12');
		$('.first_choice_wrap').removeClass('s6').addClass('s12');
		$('.second_choice_wrap').removeClass('s6').addClass('s12');
		$('.current_residence_top_wrap').removeClass('s7').addClass('s12');
		$('.profession_wrap').removeClass('s5').addClass('s12');
		$('.desired_size_wrap').removeClass('s6').addClass('s12');
		$('.rent_price_main_wrap').removeClass('s6').addClass('s12');
		$('.moving_date_wrap').removeClass('s6').addClass('s12');
		$('.null_wrap_s8').removeClass('s8').addClass('s12');
	}else{
		$('.stay_in_japan').removeClass('s12').addClass('s6');
		$('.have_pets').removeClass('s12').addClass('s6');
		$('.number_of_residents').removeClass('s12').addClass('s6');
		$('.full_name_wrap').removeClass('s12').addClass('s6');
		$('.user_email_wrap').removeClass('s12').addClass('s6');
		$('.nationality_wrap').removeClass('s12').addClass('s6');
		$('.phone_wrap').removeClass('s12').addClass('s6');
		$('.first_choice_wrap').removeClass('s12').addClass('s6');
		$('.second_choice_wrap').removeClass('s12').addClass('s6');
		$('.current_residence_top_wrap').removeClass('s12').addClass('s7');
		$('.profession_wrap').removeClass('s12').addClass('s5');
		$('.desired_size_wrap').removeClass('s12').addClass('s6');
		$('.rent_price_main_wrap').removeClass('s12').addClass('s6');
		$('.moving_date_wrap').removeClass('s12').addClass('s6');
		$('.null_wrap_s8').removeClass('s12').addClass('s8');
	}
	
	if( window.innerWidth <= 1259 ){
		$('.guarantor_wrap').removeClass('s5').addClass('s12');
		$('.speak_japanese_wrap').removeClass('s7').addClass('s12');
		$('.floor_plan_wrap').removeClass('s7').addClass('s12');
		$('.search_area_wrap').removeClass('s5').addClass('s12');
	}else{
		$('.guarantor_wrap').removeClass('s12').addClass('s5');
		$('.speak_japanese_wrap').removeClass('s12').addClass('s7');
		$('.floor_plan_wrap').removeClass('s12').addClass('s7');
		$('.search_area_wrap').removeClass('s12').addClass('s5');
	}

}


function check_required( $ ){
	
	$('form').find('.required').on('blur click',function(){
		
		var check_val = checkInputValue( $, '.required_input');
		var speak_japanese = get_checked_length( $, 'input[name="speak_japanese"]');
		var floor_plan = get_checked_length( $, '.floor_plan');
		
		if( speak_japanese==true && check_val==true && floor_plan==true ){
			$('.set_member_regist_password').attr('disabled',false);
			$('.privacy_policy_btn').attr('disabled',false);
		}else{
			$('.set_member_regist_password').attr('disabled',true);
			$('.privacy_policy_btn').attr('disabled',true);
			$('.inquiry_form_submit').prop('disabled',true);
		}
		
	});
	
}


function check_login_form( $ ){
	var check_val = checkInputValue( $, '.required_input');
	if( check_val==true ){
		$('.privacy_policy_btn').attr('disabled',false);
	}
}


function checkInputValue( $, element ){
	var set_len = $(element).length;
	var set_obj = {};
	var check_value = {};
	$(element).each(function( key, elm ){
		if( $(elm).val()!='' ){
			set_obj[key] = 1;
			check_value[key] = $(elm).val();
		}else{
			delete set_obj[key];
			delete check_value[key];
		}
	});
	var check_len = Object.keys(set_obj).length;
	
	if( set_len==check_len ){
		return true;
	}else{
		return false;
	}
}


function get_checked_length( $, check_radio ){
	if( $(check_radio + ':checked').length > 0 ){
		return true;
	}else{
		return false;
	}
}



