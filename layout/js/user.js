jQuery(function($){
	
	setResizeUserPage($);
	$(window).resize(function(){
		setResizeUserPage($);
	});
	
});


//会員ページ
function setResizeUserPage($){
	
	if( window.innerWidth <= 375 ){
		$('.have_pets_form').find('div:nth-child(1)').removeClass('s4').addClass('s12');
		$('.have_pets_form').find('div:nth-child(2)').removeClass('s8').addClass('s12');
	}else{
		$('.have_pets_form').find('div:nth-child(1)').removeClass('s12').addClass('s4');
		$('.have_pets_form').find('div:nth-child(2)').removeClass('s12').addClass('s8');
	}
	
	if( window.innerWidth <= 960 ){
		$('.inquiry_property_wrap').removeClass('s6 offset-s3').addClass('s12');
		$('.login_form_wrap').removeClass('s4 offset-s4').addClass('s12');
		$('.login_form_wrap').removeClass('s6 offset-s3').addClass('s12');
		$('.reset_password_wrap').removeClass('s4 offset-s4').addClass('s12');
		$('.change_password').removeClass('s6 offset-s3').addClass('s12');
		$('.profile_wrap').removeClass('s8 offset-s2').addClass('s12');
	}else{
		$('.inquiry_property_wrap').removeClass('s12').addClass('s6 offset-s3');
		$('.login_form_wrap').removeClass('s12').addClass('s4 offset-s4');
		$('.login_form_wrap').removeClass('s12').addClass('s6 offset-s3');
		$('.reset_password_wrap').removeClass('s12').addClass('s4 offset-s4');
		$('.change_password').removeClass('s12').addClass('s6 offset-s3');
		$('.profile_wrap').removeClass('s12').addClass('s8 offset-s2');
	}
}