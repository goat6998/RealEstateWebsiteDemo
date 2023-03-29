<?php
/*
Template Name:シングルページ
*/
?>
<?php get_header(); ?>

<?php if( get_post_type()!='area_info' ): ?>
<?php get_template_part('parts/breadcrumbs'); ?>
<?php endif; ?>

<div class="container container_custom">
	<div class="row">
		
		<?php if( get_post_type()!='area_info' ): ?>
		<aside class="sidebar_pc">
			<div class="col s12 m4"><?= get_template_part('parts/sidebar', 'single_page'); ?></div>
		</aside>
		<?php endif; ?>
		
		<main role="main">
			<article>
				<?php if( get_post_type()=='area_info' ): ?>
				<div class="col s12">
					<div class="col s12 page_contents"><?= the_content(); ?></div>
				</div>
				<?php else: ?>
				<div class="col s12 m8 page_contents_wrap">
					<h1 class="page_title"><?= get_icon_page() ?><?= the_title(); ?></h1>
					<div class="col s12 page_contents"><?= the_content(); ?></div>
				</div>
				<?php endif; ?>
			</article>
		</main>
		
		<aside class="single_bottom_sp">
			<div class="col s12"></div>
		</aside>
		
	</div>
</div>

<?php get_footer(); ?>