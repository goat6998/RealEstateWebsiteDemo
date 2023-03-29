<?php
/*
Template Name:パスワード再設定
*/
?>
<?php
if ( !is_user_logged_in() ) {
	wp_safe_redirect( get_referer() );
	exit();
}
?>
<?php get_header(); ?>
<?php
$user = wp_get_current_user();
?>
<main role="main">
<div class="container">
	<div class="row">
		
		<div class="col s6 offset-s3 change_password">
			
			<h5><?php echo articnet_echo_string('change_password'); ?></h5>
			
			<form action="<?php the_permalink(); ?>" method="post" class="user_form">
				<?php wp_nonce_field( 'set_nonce_action', 'set_nonce' ); ?>
				<div class="error"></div>
				<div class="input-field col s12">
					<i class="material-icons prefix">vpn_key</i>
					<input id="user_pass" type="tel" name="user_pass" value="" class="required_input password" required>
					<label for="user_pass"><?php echo articnet_echo_string('password'); ?></label>
		        </div>

				<div class="input-field col s12">
					<i class="material-icons prefix">vpn_lock</i>
					<input id="user_pass_check" type="password" name="user_pass_check" value="" class="required_input password" required>
					<label for="user_pass_check"><?php echo articnet_echo_string('confirm_password'); ?></label>
		        </div>
		        	
    			<div class="col s12" align="center"><p><button type="submit" name="update_password" value="true" class="btn waves-effect waves-light"><?php echo articnet_echo_string('change_password'); ?><i class="material-icons right">sync</i></button></p></div>
    			
    		</form>
    			
    	</div>
    	
	</div>
</div>
</main>


<script>
jQuery(function($){
	
	$('.user_form').find('input.password').blur(function(){
		var user_pass = $('input[name="user_pass"]').val();
		var user_pass_check = $('input[name="user_pass_check"]').val();
		if( user_pass!='' && user_pass_check!='' && user_pass!=user_pass_check ){
			$('.error').text('<?= get_field_articnet('incorrect_password'); ?>');
			$('.privacy_policy_btn').attr('disabled', true);
			$('.register_form_submit').prop('disabled', true);
		}else{
			$('.error').text('');
			$('.privacy_policy_btn').attr('disabled', false);
		}
	});
	
	$('.user_form').submit(function(event){
		event.preventDefault();
		var ajaxpost = new FormData( this );
		ajaxpost.append('action', 'set_action_password' );
		
	    $.ajax({
	        type: 'POST',
	        url: ajaxurl,
	        data: ajaxpost,
			contentType: false,
	        processData: false,
	        success: function( response ){
	        	console.log( response );
	        	if( response.indexOf('update')!=-1 ){
	        		alert('<?= get_field_articnet('password_setting_done'); ?>');
	        		window.location.href = '<?= home_url('/profile'); ?>';
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