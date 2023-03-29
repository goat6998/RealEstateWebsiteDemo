var map = null;

function new_map( $el ) {
	var $markers = $el.find('.marker');
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng(0, 0),
			mapTypeId	: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map( $el[0], args);
		map.markers = [];
		$markers.each(function(){
		add_marker( jQuery(this), map );
	});
	center_map( map );
	return map;
}

function add_marker( $marker, map ) {
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
	var marker = new google.maps.Marker({
		position	: latlng,
		map			: map
	});

	map.markers.push( marker );
	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() ){
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html()
		});
		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open( map, marker );
		});
	}
}

function center_map( map ) {
	var bounds = new google.maps.LatLngBounds();
	jQuery.each( map.markers, function( i, marker ){
		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
		bounds.extend( latlng );
	});

	if( map.markers.length == 1 ){
		map.setCenter( bounds.getCenter() );
		map.setZoom( 16 );
	}else{
		map.fitBounds( bounds );
	}
}

jQuery(function($){
	
	new_map( $('.googlemap') );
//	new_map( $('.googlemap_sp') );
	
	setResizeGoogleMap($);
	$(window).resize(function(){
		setResizeGoogleMap($);
	});
	


});

function setResizeGoogleMap($){
	if( window.innerWidth <= 1024 ){
		var h = $(window).height();
		var height = h - ( h / 3 );
		$('.googlemap').css({ 'height': height + 'px'});
	}
}

