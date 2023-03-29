<?php
/*
Template Name:トップページ
*/
?>
<?php get_header(); ?>

<aside>
<div class="container container_home_header">
	<div class="row">
		<div class="col s12 site_image_wrap">
			<img src="<?= header_image(); ?>">
		</div>
	
		<div class="col s12 search_form_pc">
			<?php get_template_part('parts/home', 'search_form'); ?>
		</div>
	
	</div>
</div>
</aside>

<main role="main">
<div class="container container_home">
	
	<aside>
	<div class="row">
		<div class="col s12 btn_search_form">
			<?= set_form_search_sp(); ?>
		</div>
	</div>
	</aside>
	
	<article>
	<div class="row">
		<?php set_view_property_list_home(); ?>
		
		<!--お知らせ-->
		<article>
		<div class="col s12 notice">
			<div class="home_sub_title"><h2><?= articnet_echo_string('notice'); ?></h2></div>
			<div><a href="<?= home_url('/notice'); ?>">
			<?= articnet_echo_string('see_more'); ?>
			</a></div>
		</div>
		<div class="col s12 swiper_wrap">
			<div class="swiper_archive swiper-container">
				<div class="swiper-wrapper">
					<?php $get_notice = get_post_type_array( 'notice', 10 ); ?>
					<?php foreach( $get_notice as $key => $value ): ?>
					<div class="swiper-slide archive_list">
						<article>
						<a href="<?= get_permalink( $value->ID ) ?>">
							<div><?php echo get_the_date('Y年n月j日', $value->ID ); ?></div>
							<div class="archive_title"><h3><?= $value->post_title ?></h3></div>
							<?php if( has_post_thumbnail( $value->ID ) ): ?>
							<div class="home_archive_thumbnail_wrap">
							<?= get_the_post_thumbnail( $value->ID ); ?>
							</div>
							<?php endif; ?>
						</a>
						</article>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		</div>
		</article>
		
		<!--HOW TO-->
		<article>
		<div class="col s12 how_to">
			<div class="home_sub_title"><h2>HOW TO</h2></div>
			<div><a href="<?= home_url('/how_to'); ?>">
			<?= articnet_echo_string('see_more'); ?>
			</a></div>
		</div>
		<div class="col s12 swiper_wrap">
			<div class="swiper_archive swiper-container">
				<div class="swiper-wrapper">
					<?php $get_how_to = get_post_type_array( 'how_to', 10 ); ?>
					<?php foreach( $get_how_to as $key => $value ): ?>
					<div class="swiper-slide archive_list">
						<article>
						<a href="<?= get_permalink( $value->ID ) ?>">
							<div class="archive_title"><h3><?= $value->post_title ?></h3></div>
							<?php if( has_post_thumbnail( $value->ID ) ): ?>
							<div class="home_archive_thumbnail_wrap">
							<?= get_the_post_thumbnail( $value->ID ); ?>
							</div>
							<?php endif; ?>
						</a>
						</article>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		</div>
		</article>
		
		<!--エリア紹介-->
		<article>
		<div class="col s12 area_info">
			<div class="home_sub_title"><h2><?= articnet_echo_string('area_info'); ?></h2></div>
			<div><a href="<?= home_url('/area_info'); ?>">
			<?= articnet_echo_string('see_more'); ?>
			</a></div>
		</div>
		<div class="col s12 swiper_wrap">
			<?php $get_area_info = get_post_type_array( 'area_info', 10 ); ?>
			<div class="swiper_archive swiper-container">
				<div class="swiper-wrapper">
					
					<?php foreach( $get_area_info as $key => $value ): ?>
					<div class="swiper-slide archive_list">
						<article>
						<a href="<?= get_permalink( $value->ID ); ?>">
							<div class="archive_content"><h4><?= get_the_terms( $value->ID, 'area_category' )[0]->name; ?></h4></div>
						
							<?php if( $header_bg_image = get_field( "header_bg_image", $value->ID ) ): ?>
							<div class="home_archive_thumbnail_wrap">
					        <img src="<?= $header_bg_image['url'] ?>">
							</div>
							<?php endif; ?>
							<div class="archive_title"><h3><?= $value->post_title ?></h3></div>
						</a>
						</article>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		</div>
		</article>
		
	</div>
	</article>
	
</div>
</main>


<!--メディアリンク-->
<aside role="complementary">
<div class="container container_home">
	<div class="row">
		<div class="col s12">
			<div  class="home_sub_title media_link_title"><h2><?= articnet_echo_string('media'); ?></h2></div>
			<div class="swiper_media swiper-container">
				<?php if ( is_active_sidebar('widget_main_media_link') ) : ?>
				<ul id="widget_main_media_link" class="swiper-wrapper">
					<?php dynamic_sidebar('widget_main_media_link'); ?>
				</ul>
				<?php endif; ?>
				<div class="swiper-pagination"></div>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		</div>
	</div>
</div>
</aside>


<!--サイトインフォバナー-->
<aside role="complementary">
<div class="container container_home">
	<div id="site_info_menu" class="row">
		<?php if ( is_active_sidebar('widget_site_info') ) : ?>
		<ul id="widget_site_info">
			<?php dynamic_sidebar('widget_site_info'); ?>
		</ul>
		<?php endif; ?>
	</div>
</div>
</aside>


<?php get_template_part('parts/footer', 'search_form'); ?>


<?php get_footer(); ?>

