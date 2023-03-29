<?php
/*
Template Name:会員登録
*/
?>
<?php
if ( is_user_logged_in() ) {
	wp_safe_redirect( get_referer() );
	exit();
}
?>
<?php get_header(); ?>
<?php $get_inquiry_form_title = get_inquiry_form_title(); ?>

<main role="main">
<div class="container">
	<div class="row">
		<div class="col s6 offset-s3 login_form_wrap">
	
			<div align="center"><h5><i class="material-icons bottom">person_add</i> <?= the_title(); ?></h5></div>
				
			<form action="<?php the_permalink(); ?>" method="post" class="register_form">
				<?php wp_nonce_field( 'set_nonce_action', 'set_nonce' ); ?>
				<div class="error"></div>
				<div class="input-field col s12">
					<i class="material-icons prefix">account_circle</i>
					<input id="full_name" type="text" name="full_name" class="required" required>
					<label for="full_name"><?= $get_inquiry_form_title['full_name']->name ?></label>
				</div>
				
				<div class="input-field col s12">
					<i class="material-icons prefix">email</i>
					<input id="user_email" type="email" name="user_email" class="required" required>
					<label for="user_email"><?= $get_inquiry_form_title['user_email']->name ?></label>
				</div>
				
				<div class="input-field col s12">
					<i class="material-icons prefix">vpn_key</i>
					<input id="user_pass" type="tel" name="user_pass" oncopy="return false" class="required password" required>
					<label for="user_pass"><?php echo articnet_echo_string('password'); ?></label>
				</div>
					
				<div class="input-field col s12">
					<i class="material-icons prefix">vpn_lock</i>
					<input id="user_pass_check" type="password" onpaste="return false" class="required password_check" required>
					<label for="user_pass_check"><?php echo articnet_echo_string('confirm_password'); ?></label>
				</div>
				
				<?= set_view_privacy_policy(); ?>
				
				<div class="col s12" align="center"><button type="submit" class="btn waves-effect waves-light register_form_submit" disabled><?php echo articnet_echo_string('register'); ?><i class="material-icons right">verified_user</i></button></div>
			</form>
			
		</div>
		
	</div>
</div>
</main>


<script>
jQuery(function($){
	
	check_register_required($);
	
	$('.privacy_policy_agree').click(function(){
		$('.register_form_submit').prop('disabled',false);
	});
	
	$('input[name="user_email"]').blur(function(){
		var regexp = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
  		if (regexp.test( $(this).val() )) {
  			$('.error').text('');
  		}else{
  			$(this).focus();
  			$('.error').text('<?= get_field_articnet('msg_pattern'); ?>');
			$('.privacy_policy_btn').attr('disabled', true);
			$('.register_form_submit').prop('disabled', true);
  		}
	});
	
	$('.register_form').find('.password').blur(function(){
		var user_pass = $('.password').val();
		var user_pass_check = $('.password_check').val();
		if( user_pass!='' && user_pass_check!='' && user_pass!=user_pass_check ){
			$('.error').text('<?= get_field_articnet('incorrect_password'); ?>');
			$('.privacy_policy_btn').attr('disabled', true);
		}else{
			$('.error').text('');
			$('.privacy_policy_btn').attr('disabled', false);
		}
	});
	
	$('.register_form').submit(function(event){
		var user_email = $('input[name="user_email"]').val();
		event.preventDefault();
		var ajaxpost = new FormData( this );
		ajaxpost.append('action', 'set_action_member_register' );
		
	    $.ajax({
	        type: 'POST',
	        url: ajaxurl,
	        data: ajaxpost,
			contentType: false,
	        processData: false,
	        success: function( response ){
	        	console.log( response );
	        	if( response.indexOf('register')!=-1 ){
	        		alert('<?= get_field_articnet('member_register_done'); ?>');
	        		window.location.href = '<?= get_referer(); ?>';
	        	}else if( response.indexOf('error_email')!=-1 ){
	        		$('.error').html( user_email + ' <?= get_field_articnet('registered'); ?>');
	        	}else{
	        		$('.error').html( response );
	        	}
	        },
	        error: function( response ){
                console.log( response );
            }
	    });
	    return false;
	});
	
});

function check_register_required( $ ){
	
	$('.register_form').find('.required').on('blur',function(){
		
		var check_val = checkInputValue( $, '.required');
		
		if( check_val==true ){
			$('.privacy_policy_btn').attr('disabled',false);
		}else{
			$('.privacy_policy_btn').attr('disabled',true);
		}
		
	});
	
}


function checkInputValue( $, element ){
	var set_len = $(element).length;
	var set_obj = {};
	$(element).each(function( key, value ){
		if( $(value).val()!='' ){
			set_obj[key] = 1;
		}else{
			delete set_obj[key];
		}
	});
	var check_len = Object.keys(set_obj).length;
	
	if( set_len==check_len ){
		return true;
	}else{
		return false;
	}
}
</script>


<?php get_template_part('parts/footer', 'form_validate'); ?>


<?php get_footer(); ?>