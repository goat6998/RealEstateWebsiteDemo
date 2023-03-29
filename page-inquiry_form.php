<?php
/*
Template Name:物件のお問い合わせ
*/
?>
<?php get_header(); ?>
<?php
if ( is_user_logged_in() ) {
	$user = wp_get_current_user();
	$full_name = get_full_name();
}else{
	$full_name = NULL;
	$user_email = NULL;
}
$get_my_user_meta = get_my_user_meta();
$get_inquiry_form_value = get_inquiry_form_value();

#dump( $set_inquiry_form_keys );
?>
<main role="main">
<div class="container">
	<div class="row inquiry_form_wrap">

<?php
if( !empty( $_REQUEST['form'] ) && $_REQUEST['form']=='information' ){
	$form_title = get_field_articnet('information');
}else{
	$form_title = get_field_articnet('inquiry_form');
}
?>
		<div class="col s12 inquiry_form_title" align="center"><h1><i class="material-icons bottom">contact_mail</i><?= $form_title ?></h1></div>
		
		<div class="col s12">
<?php
if( !empty( $_REQUEST['property_id'] ) ){
	set_view_contact_property_list( $_REQUEST['property_id'] );
}else if( !empty( $_REQUEST['property'] ) ){
	set_view_contact_single_property();
}
?>
		</div>
		
		<?php $get_inquiry_form_title = get_inquiry_form_title(); ?>
		
		<div class="col s12 get_inquiry_form_wrap">
			
			<div class="col s12"><span class="red-text">※</span><?= $get_inquiry_form_title['mark_is_required']->name ?></div>
			
			<form action="<?php the_permalink(); ?>" method="post" class="inquiry_form">
				<?php wp_nonce_field( 'set_nonce_action', 'set_nonce' ); ?>
<?php
if( !empty( $_REQUEST['property_id'] ) ){
	$keyname['property_id'] = ( count($_REQUEST['property_id'])==1 ) ? 'property_id' : 'property_id[]';
	foreach( $_REQUEST['property_id'] as $key => $value ){
		echo '<input type="hidden" name="'.$keyname['property_id'].'" value="'.$value.'">';
	}
}else if( !empty( $_REQUEST['property'] ) ){
	echo '<input type="hidden" name="property_id" value="'.get_the_ID().'">';
}
?>
				<!--氏名-->
				<div class="col s6 input-field full_name_wrap">
					<?= set_form_inquiry_input( $get_inquiry_form_title, 'text', 'full_name', 'account_circle', true, $full_name ) ?>
				</div>
				<!--メールアドレス-->
				<div class="col s6 input-field user_email_wrap">
					<?= set_form_inquiry_input( $get_inquiry_form_title, 'email', 'user_email', 'mail', true, $user_email ) ?>
				</div>
				
				<!--国籍-->
				<div class="col s6 input-field nationality_wrap">
					<?= set_form_inquiry_input( $get_inquiry_form_title, 'text', 'nationality', 'language', true, $get_my_user_meta['nationality'] ) ?>
				</div>
				<!--電話番号-->
				<div class="col s6 input-field phone_wrap">
					<?= set_form_inquiry_input( $get_inquiry_form_title, 'tel', 'phone', 'phone', false, $get_my_user_meta['phone'] ) ?>
				</div>
				
				<?php if( empty( $_REQUEST['property_id'] ) && empty( $_REQUEST['property'] ) ): ?>
				<!--知りたい情報-->
				<div class="col s12 information_you_want_to_know_wrap">
					<div><i class="material-icons left">chat</i><?= $get_inquiry_form_title['information_you_want_to_know']->name ?><span class="red-text">※</span></div>
					<div class="col s12 information_you_want_to_know_radio_wrap">
<?php
set_form_contact_radio( $get_inquiry_form_title, 'information_you_want_to_know', $get_inquiry_form_value, true, false );
?>
						<input type="hidden" name="form" value="information">
					</div>
				</div>
				<?php endif; ?>
	
				<div class="col s12 form_section_guarantor_speak_japanese">
					<!--保証人の有無-->
					<div class="col s5 guarantor_wrap">
						<div class="guarantor_title_wrap">
							<div><i class="material-icons left">group</i><?= $get_inquiry_form_title['guarantor']->name ?></div>
							<div class="about_the_guarantor"><a href="/how_to/faqs/#q5" target="_blank"><?= articnet_echo_string('about_the_guarantor'); ?></a></div>
						</div>
						<div class="col s12">
	<?php
	set_form_contact_radio( $get_inquiry_form_title, 'guarantor', $get_inquiry_form_value, false, $get_my_user_meta['guarantor'] );
	?>
						</div>
					</div>
		
					<!--日本語は話せますか？-->
					<div class="col s7 speak_japanese_wrap">
						<div><i class="material-icons left">chat</i><?= $get_inquiry_form_title['speak_japanese']->name ?><span class="red-text">※</span></div>
						<div class="col s12 speak_japanese">
	<?php
	set_form_contact_radio( $get_inquiry_form_title, 'speak_japanese', $get_inquiry_form_value, true, $get_my_user_meta['speak_japanese'] );
	?>
						</div>
					</div>
				</div>
				
				<div class="col s12 form_section_visa_type">
					<!--VISAの種類-->
					<div class="col s12 visa_type_wrap">
						<div><i class="material-icons left">security<!--verified_user--></i><?= $get_inquiry_form_title['visa_type']->name ?></div>
						<div class="col s12 form_section_wrap">
	<?php
	set_form_contact_radio( $get_inquiry_form_title, 'visa_type', $get_inquiry_form_value, false, $get_my_user_meta['visa_type'] );
	?>
						</div>
					</div>
				</div>
				
				<div class="col s12">
					<!--現在のお住まい-->
					<div class="col s7 current_residence_top_wrap">
						<div><i class="material-icons left">person_pin_circle</i><?= $get_inquiry_form_title['current_residence']->name ?></div>
						<div class="col s12 current_residence_wrap">
<?php
set_form_contact_radio( $get_inquiry_form_title, 'current_residence', $get_inquiry_form_value );
?>
						</div>
					</div>
		
					<!--ご職業-->
					<div class="col s5 input-field profession_wrap">
						<?= set_form_inquiry_input( $get_inquiry_form_title, 'text', 'profession', 'business', true, $get_my_user_meta['profession'] ) ?>
					</div>
				</div>
				
				<div class="col s12 get_inquiry_form_title_guide" align="center">
					<p><?= articnet_echo_string('get_inquiry_form_title_guide'); ?></p>
				</div>
				
				<div class="col s12 form_section_search_area">
					<!--お探しのエリア-->
					<div class="col s5 input-field search_area_wrap">
						<?= set_form_inquiry_input( $get_inquiry_form_title, 'text', 'search_area', 'location_on', true ); ?>
					</div>
					
					<!--ご希望の間取り-->
					<div class="col s7 floor_plan_wrap">
						<div class="floor_plan_title_wrap">
							<div><i class="material-icons center bottom">apps</i><?= $get_inquiry_form_title['floor_plan']->name ?><span class="red-text">※</span></div>
							<div class="how_to_choose_the_floor_plan"><a href="/how_to/apartment_sizes_and_layouts/" target="_blank"><?= articnet_echo_string('how_to_choose_the_floor_plan'); ?></a></div>
						</div>
						<div class="floor_plan_checkbox_wrap">
	<?php
	foreach( $get_inquiry_form_value['child'][ $get_inquiry_form_title['floor_plan']->term_id ] as $key => $value ){
		echo '<div class="floor_plan_checkbox"><label><input type="checkbox" name="floor_plan[]" value="'.$value->slug.'" class="floor_plan required"><span>'.$value->name.'</span></label></div>';
	}
	?>
						</div>
					</div>
				</div>
				
				<div class="col s12 form_section_wrap form_section_desired_size_wrap">
					<!--ご希望の広さ-->
					<div class="col s6 desired_size_wrap form_section_wrap">
						<div class="col s8 input-field">
							<i class="material-icons prefix">zoom_out_map</i><input type="number" min="10" max="200" step="10" name="desired_size" value="" id="desired_size" class=""><label for="desired_size" class=""><?= $get_inquiry_form_title['desired_size']->name ?></label>
						</div>
						<div class="col s4 m_or_more_wrap form_section_wrap"><span><?= $get_inquiry_form_title['m_or_more']->name ?></span></div>
					</div>
					
					<!--お探しの賃料-->
					<div class="col s6 rent_price_main_wrap">
						<div class="col s8 input-field rent_price_wrap">
							<i class="fas fa-yen-sign prefix" aria-hidden="true"></i><input type="number" min="40000" max="500000" step="10000" name="rent" value="" id="rent" class="rent required required_input" required><label for="rent"><?= $get_inquiry_form_title['rent']->name ?><span class="red-text">※</span></label>
						</div>
						<div class="col s4 yen_or_less_wrap form_section_wrap"><span><?= $get_inquiry_form_title['yen_or_less']->name ?></span></div>
					</div>
				</div>
				
				
				<div class="col s12 form_section_wrap form_section_number_of_residents">
					<!--入居人数-->
					<div class="col s6 number_of_residents">
						<div class="col s12">
							<i class="material-icons bottom">group_add</i><label for="number_of_residents" class=""><?= $get_inquiry_form_title['number_of_residents']->name ?></label>
						</div>
						<div class="col s12 number_of_residents_radio">
<?php
set_form_contact_radio( $get_inquiry_form_title, 'number_of_residents', $get_inquiry_form_value, false );
?>
						</div>
					</div>
					
					<!--ペットの飼育-->
					<div class="col s6 have_pets">
						<div class="col s12">
							<i class="fas fa-paw" aria-hidden="true"></i><label for="have_pets" class=""><?= $get_inquiry_form_title['have_pets']->name ?></label>
						</div>
						<div class="col s4 form_section_wrap">
<?php
set_form_contact_radio( $get_inquiry_form_title, 'have_pets', $get_inquiry_form_value, false, $get_my_user_meta['have_pets'] );
?>
						</div>
						<div class="col s8 form_section_wrap input-field">
							<input type="text" name="type" value="<?= $get_my_user_meta['type'] ?>" ><label for="type" class=""><?= $get_inquiry_form_title['type']->name ?></label>
						</div>
					</div>
					
				</div>
				
				<div class="col s12 form_section_wrap form_section_moving_date">
					<!--お引越し時期-->
					<div class="col s6 input-field moving_date_wrap">
						<i class="material-icons prefix">event_available</i><input type="text" name="moving_date" value="" id="moving_date"><label for="moving_date"><?= $get_inquiry_form_title['moving_date']->name ?></label>
					</div>
					
					<!--日本での滞在予定期間-->
					<div class="col s6 input-field stay_in_japan">
						<i class="material-icons prefix">event_available</i><input type="text" name="stay_in_japan" value="" id="stay_in_japan"><label for="stay_in_japan"><?= $get_inquiry_form_title['stay_in_japan']->name ?></label>
					</div>
				</div>
				
				<!--ご来店希望日-->
				<div class="col s12 desired_date_of_visit_title"><img src="<?= get_theme_file_uri('/layout/img/icon_datetime.png'); ?>"><?= $get_inquiry_form_title['desired_date_of_visit']->name ?></div>
				<!--第一希望-->
				<div class="col s6 first_choice_wrap">
					<div><?= $get_inquiry_form_title['first_choice']->name ?></div>
					<div class="col s6 input-field desired_date_wrap"><i class="material-icons prefix">date_range</i><input type="text" name="desired_date" value="" class="datepicker" id="desired_date"><label for="desired_date"><?= $get_inquiry_form_title['day']->name ?></label></div>
					<div class="col s6 input-field desired_time_wrap"><i class="material-icons prefix">access_time</i><input type="text" name="desired_time" value="" class="timepicker" id="desired_time"><label for="desired_time"><?= $get_inquiry_form_title['time']->name ?></label></div>
				</div>
				<!--第二希望-->
				<div class="col s6 second_choice_wrap">
					<div><?= $get_inquiry_form_title['second_choice']->name ?></div>
					<div class="col s6 input-field desired_date2_wrap"><i class="material-icons prefix">date_range</i><input type="text" name="desired_date2" value="" class="datepicker" id="desired_date2"><label for="desired_date2"><?= $get_inquiry_form_title['day']->name ?></label></div>
					<div class="col s6 input-field desired_time2_wrap"><i class="material-icons prefix">access_time</i><input type="text" name="desired_time2" value="" class="timepicker" id="desired_time2"><label for="desired_time2"><?= $get_inquiry_form_title['time']->name ?></label></div>
				</div>
				
				<div class="col s12 message_wrap">
					<div><?= $get_inquiry_form_title['message']->name ?></div>
					<div class="col s12 input-field">
						<i class="material-icons prefix">mode_edit</i>
						<textarea name="message" id="message" class="materialize-textarea"></textarea>
						<label for="message"><?= $get_inquiry_form_title['fill_in_freely']->name ?></label>
					</div>
				</div>
				
				<?php if (! is_user_logged_in() ): ?>
				<div class="col s12 contact_regist_member" align="center">
					<label>
						<input type="checkbox" class="set_member_regist_password" disabled>
						<span><?= articnet_echo_string('contact_regist_member'); ?></span>
					</label>
				</div>
				
				<div class="col s12 member_regist_password_wrap" align="center">
					<div class="col s12 member_regist_password_form" align="center">
						<div class="col s12 please_set_password" align="center">
							<?= articnet_echo_string('please_set_password'); ?>
						</div>
						<div class="col s12 error" align="center"></div>
						<div class="input-field col s4 offset-s4">
							<i class="material-icons prefix">vpn_key</i>
							<input id="user_pass" type="tel" name="user_pass" oncopy="return false" class="password">
							<label for="user_pass"><?= articnet_echo_string('password'); ?></label>
						</div>
							
						<div class="input-field col s4 offset-s4">
							<i class="material-icons prefix">vpn_lock</i>
							<input id="user_pass_check" type="password" onpaste="return false" class="password_check">
							<label for="user_pass_check"><?= articnet_echo_string('confirm_password'); ?></label>
						</div>
					</div>
				</div>
				<div class="col s12 contact_regist_member_guide blue-text text-accent-4" align="center">
					<p><?= articnet_echo_string('contact_regist_member_guide'); ?></p>
				</div>
				<?php endif; ?>
					
				<?= set_view_privacy_policy(); ?>
				
				<div class="col s12 inquiry_form_submit_wrap" align="center"><button type="submit" class="btn waves-effect waves-light inquiry_form_submit" disabled><?= articnet_echo_string('send'); ?><i class="material-icons right">send</i></button></div>
			</form>
		</div>
					
	</div>
</div>
</main>


<script>
jQuery(function($){
	
	<?php get_date_picker_value(); ?>
	
	var member_regist_password_form = $('.member_regist_password_form').detach();
	$('.set_member_regist_password').click(function(){
		if( !$('.member_regist_password_wrap').find('.member_regist_password_form').length ){
			$('.member_regist_password_wrap').append( member_regist_password_form );
			$('.member_regist_password_wrap').slideToggle();
			check_password($);
		}else{
			if( $('.member_regist_password_wrap').find('.member_regist_password_form').length ){
				$('.member_regist_password_wrap').slideToggle();
				$('.member_regist_password_form').detach();
			}
		}
	});
	
	<?php if( qtranxf_getLanguage()!='en' ): ?>
	set_replace_datetime($, 'input[name="desired_date"]', '.desired_date_wrap');
	set_replace_datetime($, 'input[name="desired_date2"]', '.desired_date2_wrap');
	<?php endif; ?>
		
	$('.inquiry_form').submit(function(event){
		
		event.preventDefault();
		var ajaxpost = new FormData( this );
		ajaxpost.append('action', 'set_action_inquiry_form' );
		
	    $.ajax({
	        type: 'POST',
	        url: ajaxurl,
	        data: ajaxpost,
			contentType: false,
	        processData: false,
	        success: function( response ){
	        	if( response.indexOf('done')!=-1 ){
	        		alert('<?= get_field_articnet('thanks_mail_done'); ?>');
	        		window.location.href = '<?= wp_get_referer(); ?>';
	        	}else if( response.indexOf('inquiry_regist_done')!=-1 ){
	        		alert('<?= get_field_articnet('thanks_mail_done'); ?>');
	        		alert('<?= get_field_articnet('member_register_done'); ?>');
	        		window.location.href = '<?= wp_get_referer(); ?>';
	        	}
	        },
	        error: function( response ){
                console.log( response );
                $('.error').html(response);
            }
	    });
	    return false;
	});
	
});


function set_replace_datetime($, click_element, parent_element){
	
	var day = '';
	<?php if( qtranxf_getLanguage()=='ja' ): ?>
		day = '日';
	<?php elseif( qtranxf_getLanguage()=='zh' ): ?>
		day = '号';
	<?php elseif( qtranxf_getLanguage()=='kr' ): ?>
		day = '일';
	<?php endif; ?>
	
	$( click_element ).click(function(){
		if( !$(this).parent(parent_element).find('.datepicker-date-display').find('.replace').length ){
			var date_text = $('.date-text').detach().text();
			var date_text_split = date_text.split(',');
			var date_split = date_text_split[1].split(' ');
			var set_date = '<div class="date-text replace"><div>' + date_split[1] + date_split[2] + day + '</div>' + date_text_split[0] + '</div>';
			console.log( set_date );
			$('.year-text').after( set_date );
		}
	});
}


function check_password($){
	$('.password_check').change(function(){
		var user_pass = $('.password').val();
		var user_pass_check = $('.password_check').val();
		if( user_pass_check!='' && user_pass!=user_pass_check ){
			$('.error').text('<?= get_field_articnet('incorrect_password'); ?>');
			$('.privacy_policy_btn').attr('disabled', true);
			$('.inquiry_form_submit').prop('disabled', true);
		}else{
			$('.error').text('');
			$('.privacy_policy_btn').attr('disabled', false);
		}
	});
}

</script>


<?php get_template_part('parts/footer', 'form_validate'); ?>


<?php get_footer(); ?>