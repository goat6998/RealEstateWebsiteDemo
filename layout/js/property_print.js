
jQuery(function($){
	
	$(".set_property_print").hide();
	$(".get_property_print").click(function(event){
		var windowFeatures = "left=0,top=0,width=1138,height=791,toolbar=0,resizable=0";
		var get_property_print = window.open( $(this).attr("href"), "PropertyPrint", windowFeatures );
		
		const ua = navigator.userAgent;
		
		if( ua.indexOf('iPhone') > -1 || (ua.indexOf('Android') > -1 && ua.indexOf('Mobile') > -1) || ua.indexOf('iPad') > -1 || ua.indexOf('Android') > -1 ) {

		}else{
			get_property_print.addEventListener("load", function() {
				get_property_print.print();
			}, true);
	    }
		
		return false;
	});
	
});