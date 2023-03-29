<?php
/*
Template Name: プロフィール
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
$get_inquiry_form_title = get_inquiry_form_title();
$get_inquiry_form_value = get_inquiry_form_value();
$user = wp_get_current_user();
$get_my_user_meta = get_my_user_meta();
?>
<main role="main">
<div class="container">
	<div class="row">
		
		<div class="col s8 offset-s2 profile_wrap">
			
			<h5><?php echo articnet_echo_string('profile'); ?></h5>
				
			<div class="col s12"><p><span class="red-text">※</span><?= $get_inquiry_form_title['mark_is_required']->name ?></p></div>
			
			<div class="col s12 user_form_wrap">
			<form action="<?php the_permalink(); ?>" method="post" class="user_form">
				<?php wp_nonce_field( 'set_nonce_action', 'set_nonce' ); ?>
				<div class="error"></div>
				<div class="input-field">
				<?= set_form_inquiry_input( $get_inquiry_form_title, 'text', 'full_name', 'account_circle', true, get_full_name() ) ?>
		        </div>

				<div class="input-field">
					<?= set_form_inquiry_input( $get_inquiry_form_title, 'email', 'user_email', 'email', true, $user->user_email ) ?>
		        </div>

				<!--国籍-->
				<div class="input-field">
					<?= set_form_inquiry_input( $get_inquiry_form_title, 'text', 'nationality', 'language', true, $get_my_user_meta['nationality'] ) ?>
				</div>
				<!--電話番号-->
				<div class="input-field">
					<?= set_form_inquiry_input( $get_inquiry_form_title, 'tel', 'phone', 'phone', false, $get_my_user_meta['phone'] ) ?>
				</div>

				<!--保証人の有無-->
				<div class="col s12 user_radio_wrap">
					<div><i class="material-icons left" style="margin-right: 10px;">group</i><?= $get_inquiry_form_title['guarantor']->name ?></div>
					<div class="radio_button_ui">
					<?= set_form_contact_radio( $get_inquiry_form_title, 'guarantor', $get_inquiry_form_value, false, $get_my_user_meta['guarantor'] ); ?>
					</div>
				</div>
				
				<!--日本語は話せますか？-->
				<div class="col s12 user_radio_wrap">
					<div><i class="material-icons left" style="margin-right: 10px;">chat</i><?= $get_inquiry_form_title['speak_japanese']->name ?><span class="red-text">※</span></div>
					<div>
					<?= set_form_contact_radio( $get_inquiry_form_title, 'speak_japanese', $get_inquiry_form_value, true, $get_my_user_meta['speak_japanese'] ); ?>
					</div>
				</div>
					
				<!--VISAの種類-->
				<div class="col s12 user_radio_wrap">
					<div><i class="material-icons left" style="margin-right: 10px;">security<!--verified_user--></i><?= $get_inquiry_form_title['visa_type']->name ?></div>
					<div>
					<?= set_form_contact_radio( $get_inquiry_form_title, 'visa_type', $get_inquiry_form_value, false, $get_my_user_meta['visa_type'] ); ?>
					</div>
				</div>
			
				<!--現在のお住まい-->
				<div class="col s12 current_residence_top_wrap">
					<div><i class="material-icons left">person_pin_circle</i><?= $get_inquiry_form_title['current_residence']->name ?></div>
					<div class="col s12 current_residence_wrap">
<?php
set_form_contact_radio( $get_inquiry_form_title, 'current_residence', $get_inquiry_form_value, false, $get_my_user_meta['current_residence'] );
?>
					</div>
				</div>
			
				<!--ご職業-->
				<div class="col s12 input-field profession_wrap">
					<?= set_form_inquiry_input( $get_inquiry_form_title, 'text', 'profession', 'business', true, $get_my_user_meta['profession'] ) ?>
				</div>
			
				<!--ペットの飼育-->
				<div class="col s12 have_pets_wrap">
					<div class="have_pets_title">
						<i class="fas fa-paw" aria-hidden="true"></i><label for="have_pets" class=""><?= $get_inquiry_form_title['have_pets']->name ?></label>
					</div>
					<div class="col s12 have_pets_form">
						<div class="col s4">
<?php
set_form_contact_radio( $get_inquiry_form_title, 'have_pets', $get_inquiry_form_value, false, $get_my_user_meta['have_pets'] );
?>
						</div>
						<div class="col s8 input-field">
							<?= set_form_inquiry_input( $get_inquiry_form_title, 'text', 'type', null, false, $get_my_user_meta['type'] ) ?>
						</div>
					</div>
				</div>
				
    			<div class="col s12 user_form_submit_wrap" align="center"><p><button type="submit" name="update_profile" value="true" class="btn waves-effect waves-light user_form_submit"><?php echo articnet_echo_string('update_profile'); ?><i class="material-icons right">send</i></button></p></div>
    			
    		</form>
		</div>
		
		<div class="col s12 btn_profile">
			<div><a href="<?= home_url('/change_password'); ?>" class="btn bgnone black-text waves-effect waves-teal"><?php echo articnet_echo_string('change_password'); ?><i class="material-icons right">cached</i></a></div>
			<div><a href="<?= home_url('/withdrawal'); ?>" class="btn bgnone black-text waves-effect waves-teal"><?php echo articnet_echo_string('cancel_the_membership'); ?><i class="material-icons right">delete_forever</i></a></div>
		</div>
    	
	</div>
</div>
</main>


<script>
jQuery(function($){
	
	$('input[name="user_email"]').blur(function(){
		var regexp = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
  		if (regexp.test( $(this).val() )) {
  			$('.error').text('');
  			$('.user_form_submit').prop('disabled', false);
  		}else{
  			$(this).focus();
  			$('.error').text('<?= get_field_articnet('msg_pattern'); ?>');
			$('.user_form_submit').prop('disabled', true);
  		}
	});
	
	$('.user_form').submit(function(event){
		var user_email = $('input[name="user_email"]').val();
		event.preventDefault();
		var ajaxpost = new FormData( this );
		ajaxpost.append('action', 'set_action_profile' );
		
	    $.ajax({
	        type: 'POST',
	        url: ajaxurl,
	        data: ajaxpost,
			contentType: false,
	        processData: false,
	        success: function( response ){
	        	console.log( response );
	        	if( response.indexOf('update')!=-1 ){
	        		alert('<?= get_field_articnet('update_profile_done'); ?>');
	        		window.location.href = '<?= is_page('profile'); ?>';
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
</script>


<?php get_template_part('parts/footer', 'form_validate'); ?>


<?php get_footer(); ?>