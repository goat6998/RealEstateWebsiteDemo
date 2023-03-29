jQuery(function($){
	
	$('.parallax').parallax();
	
	set_resize_archive_single_page($);
	$(window).resize(function(){
		set_resize_archive_single_page($);
	});
	
});


//アーカイブ、シングル、ページ
function set_resize_archive_single_page($){
	
	var single_sidebar_wrap = $('.single_sidebar_contents').detach();
	
	if( window.innerWidth <= 960 ){
		$('.page_contents_wrap').removeClass('m8');
		if( !$('.single_bottom_sp').find('.single_sidebar_wrap').length ){
			$('.single_bottom_sp').append(single_sidebar_wrap);
			$('.single_bottom_sp').show();
		}
	}else{
		$('.page_contents_wrap').addClass('m8');
		$('.single_sidebar_bottom_wrap').append(single_sidebar_wrap);
		$('.single_bottom_sp').hide();
	}
	
	if( window.innerWidth <= 640 ){
		$('.archive_body').removeClass('s9').addClass('s12');
	}else{
		$('.archive_body').removeClass('s12').addClass('s9');
	}
	
}