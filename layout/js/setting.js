
jQuery(function($){
	
	//ヘッダーメニュー、スマホ、タブレット用
	$('.side_menu').sidenav({edge: 'right'});
	
	$(".dropdown-trigger").dropdown({ constrainWidth : false });
	
	$('#widget_main_media_link .widget_media_image').addClass('swiper-slide');
	
	set_top_scroll($);
	
	set_resize_footer($);
	$(window).resize(function(){
		set_resize_footer($);
	});
	
});


function set_top_scroll($){
	if( $(document).height() > 1024 ){
		var pagetop = $('#page-top');
		pagetop.hide();
		var height = $(document).height() / 2;
		$(window).scroll(function () {
			if ($(this).scrollTop() > height) {
				pagetop.fadeIn();
			}else{
				pagetop.fadeOut();
			}
		});
		pagetop.click(function () {
			$('body, html').animate({ scrollTop: 0 }, 500);
			return false;
		});
	}
}


//フッター
function set_resize_footer($){
	if( window.innerWidth <= 770 ){
		$('.footer_menu').removeClass('m6');
		$('.footer_menu').next('div').removeClass('m6');
	}else{
		$('.footer_menu').addClass('m6');
		$('.footer_menu').next('div').addClass('m6');
	} 
}
