<?php
/*
Template Name:お気に入り
*/
?>
<?php
if ( !is_user_logged_in() ) {
	wp_safe_redirect( home_url('/login') );
	exit();
}
?>
<?php
$get_favorite = get_favorite();
?>
<?php get_header(); ?>

<main role="main">
<div class="container favorite_wrap">
	<div class="row">
		<div class="col s12 favorite_page_title"><h5><i class="material-icons bottom">favorite</i><?= the_title(); ?></h5></div>
		
		<form action="<?= home_url('/inquiry_form/') ?>" method="get" class="favorite_property_list">
			
		<div class="col s12">
			<div align="center">
<?php
$get_favorite = get_favorite();
if( !empty( $get_favorite ) ){
	foreach( $get_favorite as $key => $value ){
		
		echo '<div class="col s3 card property_list_wrap">';
		echo '<div class="property_list" style="position: relative;">';
		set_view_property_single( $value->ID );
		
		echo '<div align="center"><a href="'.home_url('/inquiry_form/').'?property='.__($value->post_name).'" class="btn indigo white-text waves-effect waves-light">';
		echo articnet_echo_string('make_an_inquiry');
		echo '<i class="material-icons right">mail</i></a></div>';
		echo '</div>';
		echo '<div align="center"><label><input type="checkbox" name="property_id[]" value="'.$value->ID.'"/><span></span></label></div>';
		echo '</div>';
		
	}
	
	
}

?>
			</div>
		</div>
		
		<?php if( !empty( $get_favorite ) ): ?>
		<div class="col s12 error" align="center"></div>
		
		<div class="col s12 btn_favorite_wrap">
			<div class="col s12 m4" align="center"><button class="btn check_all bgnone black-text waves-effect waves-light"><i class="material-icons left">done_all</i><?php echo articnet_echo_string('check_all'); ?></button><button class="btn uncheck_all bgnone black-text"><i class="material-icons left">done_all</i><?php echo articnet_echo_string('uncheck'); ?></button></div>
			<div class="col s12 m4" align="center"><button type="submit" class="btn favorite_all_contact waves-effect waves-light"><i class="material-icons left">library_books</i><?php echo articnet_echo_string('inquire_in_bulk'); ?></button></div>
			<div class="col s12 m4" align="center"><button type="submit" class="btn pink favorite_delete waves-effect waves-light"><i class="material-icons left">delete</i><?php echo articnet_echo_string('remove_from_favorites'); ?></button></div>
		</div>
		<?php else: ?>
			<div class="col s12 no_registration"><p><?php echo articnet_echo_string('no_registration'); ?></p></div>
		<?php endif; ?>
			
		</form>
		
	</div>
</div>
</main>


<script>
jQuery(function($){
	
	set_checked_property($);
	
	$('.check_all').click(function(){
		$(this).hide();
		$('.uncheck_all').show();
		$('.favorite_property_list').find('input').prop('checked', true);
		return false;
	});
	
	$('.uncheck_all').click(function(){
		$(this).hide();
		$('.check_all').show();
		$('.favorite_property_list').find('input').prop('checked', false);
		return false;
	});
	
	
	$('.favorite_all_contact').click(function(){
		var check = set_check_property($);
		if( check==true ){
			$(this).submit();
		}
		return check;
	});
	
	$('.favorite_delete').click(function(){
		var check = set_check_property($);
		if( check==true ){
			var ajaxpost = new FormData( $('.favorite_property_list').get(0) );
			ajaxpost.append('action', 'set_action_delete_favorite' );
			
		    $.ajax({
		        type: 'POST',
		        url: ajaxurl,
		        data: ajaxpost,
				contentType: false,
		        processData: false,
		        success: function( response ){
		        	console.log( response );
		        	if( response.indexOf('delete')!=-1 ){
		        		alert('<?= get_field_articnet('removed_from_favorites'); ?>');
		        		window.location.href = '<?= home_url('/favorite'); ?>';
		        	}
		        },
		        error: function( response ){
	                console.log( response );
	            }
		    });
		}
	    return false;
	});
	
});


function set_checked_property($){
	
	var checkbox_len = $('input[type="checkbox"]:checked').length;
	var checked_len = $('input[type="checkbox"]:checked').length;
	if( checked_len==0 ){
		$('.uncheck_all').hide();
	}else if( checkbox_len==checked_len ){
		$('.check_all').hide();
	}else{
		$('.uncheck_all').hide();
	}
}


function set_check_property($){
	var check_elm_array = {};
	$('.favorite_property_list').find('input').each(function( key, value ){
		if( $(value).prop('checked') ){
			check_elm_array[key] = 1;
		}else{
			delete check_elm_array[key];
		}
	});
	
	var check_elm_len = Object.keys(check_elm_array).length;
	
	if( check_elm_len==0 ){
		$('.error').text('<?php echo articnet_echo_string('please_check'); ?>');
		return false;
	}else{
		$('.error').text('');
		return true;
	}
}


</script>


<?php get_footer(); ?>