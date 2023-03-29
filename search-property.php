<?php
/*
Template Name:物件一覧
*/
?>
<?php get_header(); ?>
<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$args = array(
	'post_status' => 'publish',
	'post_type' => 'property',
	'posts_per_page' => get_option('posts_per_page'),
	'tax_query' => array(
		'relation' => 'AND',
	),
	'meta_query' => array(
		'relation' => 'AND',
	),
	'paged' => $paged,
);

#物件タイプ
if( !empty( get_query_var('property_type') ) ){
	$args['tax_query'][] = array(
			'taxonomy' => 'property_type',
			'field' => 'slug',
			'terms' => get_query_var('property_type')
		);
}
#沿線
if( !empty( get_query_var('station') ) ){
	$args['tax_query'][] = array(
			'taxonomy' => 'station',
			'field' => 'slug',
			'terms' => get_query_var('station')
		);
}
#エリア
if( !empty( get_query_var('area') ) ){
	$args['tax_query'][] = array(
			'taxonomy' => 'area',
			'field' => 'slug',
			'terms' => get_query_var('area')
		);
}
#家賃、価格、安値
if( !empty( get_query_var('price_low') ) ){
	$args['meta_query'][] = array(
			'key' => 'price',
			'value' => get_query_var('price_low'),
			'compare' => '>=',
			'type' => 'numeric'
		);
}
#家賃、価格、高値
if( !empty( get_query_var('price_high') ) ){
	$args['meta_query'][] = array(
			'key' => 'price',
			'value' => get_query_var('price_high'),
			'compare' => '<=',
			'type' => 'numeric'
		);
}
#面積下限
if( !empty( get_query_var('property_size_low') ) ){
	$args['meta_query'][]= array(
		'key' => 'property_size',
		'compare' => '>=',
		'value' => get_query_var('property_size_low'),
		'type' => 'numeric',
	);
}
#面積上限
if( !empty( get_query_var('property_size_high') ) ){
	$args['meta_query'][]= array(
		'key' => 'property_size',
		'compare' => '<=',
		'value' => get_query_var('property_size_high'),
		'type' => 'NUMERIC',
	);
}
#間取り
if( !empty( get_query_var('property_layout') ) ){
	$args['meta_query'][] = array(
		'key' => 'property_layout',
		'value' => get_query_var('property_layout'),
		'compare' => 'IN',
	);
}
#物件カテゴリー
if( !empty( get_query_var('property_category') ) ){
	$args['tax_query'][] = array(
			'taxonomy' => 'property_category',
			'field' => 'slug',
			'terms' => get_query_var('property_category'),
			'operator' => 'AND'
		);
}
#設備
if( !empty( get_query_var('facility') ) ){
	foreach( get_query_var('facility') as $key => $value ){
		$args['meta_query'][] = array(
				'key' => $value,
				'value' => 1,
				'compare' => '==',
				'type' => 'NUMERIC'
			);
	}
}

#契約済みを最後に
$args['meta_query']['relation'] = 'AND';
$args['meta_query']['sold']['key'] = 'sold';
$args['meta_query']['sold']['type'] = 'NUMERIC';
$args['orderby']['sold'] = 'ASC';

#並び替え
if( empty( get_query_var('orderby') ) || get_query_var('orderby')=='date' ){
	$args['orderby']['date'] = 'DESC';
}else{
	$args['meta_key'] = get_query_var('orderby');
	$args['orderby']['meta_value_num'] = get_query_var('order');
#		$args['order'] = get_query_var('order');
}

add_filter('posts_where', 'set_query_search_where', 10, 2);
$query = new WP_Query( $args );
remove_filter('posts_where','set_query_search_where', 10, 2);

//最大ページ数
$max_num_pages = $query->max_num_pages;

?>

<main role="main">
<div class="container property_list_body">
	<div class="row">
		
		<aside role="form">
		<div class="col s4 search_form">
		<?php get_template_part('parts/sidebar', 'search_form'); ?>
		</div>
		</aside>
		
		<article>
		<div class="col s8 property_list_main_wrap">
			
			<div class="col s12 search_results">
				<div><?=articnet_echo_string('search_results')?> <?= $query->found_posts ?> <?= articnet_echo_string('search_records'); ?></div>
				<?php if( $max_num_pages ): ?>
				<div align="right"><?=$paged?> / <?=$max_num_pages?></div>
				<?php endif; ?>
			</div>
			
			
			<?php $get_sort_query = get_sort_query(); ?>
			<?php if( $max_num_pages ): ?>
			<!--PC-->
			<div class="col s12 btn_sort_pc">
			<?php foreach( $get_sort_query as $key => $value ): ?>
				<div class="col s3 <?= qtranxf_getLanguage(); ?>" align="center"><a href="<?= add_query_arg( array('orderby' => $value['orderby'], 'order' => $value['order']) ); ?>" class="<?php echo ( get_query_var('orderby')==$value['orderby'] && get_query_var('order')==$value['order'] || empty(get_query_var('orderby')) && $key==0 ) ?  'btn disabled teal-text' : 'waves-effect waves-light btn bgwhite blue-text' ; ?>"><?=$value["icon"]?><?= articnet_echo_string( $value["title"] ) ?></a></div>
			<?php endforeach; ?>
			</div>
			<?php endif; ?>
				
			<!--SP-->
			<div class="col s12 btn_sort_sp_wrap">
				
				<div class="col s6 btn_sort_sp" align="center">
					<?php if( $max_num_pages ): ?>
					<a class="dropdown-trigger waves-effect waves-light btn bgnone blue-text" data-target="select_sort"><?= get_sort_select()['icon'] ?><?= articnet_echo_string( get_sort_select()['title'] ); ?><i class="material-icons right">arrow_drop_down</i></a>
					<ul id="select_sort" class="dropdown-content">
					<?php foreach( $get_sort_query as $key => $value ): ?>
					<?php if( get_query_var('orderby')==$value['orderby'] && get_query_var('order')==$value['order'] ): ?>
						<li class="active"><a><?=$value["icon"]?> <?= articnet_echo_string( $value["title"] ) ?></a></li>
					<?php else: ?>
						<li><a href="<?= add_query_arg( array('orderby' => $value['orderby'], 'order' => $value['order']) ); ?>"><?=$value["icon"]?> <?= articnet_echo_string( $value["title"] ) ?></a></li>
					<?php endif; ?>
					<?php endforeach; ?>
					</ul>
					<?php endif; ?>
				</div>
				
				<div class="col s6 btn_search_wrap" align="center">
					<?= set_form_search_sp(); ?>
				</div>
				
			</div>
			
			<div class="col s12 property_list_out_wrap">
<?php

if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
	echo '<div class="col s12 m4 property_list_wrap">';
	set_view_property_single( get_the_ID() );
	echo '</div>';
endwhile;

echo '<div class="col s12 wp_pagenavi_wrap">';
echo '<div align="center">'.$paged.' / '.$max_num_pages.'</div>';
echo '<div align="center">';
if( function_exists('wp_pagenavi') ) {
	wp_pagenavi( array('query' => $query) );
}
echo '</div>';
echo '</div>';

$query->reset_postdata();

endif;
if ( !$query->have_posts() ):
?>
				<div class="col s12" align="center"><p><?= articnet_echo_string('no_property') ?></p></div>
<?php
endif;
?>
			</div>
		</div>
		</article>
	
	</div>
</div>
</main>


<?= set_pagenavi(); ?>
<?php get_template_part('parts/footer', 'search_form'); ?>


<?php get_footer(); ?>

