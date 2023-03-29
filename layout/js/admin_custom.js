jQuery(function($) {
	
	// we create a copy of the WP inline edit post function
	var $wp_inline_edit = inlineEditPost.edit;

	// and then we overwrite the function with our own code
	inlineEditPost.edit = function( id ) {

		// "call" the original WP edit function
		// we don't want to leave WordPress hanging
		$wp_inline_edit.apply( this, arguments );

		// now we take care of our business

		// get the post ID
		var $post_id = 0;
		if ( typeof( id ) == 'object' ) {
			$post_id = parseInt( this.getId( id ) );
		}

		if ( $post_id > 0 ) {
			// define the edit row
			var $edit_row = $( '#edit-' + $post_id );
			var $post_row = $( '#post-' + $post_id );

			// get the data
			var $apartment_room = $( '.column-apartment_room', $post_row ).text();
			var $vacancy_confirmation_date = $( '.column-vacancy_confirmation_date', $post_row ).text();
			var $sold = !! $('.column-sold', $post_row ).text();

			// populate the data
			$( ':input[name="apartment_room"]', $edit_row ).val( $apartment_room );
			var vacancy_confirmation_date = replaceDate( $vacancy_confirmation_date );
			$( ':input[name="vacancy_confirmation_date"]', $edit_row ).val( vacancy_confirmation_date );
			$( ':input[name="sold"]', $edit_row ).val($sold).prop('checked', $sold );
		}
	};

});


function replaceDate( param ){
	var replace = param.replace('年', '-').replace('月', '-').replace('日', '-').slice(0, -1);
	return replace;
}



