<?php

#検索ページ＞search-property.php追加
function set_search_template( $template ){
	$post_types = get_query_var('post_type');
	if( is_archive() && $post_types=='property' && empty( get_query_var('property') ) ){
		$templates[] = "search-property.php";
		$templates[] = 'search.php';
		$template = get_query_template('search', $templates);
	}
	return $template;
}
add_filter('template_include','set_search_template');


#フリーワード検索機能適用＞search-property.php
function set_custom_search( $search, $wp_query  ) {
	$post_types = get_query_var('post_type');
	if( is_archive() && $post_types=='property' && empty( get_query_var('property') ) ){
		$wp_query->is_search = true;
	}
    return $search;
}
add_filter('posts_search','set_custom_search', 10, 2);


#パラメータ設定
function set_query_vars( $vars ){
    $vars[] = "property_type";
    $vars[] = "area";
	$vars[] = "station";
    $vars[] = "price_low";
    $vars[] = "price_high";
	$vars[] = "property_size_low";
	$vars[] = "property_size_high";
    $vars[] = "property_layout";
    $vars[] = "property_category";
    $vars[] = "property_name";
	$vars[] = "facility";
    $vars[] = "orderby";
    $vars[] = "order";
    return $vars;
}
add_filter( 'query_vars', 'set_query_vars' );


#物件タイプ、路線、地域、カテゴリー取得
function get_my_category( $taxonomy ){
	$args = array(
		'taxonomy' => $taxonomy,
		'orderby'=>'term_order',
		'pad_counts'=>true
	);
	$get_categories = get_categories( $args );
	return $get_categories;
}


function check_query_var( $checkkey, $querykey ){
	if( !empty( get_query_var( $querykey ) ) ) {
		
		if( is_array( get_query_var( $querykey ) )==true && in_array( $checkkey, get_query_var( $querykey ) ) ){
			return true;
		}else if( get_query_var( $querykey )==$checkkey ){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}


#ソートパラメータ設定
function get_sort_query(){
	$sort_query[0]["orderby"] = "date";
	$sort_query[0]["order"] = "DESC";
	$sort_query[0]["title"] = 'new_arrival_order';
	$sort_query[0]["icon"] = '<i class="material-icons left" style="margin-right: 3px;font-size:1.3rem;">fiber_new</i>';
	
	$sort_query[1]["orderby"] = "price";
	$sort_query[1]["order"] = "ASC";
	$sort_query[1]["title"] = "cheapest_first";
	$sort_query[1]["icon"] = '<i class="material-icons left" style="margin-right: 3px;font-size:1.3rem;">expand_less</i>';
	
	$sort_query[2]["orderby"] = "price";
	$sort_query[2]["order"] = "DESC";
	$sort_query[2]["title"] = "price_first";
	$sort_query[2]["icon"] = '<i class="material-icons left" style="margin-right: 3px;font-size:1.3rem;">expand_more</i>';
	
	$sort_query[3]["orderby"] = "property_size";
	$sort_query[3]["order"] = "DESC";
	$sort_query[3]["title"] = "wide_order";
	$sort_query[3]["icon"] = '<i class="material-icons left" style="margin-right: 3px;font-size:1.3rem;">filter_list</i>';
	
	return $sort_query;
}


function get_sort_select(){
	$get_sort_array = get_sort_query();
	if( !empty( get_query_var('orderby') ) && !empty( get_query_var('order') ) ){
		foreach( $get_sort_array as $key => $value ){
			if( get_query_var('orderby')==$value['orderby'] && get_query_var('order')==$value['order'] ){
				$sort_select['title'] = $value['title'];
				$sort_select['icon'] = $value['icon'];
			}
		}
	}else{
		$sort_select['title'] = $get_sort_array[0]['title'];
		$sort_select['icon'] = $get_sort_array[0]['icon'];
	}
	return $sort_select;
}


#検索フォーム＞物件タイプ
function set_form_property_type(){
	
	$set_title_key['long-term-rentals'] = 'for_rent';
	$set_title_key['short-term-rentals'] = 'for_rent';
	$set_title_key['buy-sell-personal-use'] = 'real_estate';
	$set_title_key['buy-sell-investment'] = 'real_estate';
	
	$icon['for_rent'] = '<i class="fas fa-house-user left" aria-hidden="true"></i> ';
	$icon['real_estate'] = '<i class="material-icons left">location_city</i>';
	
	$get_my_category = get_my_category('property_type');
	foreach( $get_my_category as $key => $value ){
		if( $value->parent==0 ){
			$set_parent[ $set_title_key[ $value->slug ] ][] = $value;
		}else{
			$set_child[ $value->parent ][] = $value;
		}
	}
?>
	 <ul class="accordion collection">

		<?php foreach( $set_parent as $key => $value ): ?>
		<li class="collection-item bgnone">
			<div class="accordion_header"><?= $icon[ $key ].articnet_echo_string( $key ) ?><i class="material-icons right">arrow_drop_down</i></div>
			<div class="accordion_body col s12">
				<?php foreach( $value as $ck => $cv ): ?>
				<div class="col s12 checkbox_parent_wrap">
					<label>
						<input type="checkbox" name="property_type[]" value="<?= $cv->slug ?>" class="property_parent"<?php
if( check_query_var( $cv->slug, 'property_type' )==true ){
	echo ' checked';
	$check_parent[ $cv->term_id ] = true;
}
?>>
						<span><?= $cv->name ?> (<?= $cv->count ?>)</span>
					</label>
				</div>
				
				<?php if( !empty( $set_child[ $cv->term_id ] ) ): ?>
				<div class="col s12 checkbox_property_type_child_wrap">
					<?php foreach( $set_child[ $cv->term_id ] as $k => $v ): ?>
					<div class="col s6 checkbox_property_type_child">
						<label>
							<input type="checkbox" name="property_type[]" value="<?= $v->slug ?>"<?php
if( check_query_var( $v->slug, 'property_type' )==true ) echo ' checked';
if( !empty( $check_parent[ $v->parent ] ) && $check_parent[ $v->parent ]==true ){
	echo ' disabled';
}
?> class="checkbox_children">
							<span><?= $v->name ?></span>
						</label>
					</div>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
<?
}


#カテゴリー、親子配列
function get_parent_child( $taxonomy ){
	$get_my_category = get_my_category($taxonomy);
	foreach( $get_my_category as $pk => $pv ){
		if( $pv->parent==0 ){
			$set_array['parent'][ $pv->term_id ] = $pv;
		}else{
			$set_array['child'][ $pv->parent ][] = $pv;
		}
	}
	return $set_array;
}


function set_form_title( $category ){
	
	if( $category=='station' ){
		echo get_field_articnet('train_line');
	}else{
		echo get_field_articnet('area');
	}
	echo get_field_articnet('all');
}



#沿線検索チェックボックス
function set_form_station(){
?>
	<div class="search_form_station_sp_wrap">
		<div class="search_form_station_sp">
			<ul id="slide_search_form_station" class="sidenav side_form_station">
				<li class="search_form_contents_station">
					<div class="slide_form_close_wrap"><a class="slide_close_station waves-effect waves-teal"><i class="material-icons">close</i></a></div>
				</li>
			</ul>
		</div>
		<a data-target="slide_search_form_station" class="sidenav-trigger search_title_station slide_open_station"></a>
	</div>
	
	<div class="search_form_station_tablet">
		<div class="search_form_station_wrap">
			<a class="btn-flat black-text waves-effect waves-light search_title_station" data-remodal-target="modal-station"></a>
			<div data-remodal-id="modal-station" data-remodal-options="hashTracking: false" class="remodal search_modal search_modal_station">
				<button data-remodal-action="close" class="remodal-close waves-effect waves-teal bgnone"></button>
				<div class="checkbox_main_wrap_station">
					
					<div class="search_checkbox_title"><i class="material-icons bottom">train</i><?= articnet_echo_string('select_along_the_line'); ?></div>
					
					<?php $get_my_category = get_parent_child('station'); ?>
					<?php foreach( $get_my_category['parent'] as $pk => $pv ): ?>
							<div class="checkbox_wrap_station">
						
								<div class="checkbox_parent checkbox_station">
								<label>
									<input type="checkbox" name="station[]" value="<?= $pv->slug ?>"<?php
						if( check_query_var( $pv->slug, 'station' )==true ){
							$check_parent[ $pv->term_id ] = true;
							echo ' checked';
						}
		?> class="parent_station"><span><?= $pv->name ?>(<?= $pv->count ?>)</span>
								</label>
							</div>
						
							<div class="checkbox_child_wrap_station">
							<?php if( !empty( $get_my_category['child'][ $pv->term_id ] ) ): ?>
								<?php foreach( $get_my_category['child'][ $pv->term_id ] as $ck => $cv ): ?>
								<div class="checkbox_child_station <?= qtranxf_getLanguage(); ?>">
									<label>
										<input type="checkbox" name="station[]" value="<?= $cv->slug ?>"<?php if( check_query_var( $cv->slug, 'station')==true ) echo ' checked'; if( !empty($check_parent[ $cv->parent ]) && $check_parent[ $cv->parent ]==true ) echo ' disabled'; ?> class="child_station"><span><?= $cv->name ?>(<?= $cv->count ?>)</span>
									</label>
								</div>
								<?php endforeach; ?>
							<?php endif; ?>
							</div>
						
						</div>
					<?php endforeach; ?>
					<div class="modal-footer">
						<div align="center">
							<a class="waves-effect waves-teal btn bgwhite blue-text reset_station"><?= articnet_echo_string('reset'); ?></a>
						</div>
						<div align="center">
							<a data-remodal-action="confirm" class="remodal-confirm waves-effect waves-light btn teal white-text"><?= articnet_echo_string('decision'); ?></a>
						</div>
					</div>
						
				</div>
			</div>
		</div>
	</div>
<?php
}


#地域検索チェックボックス
function set_form_area(){
?>
	<div class="search_form_area_sp_wrap">
		<div class="search_form_area_sp">
			<ul id="slide_search_form_area" class="sidenav side_form_area">
				<li class="search_form_contents_area">
					<div class="slide_form_close_wrap"><a class="slide_close_area waves-effect waves-teal"><i class="material-icons">close</i></a></div>
				</li>
			</ul>
		</div>
		<a data-target="slide_search_form_area" class="sidenav-trigger search_title_area slide_open_area"></a>
	</div>
	
	<div class="search_form_area_tablet">
		<div class="search_form_area_wrap">
			<a class="btn-flat black-text search_title_area" data-remodal-target="modal-area"></a>
			<div data-remodal-id="modal-area" data-remodal-options="hashTracking: false" class="remodal search_modal search_modal_area">
				<button data-remodal-action="close" class="remodal-close waves-effect waves-light bgnone"></button>
				<div class="checkbox_wrap_out_area">
					<div class="search_checkbox_title"><i class="material-icons bottom">place</i><?= articnet_echo_string('region_selection'); ?></div>
					<?php
					//親子エリア＞件数
					$check_parent = false;
					$get_my_category = get_parent_child('area');
					foreach( $get_my_category['parent'] as $pk => $pv ):
					?>
					<div class="checkbox_wrap_in_area">
						<div class="checkbox_parent parent_area_wrap">
							<label>
								<input type="checkbox" name="area[]" value="<?= $pv->slug ?>"<?php
								if( check_query_var($pv->slug, 'area')==true ){
									$disable_child[$pv->term_id] = true;
									echo ' checked';
								}
								?>
								 class="parent_area"><span><?= $pv->name ?>(<?= $pv->count ?>)</span>
							</label>
						</div>
			
						<?php if( !empty( $get_my_category['child'][ $pv->term_id ] ) ): ?>
						<div class="child_out_wrap_area">
							<?php foreach( $get_my_category['child'][ $pv->term_id ] as $ck => $cv ): ?>
							<div class="child_wrap_area">
								<div class="child_in_wrap_area">
									<label>
										<input type="checkbox" name="area[]" value="<?= $cv->slug ?>"
										<?php
										if( check_query_var($cv->slug, 'area')==true ){
											echo ' checked';
											$disable_sub_child[$cv->term_id] = true;
										}
										if( !empty($disable_child[$cv->parent]) && $disable_child[$cv->parent]==true ){
											echo ' disabled';
											$disable_sub_child[$cv->term_id] = true;
										}
										?>
										 class="child_area"><span><?= $cv->name ?>(<?= $cv->count ?>)</span>
									</label>
								</div>
							
								<?php if( !empty( $get_my_category['child'][ $cv->term_id ] ) ): ?>
								<div class="sub_child_wrap_area">
									<?php foreach( $get_my_category['child'][ $cv->term_id ] as $sck => $scv ): ?>
									<div class="<?= qtranxf_getLanguage(); ?>">
										<label>
											<input type="checkbox" name="area[]" value="<?= $scv->slug ?>"
											<?php if( check_query_var( $scv->slug, 'area')==true ) echo ' checked'; ?>
											<?php if( !empty( $disable_sub_child[ $scv->parent ] ) && $disable_sub_child[ $scv->parent ]==true ) echo ' disabled'; ?>
											 class="sub_child_area"><span><?= $scv->name ?>(<?= $scv->count ?>)</span>
										</label>
									</div>
									<?php endforeach; ?>
								</div>
								<?php endif; ?>
							</div>
							<?php endforeach; ?>
						</div>
						<?php endif; ?>
					</div>
					<?php endforeach; ?>
					<div class="modal-footer">
						<div align="center">
							<a class="waves-effect waves-teal btn bgwhite blue-text reset_area"><?= articnet_echo_string('reset'); ?></a>
						</div>
						<div align="center">
							<a data-remodal-action="confirm" class="remodal-confirm waves-effect waves-light btn teal white-text"><?= articnet_echo_string('decision'); ?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}


function get_search_query_home( $keyname ){
if( !empty( get_query_var( $keyname ) ) ):
	foreach( get_query_var( $keyname ) as $key => $value ):
?>
		<input type="hidden" name="<?= $keyname ?>[]" value="<?= $value ?>" class="get_home_<?= $keyname ?>">
<?php
	endforeach;
endif;
}


#パラメータ取得＞キー値配列入れ替え＞プルダウン表示用
function get_query_swap( $taxonomy ){
	
	if( !empty( get_query_var( $taxonomy ) ) ){
		
		$get_my_category = get_my_category( $taxonomy );
		if( !empty( $get_my_category ) ){
			foreach( $get_my_category as $key => $value ){
				$set_category[$value->slug] = $value->name.'('.$value->count.')';
			}
		}
		
		if( is_array( get_query_var( $taxonomy ) ) ){
			foreach( get_query_var( $taxonomy ) as $key => $value ){
				if( !empty( $set_category[$value] ) ) $set_query_value[$value] = $set_category[$value];
			}
		}else{
			$set_query_value[get_query_var( $taxonomy )] = $set_category[ get_query_var( $taxonomy ) ];
		}
		$set_query_value = implode(',', $set_query_value );
		return $set_query_value;
	}else{
		return NULL;
	}
}


#数値配列作成
function set_price_array( $start, $stop, $step ){
	$stop = $stop * $step + $start;
	for ($i=$start; $i<=$stop; $i+=$step){
		$num_array[] = $i;
	}
	return $num_array;
}


#検索パラメータ＞普通賃貸、マンスリー
function set_price_rental(){
	$set_price_array[] = set_price_array(40000, 25, 10000);
	$set_price_array[] = set_price_array(300000, 4, 50000);
	$set_price_array = array_merge( $set_price_array[0], $set_price_array[1] );
	return $set_price_array;
}


#検索パラメータ＞不動産
function set_price_real_estate(){
	$set_price_array[] = set_price_array(10000000, 14, 2000000);
	$set_price_array[] = set_price_array(40000000, 2, 5000000); 
	$set_price_array[] = set_price_array(60000000, 3, 10000000);
	$set_price_array[] = set_price_array(100000000, 2, 50000000);
	$set_price_array = array_merge( $set_price_array[0], $set_price_array[1], $set_price_array[2], $set_price_array[3] );
	return $set_price_array;
}


#検索フォーム＞セレクト
function set_form_select( $paramname, $articnet_echo_string, $search_array ){
	
	echo '<select name="'.$paramname.'">
		<option value=""';
	if( !empty( get_query_var( $paramname ) ) ) echo ' selected';
	echo '>';
	echo articnet_echo_string( $articnet_echo_string );
	echo articnet_echo_string('all');
	echo '</option>';
	
	foreach( $search_array as $key => $value ){
		echo '<option value="'.$value.'"';
		if( !empty( get_query_var( $paramname ) ) && $value == get_query_var( $paramname ) ) echo 'selected';
		echo '>'.number_format($value).'</option>';
	}
	
	echo '</select>';
}


#検索フォーム＞設備
function set_array_facility(){
	$setFacility['01_fa_autolock'] = 'autolock';
	$setFacility['02_fa_monitor'] = 'tv_intercom';
	$setFacility['03_fa_independent_washbasin'] = 'system_kitchen';
	$setFacility['04_fa_washlet'] = 'washlet';
	$setFacility['05_fa_free_internet'] = 'internet';
	$setFacility['06_fa_separate_bath_toilet'] = 'separate_bathroom_toilet';
	$setFacility['07_fa_washing_machine'] = 'washing_machine';
	$setFacility['08_fa_aircon'] = 'aircon';
	$setFacility['09_fa_2_gas_stoves'] = 'gas_stoves';
	$setFacility['11_fa_bicycle_parking'] = 'bicycle_parking';
	$setFacility['12_fa_car_parking'] = 'car_parking';
	$setFacility['15_fa_elevator'] = 'elevator';
	return $setFacility;
}


#面積配列取得
function set_array_property_size(){
	#面積パラメータ
	$property_size_low = 10;
	$property_size_high = 200;
	$property_size_step = 10;

	for ($i=$property_size_low; $i<=$property_size_high; $i+=$property_size_step){
		$property_size_array[] = $i;
	}
	return $property_size_array;
}


function set_form_search_sp(){
	if( is_front_page() ){
		$title = 'find_a_property';
	}else{
		$title = 'search_title_sp';
	}
?>
	<ul id="side_search_form" class="sidenav side_search_form">
		<li>
			<div class="side_search_form_wrap">
				<div class="slide_form_close_wrap"><a class="sidenav-close waves-effect waves-teal"><i class="material-icons">close</i></a></div><div class="search_form_title"><i class="material-icons bottom">search</i><?= articnet_echo_string('search'); ?></div>
				<?php if( is_front_page() ): ?>
				<div class="search_form_sp"><?php get_template_part('parts/sidebar', 'search_form'); ?></div>
				<?php else: ?>
				<div class="search_form_sp"></div>
				<?php endif; ?>
			</div>
		</li>
	</ul>
	<div class="side_form_open_wrap" align="center"><a data-target="side_search_form" class="btn side_form_open sidenav-trigger <?= qtranxf_getLanguage(); ?>"><i class="material-icons left <?= qtranxf_getLanguage(); ?>">search</i><?= articnet_echo_string( $title ); ?></a></div>
<?php
}


#SQL>タイトル、本文
function set_query_search_where( $where ) {
    global $wpdb;
    if( !empty( get_query_var('property_name') ) ) {
    	$property_name = get_query_var('property_name');
    	$where .= " AND {$wpdb->posts}.post_title LIKE '%{$property_name}%'";
    }
    return $where;
}

/*
function sql_dump($query)
{
    dump($query);
    return $query;
}
add_filter('query', 'sql_dump');
*/

?>
