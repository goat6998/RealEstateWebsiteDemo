<?php
if ( have_posts() ):
$movie = get_field('multimedia_tab_on_property')
?>

<div class="col s8 tabs_wrap">
	<ul class="tabs">
        <li class="tab col s4"><a href="#photo">
    		<?php if( qtranxf_getLanguage()!='en' ): ?>
			<i class="material-icons middle">photo_library</i> 
    		<?php endif; ?>
			<?php articnet_echo_string('photo') ?></a></li>
		
		<?php if( !empty( get_field('map') ) ): ?>
        <li class="tab col s4"><a href="#map"><i class="material-icons middle"><!--map/place-->place</i> <?php articnet_echo_string('map') ?></a></li>
        <?php endif; ?>
        
    	<?php if( !empty( $movie ) ): ?>
    	<li class="tab col s4"><a href="#movie"><i class="material-icons middle"><!--map/place-->movie</i> <?php articnet_echo_string('movie') ?></a></li>
    	<?php endif; ?>
	</ul>
</div>

<div class="col s4 add_favorites_wrap" align="right">
	<div align="right">
	<?php if( !is_user_logged_in() ): ?>
	<a class="btn tooltipped add_member waves-effect waves-light" data-position="left" data-tooltip="<?php echo articnet_echo_string('member_regist_info') ?>"><?php echo articnet_echo_string('add_favorites') ?></a>
	<?php else: ?>
	<form id="form_add_favorites">
	<input type="hidden" name="property_id" value="<?= get_the_ID() ?>">
	<?php if( !checkFavorite() ): ?>
	<input type="hidden" name="mode" value="insert">
	<button type="submit" class="btn add_favorites waves-effect waves-light" onclick="M.toast({html: '<?php echo articnet_echo_string('added_to_favorites') ?>'})"><?php echo articnet_echo_string('add_favorites') ?></button>
	
	<?php else: ?>
		<!--
	<input type="hidden" name="mode" value="delete">
	<button type="submit" class="btn bgnone black-text delete_favorites"><?php echo articnet_echo_string('remove_property') ?></button>
	-->
	<?php endif; ?>
	
	</form>
	<?php endif; ?>
	</div>
	
	<div align="right">
		<?php if( !checkFavorite() ): ?>
		<i class="material-icons favorite_icon middle">favorite_border</i>
		<?php else: ?>
		<i class="material-icons favorite_icon middle favorite">favorite</i>
		<?php endif; ?>
	</div>
	
</div>

<div class="single_property_content_top_pc">
	<div id="photo" class="col s12">
		<?php if( get_field( 'catchphrase',  get_the_ID() ) ): ?>
		<div class="catchphrase_pc">
			<div class="catchphrase_wrap">
				<h2><?= get_field( 'catchphrase',  get_the_ID() ) ?></h2>
			</div>
		</div>
		<?php endif; ?>
		<div class="swiper_gallery_wrap_pc">
			<div class="swiper_gallery_wrap">
				<?= set_view_swiper_gallery() ?>
			</div>
		</div>
	</div>

	<?php if( !empty( get_field('map') ) ): ?>
	<script src="https://maps.googleapis.com/maps/api/js?language=<?= get_googlemap_lang() ?>&key=<?php echo get_field('google_maps_api_key', 'option') ?>"></script>
	<script src="<?= get_theme_file_uri('/layout/js/googlemap.js') ?>"></script>
	<div id="map" class="col s12"><div class="googlemap_wrap_pc"><?= set_view_googlemap() ?></div></div>
	<?php endif; ?>

	<?php if( !empty( $movie ) ): ?>
	<div id="movie" class="col s12">
		<div class="movie_wrap_pc"><div class="video"><?= $movie ?></div></div>
	</div>
	<?php endif; ?>
</div>


<div class="col s12 swiper_gallery_wrap_sp"></div>

<?php if( !empty( $movie ) ): ?>
<div class="movie_wrap_sp" align="right"><a data-remodal-target="modal-movie" class="btn btn_movie"><i class="fab fa-youtube bottom" aria-hidden="true" style="font-size: 1.5rem;"></i> Movie</a></div>
<div data-remodal-id="modal-movie" data-remodal-options="hashTracking: false" class="remodal video_wrap_sp">
	<div class="video"><?= $movie ?></div>
	<div align="center">
		<a data-remodal-action="confirm" class="remodal-confirm btn teal white-text"><?= articnet_echo_string('close') ?></a>
	</div>
</div>
<?php endif; ?>

<?php if( get_field( 'catchphrase',  get_the_ID() ) ): ?>
<div class="col s12 catchphrase_sp"></div>
<?php endif; ?>

<div class="col s12">
<?= set_view_property_category() ?>
</div>

<div class="col s12 single_property_main_contents_bottom_pc">
	<div class="col s7 post_content_pc"><div class="post_content"><h4><?= the_content() ?></h4></div></div>
	<div class="col s5 facility_wrap_pc">
		<div class="facility_wrap"><?= set_view_facilities() ?></div>
		<?php if( get_field('initial_cost_view')==1 ): ?>
		<div class="initial_cost_wrap">
			<?= set_view_initial_cost() ?>
		</div>
		<?php endif; ?>
	</div>
</div>

<div class="col s12 single_property_main_contents_bottom_sp">
<?= set_view_single_property_main_contents_bottom_sp() ?>
</div>

<div class="col s12 facility_wrap_sp"></div>

<div class="col s12 post_content_sp"></div>

<div class="col s12">
	<div class="inquiry_form_btn_wrap">
		<div class="col s6" align="center"><a href="<?=home_url();?>/inquiry_form/?property=<?=$post->post_name?>" class="btn indigo white-text"><i class="material-icons left">mail</i><?php echo articnet_echo_string('make_an_inquiry'); ?></a></div>
		<div class="col s6" align="center"><a href="<?= set_messanger_url(); ?>" target="_blank" class="btn indigo white-text"><i class="fab fa-facebook-messenger left"></i><?php echo articnet_echo_string('contact_messenger'); ?></a></div>
	</div>
</div>

<div class="col s12 property_print_sp"></div>
<?php endif; ?>