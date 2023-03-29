<script>
jQuery(function($){
	
	setCustomValidity($);
	
	$('input[name="user_email"], input[name="user_pass"]').css({ 'ime-mode' : 'disabled' });
	
});


//入力フォームバリデート
function setCustomValidity( $ ){
	
	var VALID_MESSAGE_REQUIRED = '<?= json_encode( get_field_articnet('msg_empty') ) ?>';
	var VALID_MESSAGE_TYPE = '<?= json_encode( get_field_articnet('msg_type') ) ?>';
	var VALID_MESSAGE_PATTERN = '<?= json_encode( get_field_articnet('msg_pattern') ) ?>';
	
	$("input.required_input").each(function(index, elem) {
	    if(elem.validity.valueMissing){
	        elem.setCustomValidity(VALID_MESSAGE_REQUIRED);
	    }
	    
		$(elem).blur(function() {
	        if( elem.validity.valueMissing ){
	            elem.setCustomValidity(VALID_MESSAGE_REQUIRED);
	        }else if(elem.validity.typeMismatch) {
	            elem.setCustomValidity(VALID_MESSAGE_TYPE);
	        }else{
	            elem.setCustomValidity("");
	        }
		});
	    
	});
	
	$('input[type="tel"]').blur(function(e){
	    if ( e.target.validity.patternMismatch ) {
	        e.target.setCustomValidity(VALID_MESSAGE_PATTERN);
	    }else{
	    	e.target.setCustomValidity('');
	    }
	});
	
	set_checked_validate( $, '.floor_plan');
	set_checked_validate( $, 'input[name="speak_japanese"]');
}


function set_checked_validate( $, element ){
	var check_val;
	$( element ).each(function(index, e) {
		if( !$(e).prop('checked') || !$(e).val() ){
			check_val = 0;
			e.setCustomValidity('<?= json_encode( get_field_articnet('please_check') ) ?>');
		}else{
			check_val = 1;
			return false;
		}
	});
	
	$( element ).each(function(index, e) {
		if( check_val > 0 ){
			e.setCustomValidity("");
		}
	});
	
//	console.log( check_val );
	
	$( element ).click(function() {
		$( element ).each(function(index, e) {
			if( $(e).prop('checked') || $(e).val() ){
				check_val = 1;
			}
			if( check_val > 0 ){
				e.setCustomValidity("");
			}
		});
	});
}




</script>