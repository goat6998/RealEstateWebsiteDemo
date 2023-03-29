
<!--PCサイドメニュー-->
<h5 class="sidebar_title"><i class="material-icons bottom">view_list</i><?php articnet_echo_string('pc_sidebar_menu_title'); ?></h5>
<div class="collection">
<?php
global $post;
$menu_name = 'pc_sidebar_menu';
if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
	$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
	$menu_items = wp_get_nav_menu_items($menu->term_id);
	foreach ( (array) $menu_items as $menu_item ) {
		echo '<a href="' . $menu_item->url . '" class="collection-item waves-effect waves-light';
		if( preg_match('/'.$post->post_name.'/', $menu_item->url ) || preg_match('/'.get_post_type().'/', $menu_item->url ) ) echo ' active';
		echo '"><i class="material-icons left">chevron_right</i>' . $menu_item->title . '</a>';
	}
}
?>
</div>


<div class="single_sidebar_bottom_wrap">
	<div class="single_sidebar_contents">
		
		<!--カテゴリー-->
		<h5 class="sidebar_title"><i class="material-icons bottom">store</i><?php articnet_echo_string('category'); ?></h5>
		<div class="collection">
		<?php
		$property_category = get_my_category('property_category');
		foreach( $property_category as $key => $value ){
			echo '<a href="'.home_url('/property_list').'?property_category='.$value->slug.'" class="collection-item waves-effect waves-light"><i class="fa fa-building" aria-hidden="true"></i>　'.$value->name.'</a>';
		}
		?>
		</div>


		<!--ランキング-->
		<h5 class="sidebar_title"><i class="fa fa-list-ol" aria-hidden="true"></i><?php articnet_echo_string('ranking'); ?></h5>
		<ul class="collection property_ranking">
		<?php
		$ranking_count = 0;
		while( have_rows('ranking', 'option') ): the_row(); $ranking_count++;
			$ranking_property = get_sub_field('ranking_property');
			$ranking_property_class = 'grey-text text-darken-4';
			if($ranking_count == 1){ // gold
				$ranking_property_class = 'amber-text';
			}else if($ranking_count == 2){ // silver
				$ranking_property_class = 'grey-text';
			}else if($ranking_count == 3){ // bronze
				$ranking_property_class = 'brown-text';
			}
			
			$thumbnail[$ranking_property->ID] = get_the_post_thumbnail_url( $ranking_property->ID, 'thumbnail' );
			$thumbnail[$ranking_property->ID] = set_resize_image( $thumbnail[$ranking_property->ID] );
		?>
			<li class="collection-item valign-wrapper">
				<img src="<?= $thumbnail[$ranking_property->ID] ?>" class="col s2">
				<i class="col s1 fa fa-trophy <?= $ranking_property_class; ?> valign" aria-hidden="true"></i>
				<span class="col s9 valign"><a href="<?= esc_url( get_permalink( $ranking_property->ID ) ); ?>" class="waves-effect waves-light"><?= $ranking_property->post_title; ?></a></span>
			</li>
		<?php endwhile; ?>
		</ul>
	
	</div>
</div>








