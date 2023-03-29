<?php
/*
Template Name:ログイン
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

		<div class="col s4 offset-s4 login_form_wrap">
			<h5><?= the_title(); ?></h5>
			
			<form action="<?php the_permalink(); ?>" method="post" class="login_form">
				<?php wp_nonce_field( 'set_nonce_action', 'set_nonce' ); ?>
				<div class="error"></div>
				<div class="input-field col s12 user_email_wrap">
					<i class="material-icons prefix">email</i>
					<input id="user_email" type="email" name="user_email" class="required_input" required>
					<label for="user_email"><?= $get_inquiry_form_title['user_email']->name ?></label>
				</div>
				
				<div class="input-field col s12">
					<i class="material-icons prefix">vpn_key</i>
					<input id="user_pass" type="password" name="user_pass" class="required_input" required>
					<label for="user_pass"><?php echo articnet_echo_string('password'); ?></label>
				</div>
				
				<div class="col s12" align="center"><button type="submit" class="btn waves-effect waves-light login_form_submit"><?php echo articnet_echo_string('login'); ?><i class="material-icons right">power_settings_new</i></button></div>
			</form>
			
			<div style="margin: 3rem 0 3rem 0;">
				<div style="margin-bottom:10px;"><a href="/register" class="btn white blue-text waves-effect waves-light"><i class="material-icons small bottom">person_add</i> <?php echo articnet_echo_string('register'); ?></a></div>
				<div><a href="/reset_password" class="btn white blue-text waves-effect waves-light"><i class="material-icons small bottom">refresh</i> <?php echo articnet_echo_string('reset_password'); ?></a></div>
			</div>
		</div>
		
	</div>
</div>
</main>


<script>
jQuery(function($){
	
	$('.login_form').submit(function(event){
		event.preventDefault();
		var ajaxpost = new FormData( this );
		ajaxpost.append('action', 'set_action_login_check' );
		
	    $.ajax({
	        type: 'POST',
	        url: ajaxurl,
	        data: ajaxpost,
			contentType: false,
	        processData: false,
	        success: function( response ){
	        	var setJson = $.parseJSON( response );
	        	console.log( setJson );
	        	
	        	if( setJson.indexOf('login')!=-1 ){
	        		window.location.href = '<?= get_referer( true ); ?>';
	        	}else{
	        		$('.error').html(setJson);
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