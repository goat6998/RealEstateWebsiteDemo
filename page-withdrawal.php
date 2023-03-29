<?php
/*
Template Name:会員退会
*/
?>
<?php
if ( !is_user_logged_in() ) {
	wp_safe_redirect( get_referer() );
	exit();
}
?>
<?php get_header(); ?>

<main role="main">
<div class="container">
	<div class="row">
		
		<div class="col s6 offset-s3 reset_password_wrap">
			
			<h5><?php echo articnet_echo_string('cancel_the_membership'); ?></h5>
			<div class="col s12"><p><?php echo articnet_echo_string('withdrawal'); ?></p></div>
			<form action="<?php the_permalink(); ?>" method="post" class="user_form">
				<?php wp_nonce_field( 'set_nonce_action', 'set_nonce' ); ?>
				<input type="hidden" name="withdrawal" value="true">
    			<div class="col s12" align="center"><p><button type="submit" name="submit" value="true" class="btn red waves-effect waves-light"><?php echo articnet_echo_string('cancel_the_membership'); ?><i class="material-icons right">delete_forever</i></button></p></div>
    			
    		</form>
    			
    	</div>
    	
	</div>
</div>
</main>


<script>
	
jQuery(function($){
	
	$('.user_form').submit(function(event){
		event.preventDefault();
		var ajaxpost = new FormData( this );
		ajaxpost.append('action', 'set_action_withdrawal' );
		
	    $.ajax({
	        type: 'POST',
	        url: ajaxurl,
	        data: ajaxpost,
			contentType: false,
	        processData: false,
	        success: function( response ){
	        	console.log( response );
	        	if( response.indexOf('complete')!=-1 ){
	        		alert('<?= get_field_articnet('withdraw_complete').'\n'.get_field_articnet('withdraw_thanks'); ?>');
	        		window.location.href = '<?= home_url(); ?>';
	        	}
	        },
	        error: function( response ){
                console.log( response );
            }
	    });
	    return false;
	});
	
});
</script>


<?php get_footer(); ?>