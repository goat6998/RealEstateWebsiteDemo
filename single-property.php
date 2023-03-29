<?php
/*
Template Name:物件詳細
*/
?>
<?php get_header(); ?>

<?php global $post; ?>

<main role="main">
<div class="container single_property_body">
	
	<article>
	<div class="row">
		
		<div class="col s4 single_property_sidebar">
			<div class="null_box">
				<?php if( get_field( 'catchphrase',  get_the_ID() ) ): ?>
				<div class="catchphrase_height"></div>
				<?php endif; ?>
			</div>
			<?php get_template_part('parts/sidebar', 'single_property'); ?>
		</div>
		
		<div class="col s8 single_property_main_contents">
			<?php get_template_part('parts/single', 'property_main'); ?>
		</div>
		
	</div>
	</article>

</div>
</main>


<div class="property_inquiry_wrap">
	<div class="property_inquiry_inner <?= qtranxf_getLanguage() ?>">
		<div><a href="<?=home_url();?>/inquiry_form/?property=<?=$post->post_name?>" class="btn indigo white-text"><i class="material-icons small bottom left">mail</i> <?= articnet_echo_string('to_inquiry'); ?></a></div>
		<div><a class="inquiry_btn btn indigo white-text" href="tel:<?= get_site_info()['tel'] ?>"><i class="material-icons small bottom left">phone</i> <?= articnet_echo_string('phone_sp'); ?></a></div>
		<div><a href="<?= set_messanger_url(); ?>" target="_blank" class="btn indigo white-text"><i class="fab fa-facebook-messenger bottom left" aria-hidden="true"></i> <?= articnet_echo_string('messenger'); ?></a></div>
	</div>
</div>


<script>
jQuery(function($){
	
	check_add_member($);
	set_add_favorites($);
	
});


function check_add_member($){
	$('.add_member').click(function(){
	    if(!confirm('<?php echo get_field_articnet('member_regist_conf'); ?>')){
	        /* キャンセルの時の処理 */
	        return false;
	    }else{
	        /*　OKの時の処理 */
	        location.href = '<?= home_url('/register'); ?>';
	    }
	});
}


function set_add_favorites($){
	$('#form_add_favorites').submit(function(event){
		event.preventDefault();
		var ajaxpost = new FormData( this );
		ajaxpost.append('action', 'set_action_add_favorites' );
		
	    $.ajax({
	        type: 'POST',
	        url: ajaxurl,
	        data: ajaxpost,
			contentType: false,
	        processData: false,
	        success: function( response ){
	            console.log( response );
	            if( response=='add_favorites' ){
	            	$('.favorite_icon').addClass('favorite').text('favorite');
	            	$('#form_add_favorites').hide();
	            }else if( response=='delete_favorites' ){
	            	$('.favorite_icon').text('favorite_border');
	            }
	        },
	        error: function( response ){
                console.log( response );
            }
	    });
	    return false;
	});
}


</script>
<?php get_footer(); ?>
