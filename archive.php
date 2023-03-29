<?php
/*
Template Name:アーカイブ
*/
?>
<?php get_header(); ?>
<?php
global $paged;
global $max_num_pages;
?>
<?php get_template_part('parts/breadcrumbs', 'page'); ?>

<div class="container container_custom">
	<div class="row">
		
		<aside class="sidebar_pc">
			<div class="col s12 m4"><?= get_template_part('parts/sidebar', 'single_page'); ?></div>
		</aside>
		
		<main role="main">
			<article>
				<div class="col s12 m8 page_contents_wrap">
					<h1 class="page_title"><?= get_icon_page() ?><?= get_field_articnet( get_post_type() ); ?></h1>
					<div class="col s12 page_contents">
			
<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = array(
	'post_status' => 'publish',
	'post_type' => get_post_type(),
	'posts_per_page' => get_option('posts_per_page'),
	'orderby' => 'date',
	'order' => 'DESC',
	'paged' => $paged
);

$query = new WP_Query( $args );
//最大ページ数
$max_num_pages = $query->max_num_pages;
?>
<ul class="collection archive">
<?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
	<li class="collection-item valign-wrapper" style="padding:0;">
		<article>
		<a href="<?php echo get_permalink( get_the_ID() ); ?>" class="collection-item waves-effect waves-light" style="width:100%;">
			
			<?php if( get_archive_image( get_the_ID() ) ): ?>
			<div class="col s3 valign archive_thumbnail_wrap">
			<img src="<?= get_archive_image( get_the_ID() ) ?>">
			</div>
			<div class="col s9 valign archive_body">
			<?php else: ?>
			<div class="col s12 valign">
			<?php endif; ?>
				
				<span class="date"><?php the_time('Y.m.d') ?></span>
				<div class="archive_title"><h2><?php echo get_the_title( get_the_ID() ); ?></h2></div>
<?php
// ターム名を表示
$terms = get_the_terms( get_the_ID(), 'area_category' );
if( !empty( $terms ) ) {
	$output = array();
	foreach( $terms as $term ) {
		if( !empty( $term->parent ) && $term->parent != 0 ) $output[] = $term->name;
		if( count( $output ) ) {
			echo '<div class="term archive_content"><h3>' . join(", ", $output) . '</h3></div>';
		}else{
			echo '<div class="term archive_content"><h3>' . $term->name . '</h3></div>';
		}
	}
}
?>
			<?php if( $header_bg_image = get_field( "header_bg_image", get_the_ID() ) ): ?>
			<div class="col s12 valign archive_thumbnail_wrap_sp">
	        <img src="<?= $header_bg_image['url'] ?>" width="386">
			</div>
			<?php endif; ?>
			</div>
		</a>
		</article>
	</li>
<?php
endwhile;

echo '<div class="col s12 wp_pagenavi_wrap">';
echo '<div align="center">'.$paged.' / '.$max_num_pages.'</div>';
echo '<div align="center">';
if( function_exists('wp_pagenavi') ) {
	wp_pagenavi( array('query' => $query) );
}
echo '</div>';
echo '</div>';

wp_reset_query();
endif;
?>
</ul>
			
					</div>
				</div>
			</article>
		</main>
		
		<aside>
			<div class="col s12 single_bottom_sp"></div>
		</aside>
		
	</div>
</div>


<?= set_pagenavi(); ?>
<?php get_footer(); ?>