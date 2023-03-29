<?php
/*
Template Name:パスワード再設定
*/
?>
<?php
if ( is_user_logged_in() ) {
	wp_safe_redirect( get_referer() );
	exit();
}
?>
<?php get_header(); ?>
<?php
$get_inquiry_form_title = get_inquiry_form_title();
?>
<main role="main">
<div class="container">
	<div class="row">
		
		<div class="col s4 offset-s4 reset_password_wrap">
			
			<h5><?php echo articnet_echo_string('reset_password'); ?></h5>
			
			<form action="<?php the_permalink(); ?>" method="post" class="user_form">
				<?php wp_nonce_field( 'set_nonce_action', 'set_nonce' ); ?>
				<div class="error"></div>
				<div class="input-field col s12">
					<i class="material-icons prefix">mail</i>
					<input id="user_email" type="email" name="user_email" value="" class="required_input" required>
					<label for="user_email"><?= $get_inquiry_form_title['user_email']->name; ?></label>
		        </div>

    			<div class="col s12" align="center"><p><button type="submit" name="reset_password" value="true" class="btn waves-effect waves-light"><?php echo articnet_echo_string('reset_password'); ?><i class="material-icons right">send</i></button></p></div>
    			
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
		ajaxpost.append('action', 'set_action_reset_password' );
		
	    $.ajax({
	        type: 'POST',
	        url: ajaxurl,
	        data: ajaxpost,
			contentType: false,
	        processData: false,
	        success: function( response ){
	        	console.log( response );
	        	if( response.indexOf('reset')!=-1 ){
	        		alert('<?= get_field_articnet('password_reset_information'); ?>');
	        		window.location.href = '<?= home_url('/login'); ?>';
	        	}else{
	        		$('.error').html( '<?= get_field_articnet('no_registration'); ?>');
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


<?php get_template_part('parts/footer', 'form_validate'); ?>


<?php get_footer(); ?>