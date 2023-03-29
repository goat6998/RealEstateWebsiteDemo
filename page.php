<?php
/*
Template Name:ページテンプレート
*/
?>
<?php get_header(); ?>

<?php get_template_part('parts/breadcrumbs'); ?>

<div class="container container_custom">
	<div class="row">
		
		<aside class="sidebar_pc">
			<div class="col s12 m4"><?= get_template_part('parts/sidebar', 'single_page'); ?></div>
		</aside>
		
		<main role="main">
			<article>
				<div class="col s12 m8 page_contents_wrap">
					<h1 class="page_title"><?= get_icon_page() ?><?= the_title(); ?></h1>
					<div class="col s12 page_contents"><?= the_content(); ?></div>
				</div>
			</article>
		</main>
		
		<aside class="single_bottom_sp">
			<div class="col s12"></div>
		</aside>
		
	</div>
</div>

<?php get_footer(); ?>