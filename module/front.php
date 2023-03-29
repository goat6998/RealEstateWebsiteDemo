<?php

function get_templete_filename(){
	global $template;
	return basename($template);
}


function get_page_slug(){
	return basename( get_permalink() );
}


//コンテンツレイアウト＞
function set_materialize() {
	wp_enqueue_style('materialize_css', get_theme_file_uri('/layout/materialize/materialize.min.css'), array(), false, 'all');
	wp_enqueue_script('materialize_js', get_theme_file_uri('/layout/materialize/materialize.min.js'), array(), false, true);
	wp_enqueue_script('jquery', get_theme_file_uri('/layout/js/jquery-3.5.1.min.js'), array(), false, true);
	wp_enqueue_script('setting_js', get_theme_file_uri('/layout/js/setting.js'), array(), false, true);
	wp_enqueue_style('fontawesome_css', get_theme_file_uri('/layout/fontawesome/css/all.css'), array(), false, 'all');
	wp_enqueue_script('fontawesome_js', 'https://use.fontawesome.com/694ea7f193.js', array(), false, true);
}
add_action( 'wp_enqueue_scripts', 'set_materialize' );


//ページ設定＞js,css読み込み分岐
function set_enqueue_scripts() {
	
	if ( is_home() || is_front_page() ){
		wp_enqueue_style('home_css', get_theme_file_uri('/layout/css/home.css'), array(), false, 'all');
		wp_enqueue_script('home_js', get_theme_file_uri('/layout/js/home.js'), array(), false, true);
	}
	
	if( is_front_page() || is_search('property') || is_page('favorite') ){
		wp_enqueue_style('property_list_layout_css', get_theme_file_uri('/layout/css/property_list_layout.css'), array(), false, 'all');
		wp_enqueue_style('search_form_css', get_theme_file_uri('/layout/css/search_form.css'), array(), false, 'all');
		wp_enqueue_script('search_form_js', get_theme_file_uri('/layout/js/search_form.js'), array(), false, true);
	}
	
	if( is_search('property') ){
		wp_enqueue_style('property_list_css', get_theme_file_uri('/layout/css/property_list.css'), array(), false, 'all');
		wp_enqueue_style('search_form_css', get_theme_file_uri('/layout/css/search_form.css'), array(), false, 'all');
		wp_enqueue_style('property_list_layout_css', get_theme_file_uri('/layout/css/property_list_layout.css'), array(), false, 'all');
		wp_enqueue_script('property_list_js', get_theme_file_uri('/layout/js/property_list.js'), array(), false, true);
		wp_enqueue_script('search_form_js', get_theme_file_uri('/layout/js/search_form.js'), array(), false, true);
	}
	
	if( is_front_page() || is_search('property') || is_singular('property') || is_page('favorite') || is_single('contact_us') || is_page('contact_us') || is_page('register') || is_page('inquiry_form') || is_single('inquiry_form') ){
		wp_enqueue_style('remodal_css', get_theme_file_uri('/layout/remodal/remodal.css'), false, 'all' );
		wp_enqueue_style('remodal_theme_css', get_theme_file_uri('/layout/remodal/remodal-default-theme.css'), false, 'all' );
	    wp_enqueue_script('remodal_js', get_theme_file_uri('/layout/remodal/remodal.min.js'), array(), false, true );
	}
	
	if( is_front_page() || is_singular('property') ){
		wp_enqueue_style('swiper_css', get_theme_file_uri('/layout/swiper/swiper.min.css'), array(), false, 'all');
		wp_enqueue_script('swiper_js', get_theme_file_uri('/layout/swiper/swiper.min.js'), array(), false, true);
	}
	
	if( is_singular('property') ){
		wp_enqueue_style('single_css', get_theme_file_uri('/layout/css/single_property.css'), array(), false, 'all');
		wp_enqueue_script('single_property_js', get_theme_file_uri('/layout/js/single_property.js'), array(), false, true);
		wp_enqueue_script('property_print_js', get_theme_file_uri('/layout/js/property_print.js'), array(), false, true);
	}
	
	if( is_single('contact_us') || is_page('contact_us') || is_single('inquiry_form') || is_page('inquiry_form') ){
		wp_enqueue_style('inquiry_form_css', get_theme_file_uri('/layout/css/inquiry_form.css'), array(), false, 'all');
		wp_enqueue_script('inquiry_form_js', get_theme_file_uri('/layout/js/inquiry_form.js'), array(), false, true);
	}
	
	if( is_page('login') || is_page('register') || is_page('profile') || is_page('reset_password') || is_page('change_password') || is_page('favorite') || is_page('withdrawal') ){
		wp_enqueue_style('user_css', get_theme_file_uri('/layout/css/user.css'), array(), false, 'all');
		wp_enqueue_script('user_js', get_theme_file_uri('/layout/js/user.js'), array(), false, true);
	}
	
	if( is_page('access') || is_page('about-us') || is_page('frequentquestoins') || is_page('relocation-services') || is_page('activities-and-events') || is_page('employment-opportunities') || is_page('dgmobile') || get_post_type()=='area_info' || get_post_type()=='how_to' || get_post_type()=='notice' ){
		wp_enqueue_style('archive_css', get_theme_file_uri('/layout/css/archive.css'), array(), false, 'all');
		wp_enqueue_script('archive_js', get_theme_file_uri('/layout/js/archive.js'), array(), false, true);
	}
	
	if( get_post_type()=='area_info' ){
		wp_enqueue_style('single_css', get_theme_file_uri('/layout/css/single.css'), array(), false, 'all');
	}
	
	wp_enqueue_style('media_query_css', get_theme_file_uri('/layout/css/media_query.css'), array(), false, 'all');
	
}
add_action( 'wp_enqueue_scripts', 'set_enqueue_scripts' );


#ファビコンURL
function get_favicon_url(){
	$favicon_url = get_stylesheet_directory_uri()."/layout/img/favicons";
	return $favicon_url;
}


function check_smartphone(){
    if ( preg_match('/iPhone|iPod|iPad|Android/ui', $_SERVER['HTTP_USER_AGENT']) ) {
        return true;
    } else {
        return false;
    }
}


#seo
function set_page_title(){
	global $post;
	
	$page_title = NULL;
	
#物件一覧
	if( is_search('property') ){
		$page_title .= get_field_articnet('property_list');
		
		if( !empty( get_query_var('property_type') ) ){
			
			if( !is_array( get_query_var('property_type') ) ){
				$get_property_type[] = get_query_var('property_type');
			}else{
				$get_property_type = get_query_var('property_type');
			}
			
			foreach( $get_property_type as $key => $value ){
				$property_type_array[] = get_term_by( 'slug', $value, 'property_type' );
			}
			
			foreach( $property_type_array as $key => $value ){
				if( $value->parent == 0 ){
					$property_type_name_array[] = $value->name;
					$args = array(
						'taxonomy'=>'property_type',
						'hide_empty'=>true,
						'parent'=>$value->term_id
					);
					$get_terms = get_terms( $args );
					foreach( $get_terms as $pk => $pv ){
						$property_type_name_array[] = $pv->name;
					}
				}else{
					$property_type_parent_array[] = get_term_by( 'term_id', $value->parent, 'property_type' );
					foreach( $property_type_parent_array as $pk => $pv ){
						$property_type_name_array[] = get_term_by( 'slug', $pv->slug, 'property_type' )->name;
					}
				}
				

				$property_type_name_array[] = $value->name;
			}
			$property_type_name_array = array_unique( $property_type_name_array );
			$page_title .= ' | ';
			$page_title .= implode(' | ', $property_type_name_array);
			$page_title .= ' | ';
		}
	}
	
#物件詳細
	if( is_singular('property') ){
		$page_title .= $post->post_title;
		
		$property_type = get_the_terms( $post->ID, 'property_type' );
		
		if( $property_type[0]->parent!=0 ){
			$page_title .= ' | ';
			$page_title .= get_term( $property_type[0]->parent, 'property_type' )->name;
		}
		
		
		
		$page_title .= ' | ';
		$page_title .= $property_type[0]->name.' | ';
	}
	
#シングル
	if( is_page() || is_single() && !is_singular('property') ){
		
		$page_title .= $post->post_title.' | ';
		
		if( get_post_type()=='area_info' ){
			$category = get_the_terms( $post->id, 'area_category' );
			if( !empty( $category ) ) $page_title .= $category[0]->name.' | ';
		}
		
	}
	
#アーカイブ
	if( is_archive() || is_page() || is_single() ){
		if( preg_match('/area_info|notice|how_to/', get_post_type() ) ){
			$page_title .= get_post_type_object( get_post_type() )->label.' | ';
		}
	}
	
	$page_title .= get_bloginfo('name');
	
	return $page_title;
}


#fb meta
function set_page_description(){
	global $post;
	
	$description = NULL;
	
	if( is_singular('property') ){
		
		$description .= get_field('property_layout')['label'];
		if( !empty( get_field('property_layout') ) ) $description .= ' | ';
		
		$description .= get_field_price('price', true);
		if( !empty( get_field('price') ) ) $description .= ' | ';
		
		if( have_rows( 'near_stations', $post->ID ) ){
			$i = 0;
		    while ( have_rows( 'near_stations', $post->ID ) ) : the_row();
		        $near_stations = get_sub_field('station');
		        if( !empty( $near_stations->name ) ){
			        $near_station = $near_stations->name;
			        $near_station .= get_field_articnet( 'minutes_from_station' )." ";
			        $minutes_from_station = get_sub_field( 'minutes_from_station' );
			        $near_station .= $minutes_from_station." ";
			        $near_station .= get_field_articnet( 'minutes_symbol' );
			        if( $i==0 ) break;
			        $i++;
			    }
		    endwhile;
		    
		    $description .= $near_station.' | ';
		    
		}
		
		$property_category = wp_get_object_terms( $post->ID, 'property_category');
		if( !empty( $property_category ) ){
			foreach( $property_category as $key => $value ){
				$property_category_array[] = $value->name;
			}
			$description .= implode(' | ', $property_category_array);
		}
		
		$description .= get_field('address');
		if( !empty( get_field('address') ) ) $description .= ' | ';
		
		$description .= get_field('catchphrase');
		if( !empty( get_field('catchphrase') ) ) $description .= ' | ';
		
		$description .= get_strip_tags( $post->post_content );
	}
	
#シングル
	if( !is_home() && !is_front_page() && is_page() || is_single() ){
		$description .= get_strip_tags( $post->post_content );
	}
	
	if( is_home() || is_front_page() || empty( $description ) ){
		$description .= get_bloginfo('description');
	}
	
#SEO対策、スマホPC、文字数制限
	$length = ( check_smartphone() ) ? 152 : 252 ;
	$description = get_mb_strimwidth( $description, $length );
	
	
	
	return $description;
}

#fb meta ogtype
function set_meta_og_type(){
	$og_type = ( is_front_page() ) ? 'website' : 'article' ;
	return $og_type;
}

#fb meta image
function set_page_image(){
	
	global $post;
	
	$set_page_image = NULL;
	
#物件詳細
	if( is_singular('property') ){
		$thumbnail_url = get_the_post_thumbnail_url( $post->ID, 'large' );
		$set_page_image = set_resize_image( $thumbnail_url, 1200 );
	}
	
#エリア紹介
	if( is_page() || is_single() && get_post_type()=='area_info' ){
		$header_bg_image = get_field("header_bg_image");
		if( !empty( $header_bg_image ) ){
			$set_page_image = set_resize_image( $header_bg_image['url'], 1200, false );
		}
	}
	
#サイトトップ画像
	if( is_front_page() || empty( $set_page_image ) || is_archive() ){
		$set_page_image = header_image();
	}
	
	return $set_page_image;
}

#fb meta
function set_page_url(){
	
	global $post;
	
	$set_page_url = NULL;
	
	if( is_front_page() ){
		$set_page_url = home_url('/');
	}
	
	if( is_singular('property') ){
		$set_page_url = get_permalink( $post->ID );
	}
	
	if( is_search('property') || is_archive() || is_page() || is_single() ){
		$set_page_url = get_pagenum_link( get_query_var('paged') );
	}
	
	return $set_page_url;
}


#管理者権限を持つユーザーのみ管理バーを表示
if( ! current_user_can( 'manage_options' ) ){
	show_admin_bar( false );
}


function get_my_locale(){
	if( qtranxf_getLanguage()=='ja' ){
		$get_my_locale = 'ja_JP';
	}else{
		$get_my_locale = get_locale();
	}
	return $get_my_locale;
}


#現在の言語の表示
function get_current_lang_trans( $lang ){
	$get_lang_list = get_lang_list();
	return $get_lang_list[$lang];
}


function set_messanger_url(){
	return 'https://m.me/DaiwajinRealEstate';
}


#言語選択＞PC
function get_select_lang(){
	#icon > language, translate
	$qtranxf_getLanguage = qtranxf_getLanguage();
	echo '<div class="languages-div">
              <a class="dropdown-trigger waves-effect waves-light btn" data-target="select_lang"><i class="material-icons left">translate<!--language/translate--></i>'.get_current_lang_trans( $qtranxf_getLanguage ).'<i class="material-icons right">arrow_drop_down</i></a>

<ul id="select_lang" class="dropdown-content">';

$get_lang_list = get_lang_list();
foreach( $get_lang_list as $key => $value ){
	if( $qtranxf_getLanguage == $key ){
		echo '<li class="active"><a>'.$value.'</a></li>';
	}else{
		echo '<li><a href="'.qtranxf_convertURL('', $key, false, true).'" class="active">'.$value.'</a></li>';
	}
}

echo '</ul>
        	</div>';
}


#言語選択＞スマホ
function get_select_lang_sp(){
	#icon > language, translate
	$qtranxf_getLanguage = qtranxf_getLanguage();
	echo '<li><a class="dropdown-trigger" data-target="select_lang_sp"><i class="material-icons middle">translate</i></a></li>
<ul id="select_lang_sp" class="dropdown-content">';
$get_lang_list = get_lang_list();
foreach( $get_lang_list as $key => $value ){
	if( $qtranxf_getLanguage == $key ){
		echo '<li class="active"><a>'.$value.'</a></li>';
	}else{
		echo '<li><a href="'.qtranxf_convertURL('', $key, false, true).'" class="active">'.$value.'</a></li>';
	}
}
echo '</ul>';
}


#スマホメニューアイコン
function get_menu_icon_sp(){
	$get_menu_icon_sp[] = '<i class="fas fa-house-user" aria-hidden="true" style="font-size: 1.5rem;"></i>';
	$get_menu_icon_sp[] = '<i class="fas fa-house-user" aria-hidden="true" style="font-size: 1.5rem;"></i>';
	$get_menu_icon_sp[] = '<i class="small material-icons">location_city</i>';
	$get_menu_icon_sp[] = '<i class="small material-icons">location_city</i>';
	$get_menu_icon_sp[] = '<i class="small material-icons">notifications</i>';
	$get_menu_icon_sp[] = '<i class="small material-icons">library_books</i>';
	$get_menu_icon_sp[] = '<i class="fas fa-street-view" aria-hidden="true"></i>';
	$get_menu_icon_sp[] = '<i class="fas fa-envelope-open-text"></i>';
	$get_menu_icon_sp[] = '<i class="fas fa-cart-plus"></i>';
	return $get_menu_icon_sp;
}


#ページテンプレートアイコン
function get_icon_page(){
	if( is_page('about-us') ){
		$icon = '<i class="material-icons bottom">business</i> ';
	}else if( is_page('access') ){
		$icon = '<i class="fas fa-map-marked-alt"></i> ';
	}else if( is_page('frequentquestoins') ){
		$icon = '<i class="material-icons bottom">question_answer</i> ';
	}else if( is_page('relocation-services') ){
		$icon = '<i class="fas fa-cart-plus"></i> ';
	}else if( is_page('activities-and-events') ){
		$icon = '<i class="material-icons bottom">event_note</i> ';
	}else if( is_page('employment-opportunities') ){
		$icon = '<i class="material-icons bottom">group_add</i> ';
	}else if( is_page('dgmobile') ){
		$icon = '<i class="material-icons bottom">sim_card</i> ';
	}
	if( empty( $icon ) ) $icon = null;
	return $icon;
}


function set_user_menu(){
	
	$set_user_menu[0]['url'] = home_url('/profile');
	$set_user_menu[0]['icon'] = 'person';
	$set_user_menu[0]['title'] = 'registration_information';
	
	$set_user_menu[1]['url'] = home_url('/favorite');
	$set_user_menu[1]['icon'] = 'favorite';
	$set_user_menu[1]['title'] = 'favorite';
	
	$set_user_menu[2]['url'] = wp_logout_url( get_permalink() );
	$set_user_menu[2]['icon'] = 'lock_open';
	$set_user_menu[2]['title'] = 'logout';
	
?>
	<?php if( is_user_logged_in() ): ?>
	<?= articnet_echo_string('howdy'); ?><?= get_full_name() ?><?= articnet_echo_string('mr'); ?><a class='dropdown-trigger' data-target='member_menu'><i class="material-icons right">account_circle</i></a>
	<ul id='member_menu' class='dropdown-content'>
<?php foreach( $set_user_menu as $key => $value ): ?>
		<li <?php if( !is_front_page() && preg_match( '/'.get_page_slug().'$/', $value['url'] ) && $key <= 1 ) echo 'class="active"'; ?>><a href="<?= $value['url'] ?>"><i class="material-icons"><?= $value['icon'] ?></i><?= articnet_echo_string( $value['title'] ); ?></a></li>
<?php endforeach; ?>
	</ul>
	<?php else: ?>
	<div style="display: inline-block;"><?= set_login_link(); ?></div>
	<?php endif; ?>
<?php
}


function set_login_link(){
	if( is_page('login') ){
		echo set_login_link_passive();
	}else{
		echo set_login_link_active();
	}
}


function set_login_link_active(){
?>
<a href="<?= home_url('/login') ?>"><?= set_login_link_passive(); ?></a>
<?php
}


function set_login_link_passive(){
?>
<i class="material-icons left" style="margin-right: 0;">exit_to_app</i><?= articnet_echo_string('login'); ?>
<?php
}


#初回ログイン
function set_view_first_login(){
	if( !empty( $_REQUEST['login'] ) && $_REQUEST['login']=='true' ){
		echo '<script>
			jQuery(function($){
		var toastHTML = "<span>';
		echo articnet_echo_string('howdy');
		echo get_full_name();
		echo articnet_echo_string('mr');
		echo '</span>"; M.toast({html: toastHTML});
	});
	  </script>';
		echo '<script src="'.get_theme_file_uri('/layout/js/replaceurl.js').'"></script>';
	}
}


#エリア紹介ヘッダー
function set_area_info_header(){
	global $post;
	$header_bg_image = get_field("header_bg_image");
	$category = get_the_terms( $post->id, 'area_category' );
	get_template_part('parts/breadcrumbs');
	$header_bg_image_url = ( !empty( $header_bg_image ) ) ? $header_bg_image['url'] : NULL ;
?>
<div class="parallax_wrap">
	<div class="parallax-container">
		<div class="parallax"><img src="<?= $header_bg_image_url ?>">
	</div>
	<div class="languages_position"><?= get_select_lang(); ?></div>
	<div class="roundedmplus1c"><h1><?= the_title(); ?><br><?= $category[0]->name ?></h1></div>
</div>
<?php
}


#物件データ取得＞トップページ
function get_post_type_array( $post_type, $posts_per_page ){
	$args = array(
		'post_type' => $post_type,
		'posts_per_page' => $posts_per_page
	);
	$get_posts = get_posts( $args );
	return $get_posts;
}


#物件データ取得＞トップページ
function get_property_recommended( $term_id, $taxonomy, $posts_per_page ){
	
	$args = array(
		'post_type' => 'property',
		'posts_per_page' => $posts_per_page,
		'tax_query' => array(
			array(
				'taxonomy' => $taxonomy,
				'terms' => $term_id,
			)
		),
	);
	$args['meta_query'][] = array(
			'key' => 'recommended',
			'value' => 1,
			'compare' => '=='
		);
	$get_posts = get_posts( $args );
	return $get_posts;
}


//物件一覧＞トップページ
function set_view_property_list_home(){
	global $post;
	$get_parent_child = get_parent_child('property_type'); 
	if( !empty( $get_parent_child ) ){
		foreach( $get_parent_child['parent'] as $key => $value ){
			
			echo '<article>';
			echo '<div class="col s12 property_type">';
			echo '<div class="home_sub_title"><h2>'.$value->name.'</h2></div>';
			echo '<div><a href="/property_list?property_type='.$value->slug.'">';
			echo articnet_echo_string('see_more');
			echo '</a></div>';
			echo '</div>';
			
			$get_property_recommended[$value->slug] = get_property_recommended( $value->term_id, 'property_type', 10 );
			if( !empty( $get_property_recommended[$value->slug] ) ){
				
				echo '<div class="col s12 swiper_wrap">';
				echo '<article>';
				
				echo '<div class="swiper_front swiper-container">';
				echo '<div class="swiper-wrapper">';
				foreach( $get_property_recommended[$value->slug] as $k => $v ){
					setup_postdata( $v );
					if ( has_post_thumbnail( $v->ID ) && get_queried_object()->ID !== $v->ID ){
						echo '<div class="swiper-slide">';
						set_view_property_single( $v->ID );
						echo '</div>';#swiper-slide
					}
				}
				echo '</div>';
				echo '<div class="swiper-pagination"></div>';
				echo '<div class="swiper-button-prev"></div>';
				echo '<div class="swiper-button-next"></div>';
				echo '</div>';
				
				echo '</article>';
				echo '</div>';
			}
			
			
			echo '</article>';
			
			wp_reset_postdata();
		}
		
	}
}


#サムネイル
function set_resize_image( $image_url, $width=NULL ){
	if( empty( $width ) ) $width = 386;
	$full_path = str_replace(WP_CONTENT_URL, WP_CONTENT_DIR, $image_url);
	$resize_file = get_template_directory_uri().'/module/img_resize.php?url='.$image_url.'&width='.$width.'&path='.$full_path;
	return $resize_file;
}


function set_view_property_single( $post_id ){
	
	echo '<article>';
	echo '<div class="property_list">';
	$catchphrase = get_field('catchphrase', $post_id );
	if( empty( $catchphrase ) ) $catchphrase = '　';
	echo '<div class="catchphrase '.qtranxf_getLanguage().' bgwhite" align="center"><h4>'.get_mb_strimwidth( $catchphrase, 40 ).'</h4></div>';
	
	if( get_field('members_only', $post_id ) && !is_user_logged_in() ){
		$get_permalink[ $post_id ] = home_url('/register');
	}else{
		$get_permalink[ $post_id ] = esc_url( get_permalink( $post_id ) );
	}
	echo '<a href="'.$get_permalink[ $post_id ].'" title="'.esc_attr( get_the_title( $post_id ) ).'">';
	
	if( has_post_thumbnail( $post_id ) ){
		$thumbnail_url = get_the_post_thumbnail_url( $post_id, 'large' );
		$no_image = NULL;
	}else{
		$thumbnail_url = get_theme_file_uri('/layout/img/no_image.jpg');
		$no_image = 'no_image';
	}
	
	echo '<div class="property_image_wrap">';
	$floorp = get_field( 'floorplan',  $post_id );
	if( !empty( $floorp['sizes']['large'] ) && $no_image==NULL ){
		$floorplan_image = set_resize_image( $floorp['sizes']['large'] );
		echo '<div class="property_image_overlay">';
		echo '<img src="'.$floorplan_image.'" title="'.esc_attr( get_the_title( $post_id ) ).'">';
		echo '</div>';
	}
	
	$thumbnail_url = set_resize_image( $thumbnail_url );
	
	echo '<div class="property_image '.$no_image.'"><img src="'.$thumbnail_url.'" title="'.esc_attr( get_the_title( $post_id ) ).'"></div>';
	
	if( get_field('members_only', $post_id ) && !is_user_logged_in() ){
		
		if( qtranxf_getLanguage()=='en' ){
			$classname_members_only = 'en';
		}else{
			$classname_members_only = 'other';
		}
		
		echo '<div class="members_only" align="center"><span class="'.$classname_members_only.'">';
		echo articnet_echo_string('members_only');
		echo '</span></div>';
	}
	
	if( get_field( 'sold',  $post_id ) ){
		echo '<div class="sold">';
		echo articnet_echo_string('sold');
		echo '</div>';
	}
	
	echo '</div>';
	
	$property_area_name = NULL;
	$property_area = wp_get_post_terms( $post_id, 'area' );
	if( !empty( $property_area ) ){
		$property_area_name = ' ('.$property_area[0]->name.')';
	}
	
	echo '<div class="property_data">';
	echo '<h3>'.get_the_title( $post_id ).$property_area_name.'</h3>';
	echo get_price_format( $post_id );
	
	$get_property_layout = get_field( 'property_layout',  $post_id );
	if( !empty( $get_property_layout['label'] ) ) $get_property_layout = $get_property_layout['label'];
	$get_property_size = get_field( 'property_size',  $post_id );
	
	echo '<div>'.$get_property_layout.' / '.$get_property_size.'㎡</div>';
	echo '</div>';
	echo '</a>';
	echo '</div>';
	echo '</article>';
}


//家賃、価格
function get_price_format( $post_id ){
	$price_format = number_format( get_field('price', $post_id) )." 円";
	return $price_format;
}


#文字制限
function get_mb_strimwidth( $data, $length ){
	return mb_strimwidth($data, 0, $length, '…', 'utf8');
}


#記事本文、HTML、空白削除
function get_strip_tags( $post_content ){
	$post_content = strip_tags( $post_content );
	$replaceTarget = array('<br>', "\r\n", "\t", '&nbsp;', '&emsp;', '&ensp;');
	$post_content = str_replace( $replaceTarget, '', $post_content );
	$post_content = preg_replace( '/(\[titlebar\]|\[\/titlebar\])/', '', $post_content );
	$post_content = preg_replace('/[\s]+/mu', ' | ', $post_content);
	return $post_content;
}


#記事本文、文字制限
function set_archive_content_home( $post_content ){
	$post_content = get_strip_tags( $post_content );
	return get_mb_strimwidth( $post_content, 48 );
}


#ページング
function set_pagenavi(){
	global $paged;
	global $max_num_pages;
?>
<script>
jQuery(function($){
	
	$('.nextpostslink').html('<i class="fas fa-angle-right"></i>');
	$('.previouspostslink').html('<i class="fas fa-angle-left"></i>');
	
	<?php if( $paged >= 6 && $max_num_pages >= 6 ): ?>
	$('.wp-pagenavi').prepend('<a class="firstpostslink" rel="first" href="<?= home_url('/property_list/page/1/') ?>?<?= $_SERVER['QUERY_STRING'] ?>"><i class="fas fa-angle-double-left"></i></a>');
	<?php endif; ?>
	
	<?php if( $paged!=$max_num_pages && $max_num_pages >= 6 ): ?>
	$('.wp-pagenavi').append('<a class="lastpostslink" rel="last" href="<?= home_url('/property_list/page/').$max_num_pages ?>/?<?= $_SERVER['QUERY_STRING'] ?>"><i class="fas fa-angle-double-right"></i></a>');
	<?php endif; ?>
});
</script>
<?php
}


//フッター
//コンテンツ表示＞フッター＞左メニュー
function get_footer_menu($menu_name){
	if( isset( $menu_name ) ){
		echo '<h6>';
		echo articnet_echo_string( $menu_name );
		echo '</h6><ul>';
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
			$menu_items = wp_get_nav_menu_items($menu->term_id);
			foreach ( $menu_items as $key => $value ) {
				
				if( $menu_name=='member_menu' ){
					if( !is_user_logged_in() ){
						if( preg_match( '/logout/', $value->url ) || preg_match( '/favorite/', $value->url ) ){
							unset( $value->url );
						}
					}else if( preg_match( '/logout/', $value->url ) ){
						$value->url = wp_logout_url(get_permalink());
					}else if( preg_match( '/login/', $value->url ) || preg_match( '/register/', $value->url ) ){
						unset( $value->url );
					}
				}
#				dump( $menu_items );
				if( !empty( $value->url ) ){
					echo '<li><a href="' . $value->url . '">' . $value->title . '</a></li>';
				}
			}
		}
		echo '</ul>';
	}else{
		echo NULL;
	}
}


#物件詳細
function get_field_price( $field, $format = NULL ){
	if( empty( $get_field = get_field( $field ) ) ){
		$get_field = 0;
	}
	if( $format==true ){
		$get_field = '&yen '.number_format( $get_field );
	}
	return $get_field;
}


#物件詳細＞ギャラリー
function set_view_swiper_slide( $mode ){
	
	if( empty( $mode ) ) $mode = 'medium_large';
	
	echo '<div class="swiper-wrapper">';
	$gallery = get_field('gallery');
	if( !empty( $gallery ) ){
		foreach( $gallery as $key => $value ){
			echo '<div class="swiper-slide" style="background-image:url('.$value['sizes'][$mode].')"></div>';
		}
	}
	echo '</div>';
}


function set_view_swiper_gallery(){
?>
<h1 class="title_single_property"><?= the_title() ?></h1>
<div class="swiper_single_property">
	<div class="swiper-container gallery-top">
		<?= set_view_swiper_slide('medium_large') ?>
	    <div class="swiper-button-next"></div>
	    <div class="swiper-button-prev"></div>
	</div>
	<div class="swiper-container gallery-thumbs">
		<?= set_view_swiper_slide('thumbnail') ?>
	</div>
<?php
if( get_field( 'sold',  get_the_ID() ) ){
	echo '<div class="sold"><h4>';
	echo articnet_echo_string('sold');
	echo '</h4></div>';
}
?>

	<div class="floorplan_wrap_sp">
		<a data-remodal-target="modal-floorplan" class="btn btn_floorplan"><i class="small material-icons center bottom">apps</i> <?= articnet_echo_string('floor_plan'); ?></a>
		<div data-remodal-id="modal-floorplan" data-remodal-options="hashTracking: false" class="remodal">
		<button data-remodal-action="close" class="remodal-close"></button>
<?php 
$floorp = get_field('floorplan');
if( !empty( $floorp ) ){
	echo '<div><img src="'.set_resize_image( $floorp['url'] ).'" alt="'.$floorp['alt'].'" /></div>';
}
?>
		</div>
	</div>

</div>
<?php
}


#初期費用モーダル
function set_view_initial_cost(){
?>
	<div>
		<a class="waves-effect waves-light btn initial_cost_btn" data-remodal-target="modal-initial_cost"><i class="fas fa-yen-sign middle" aria-hidden="true" style="font-size: 1.2em;"></i> <?= articnet_echo_string('initial_cost'); ?></a>
	</div>
	<div data-remodal-id="modal-initial_cost" data-remodal-options="hashTracking: false" class="remodal initial_cost_main">
	
		<h4><?= the_title() ?></h4>
		<div align="center"><h5><?= get_initial_cost_total() ?></h5></div>
		<div class="pink-text" align="center"><p><?= articnet_echo_string('cost_breakdown'); ?></p></div>
		<table class="initial_cost_table" align="center">
		<tbody>
		<tr>
			<td>
		<?php
		$get_the_terms = get_the_terms( get_the_ID(), 'property_type' );

		if( preg_match('/long|short/', $get_the_terms[0]->slug ) ){
			echo articnet_echo_string('monthly_rent');
		}else{
			echo articnet_echo_string('price');
		}
		?></td>
			<td><?= get_field_price('price', true) ?></td>
		</tr>

		<?php if( preg_match('/long/', $get_the_terms[0]->slug ) ): ?>
		<tr>
			<td><?= articnet_echo_string('maintenance_fee'); ?></td>
			<td><?= get_field_price('maintenance_fee', true) ?></td>
		</tr>

		<tr>
			<td><?= articnet_echo_string('deposit'); ?></td>
			<td><?= get_field_price('deposit', true) ?></td>
		</tr>

		<tr>
			<td><?= articnet_echo_string('key_money'); ?></td>
			<td><?= get_field_price('key_money', true) ?></td>
		</tr>
		<?php endif; ?>

		<?php if( preg_match('/short/', $get_the_terms[0]->slug ) ): ?>
		<tr>
			<td><?= articnet_echo_string('weekly_price'); ?></td>
			<td><?= get_field_price('weekly_price', true) ?></td>
		</tr>

		<tr>
			<td><?= articnet_echo_string('deposit'); ?></td>
			<td><?= get_field_price('deposit_short', true) ?></td>
		</tr>

		<tr>
			<td><?= articnet_echo_string('minimum_stay'); ?></td>
			<td><?= get_field_price('minimum_stay') ?></td>
		</tr>
		<?php endif; ?>

		<?php if( preg_match('/long|short/', $get_the_terms[0]->slug ) ): ?>
			<?php
			$initial_cost_key[] = 'fire_insurance';
			$initial_cost_key[] = 'rental_guarantee_fee';
			$initial_cost_key[] = 'key_exchange_fee';
			$initial_cost_key[] = 'brokerage_fee';
			$initial_cost_key[] = 'other_expenses';

			foreach( $initial_cost_key as $key => $value ):
			?>
				<?php if( !empty( get_field( $value ) ) ): ?>
				<tr>
					<td><?= articnet_echo_string( $value ); ?></td>
					<td><?= get_field_price($value, true); ?></td>
				</tr>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php if( preg_match('/buy/', $get_the_terms[0]->slug ) ): ?>
		<tr>
			<td><?= articnet_echo_string('rent_investment'); ?></td>
			<td><?= get_field_price('rent_investment', true) ?></td>
		</tr>

		<tr>
			<td><?= articnet_echo_string('maintenance_fee'); ?></td>
			<td><?= get_field_price('maintenance_fee_buy', true) ?></td>
		</tr>

		<tr>
			<td><?= articnet_echo_string('reserve_fund'); ?></td>
			<td><?= get_field_price('reserve_fund_buy', true) ?></td>
		</tr>
		<?php endif; ?>

		</table>

<?php if( get_field('remarks') ): ?>
		<div style="text-align: center;">
			<p>
				<div style="display: inline-block;text-align: left;"><div><?= articnet_echo_string('remarks'); ?></div><?= nl2br( get_field('remarks') ) ?></div>
			</p>
		</div>
<?php endif; ?>

		<div style="text-align: center;">
			<div><p style="display: inline-block;text-align: left;"><?= articnet_echo_string('initial_cost_notice'); ?><p></div>
		</div>
			
		<div align="center">
			<a data-remodal-action="confirm" class="remodal-confirm btn black-text bgnone" style="margin-bottom: 2rem;"><?= articnet_echo_string('close'); ?> <i class="material-icons bottom">done_all</i></a>
		</div>

	</div>
<?php
}


function set_view_googlemap(){
?>
<?php $location = get_field('map'); ?>
<?php if( !empty( $location ) ): ?>
<div class="googlemap_wrap">
	<div class="googlemap">
		<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
	</div>
</div>
<?php endif; ?>
<?php
}


#各言語グーグルマップ表示用
function get_googlemap_lang(){
	$qtranxf_getLanguage = qtranxf_getLanguage();
	if( $qtranxf_getLanguage == 'zh' ){
		$qtranxf_getLanguage = 'zh-CN';
	}else if( $qtranxf_getLanguage == 'kr' ){
		$qtranxf_getLanguage = 'ko';
	}
	return $qtranxf_getLanguage;
}


function set_view_property_category(){
	$property_category = wp_get_object_terms( get_the_ID(), 'property_category');
	foreach( $property_category as $key => $value ){
		echo '<div class="btn-flat indigo white-text property_category" ><h3>'.$value->name.'</h3></div>';
	}
}


function set_view_facilities(){
?>
<h2 class="sub_title title_facility"><i class="fa fa-bath"></i> <?php echo articnet_echo_string('facilities'); ?></h2>
<div class="facility_icon_wrap">
	<ul>
<?php
$icons_folder = get_template_directory_uri().'/layout/img/single-property-icons/';
$set_array_facility = set_array_facility();
foreach( $set_array_facility as $key => $value ):
?>
		<li><img title="<?php articnet_echo_string( $value ); ?>" src="<?php echo ( !empty( get_field($key) ) ) ? $icons_folder.$key.'_on.png' : $icons_folder.$key.'.png' ; ?>" class="facility_icon" width="37" height="37"></li>
<?php endforeach; ?>
	</ul>
</div>
<?php
}


function set_view_privacy_policy(){
?>
<div class="col s12 privacy_policy_wrap" align="center">
	<a data-remodal-target="modal-privacy_policy" class="btn waves-effect waves-light privacy_policy_btn" disabled><?php echo articnet_echo_string('privacy_policy'); ?> <i class="fas fa-user-lock" aria-hidden="true" style="font-size: 1.2rem;"></i></a>
	<div data-remodal-id="modal-privacy_policy" data-remodal-options="hashTracking: false" class="remodal">
		<div class="privacy_policy_body">
			<?php $page_data = get_page_by_path('privacy_policy'); ?>
			<div class="col s12" align="center"><h4><?= __($page_data->post_title) ?></h4></div>
			<?php $post_content = apply_filters('the_content', __( $page_data->post_content ) ); ?>
			<div class="col s12"><p><?= $post_content ?></p></div>
		</div>
		<div align="center">
			<a data-remodal-action="confirm" class="remodal-confirm btn teal privacy_policy_agree"><?php echo articnet_echo_string('agree'); ?><i class="material-icons right">done_all</i></a>
		</div>
	</div>
</div>
<?php
}


function set_view_single_property_main_contents_bottom_sp(){
?>

	<table class="initial_cost_sp_table">
		<tr>
			<td>
<?php
$get_the_terms = get_the_terms( get_the_ID(), 'property_type' );
if( preg_match('/long|short/', $get_the_terms[0]->slug ) ){
	echo articnet_echo_string('monthly_rent');
}else{
	echo articnet_echo_string('price');
}
?> / <?php articnet_echo_string('maintenance_fee'); ?>
			</td>
			<td><?= get_field_price('price', true) ?> / <?= get_field_price('maintenance_fee', true) ?></td>
		</tr>
		<tr>
			<td><?php articnet_echo_string('deposit'); ?> / <?php articnet_echo_string('key_money'); ?></td>
			<td><?= get_field_price('deposit', true) ?> / <?= get_field_price('key_money', true) ?></td>
		</tr>
		<tr>
			<td colspan="2">
<?php
$property_layout = get_field('property_layout');
echo $property_layout['label'];
?> / <?php
$property_size = get_field('property_size');
if( empty( $property_size ) ) $property_size = '-';
echo $property_size.'㎡';
?> / <?php
$year_built = get_field('year_built');
if( empty( $year_built ) ) $year_built = '-';
echo $year_built;
echo articnet_echo_string('year_of_construction');
?>

<?php if( get_field('initial_cost_view')==1 ): ?>
<div class="initial_cost_sp_wrap">
	<?= set_view_initial_cost(); ?>
</div>
<?php endif; ?>
	
			</td>
		</tr>
	</table>
	<table class="initial_cost_sp_table2">
		<tr>
			<td><i class="material-icons left" style="margin-right: 0;">train</i><?php articnet_echo_string('train_line'); ?></td>
			<td>
<?php
if( have_rows('near_stations') ){
	while( have_rows('near_stations') ): the_row();
		$station = get_sub_field('station');
		$minutes_from_station = get_sub_field('minutes_from_station');
		echo '<span>'.$station->name .' ('. $minutes_from_station;
		echo articnet_echo_string('minutes_symbol');
		echo ')</span><br/>';
	endwhile;
}
?>
			</td>
		</tr>
		<tr>
			<td><i class="material-icons left" style="margin-right: 0;">place</i><?php articnet_echo_string('address'); ?></td>
			<td><?= get_field('address'); ?><div class="btn_map"><a data-remodal-target="modal-gmap" class="btn"><i class="fas fa-map-marked-alt bottom" aria-hidden="true" style="font-size: 1.5rem;"></i>　<?= articnet_echo_string('map'); ?></a></div>
				<div data-remodal-id="modal-gmap" data-remodal-options="hashTracking: false" class="remodal googlemap_sp_remodal">

					<div class="googlemap_sp"></div>

					<div align="center">
						<a data-remodal-action="confirm" class="remodal-confirm btn teal white-text"><?= articnet_echo_string('close'); ?></a>
					</div>
				</div>
			</td>
		</tr>
	</table>
<?php
}


function get_initial_cost_total(){
	
	$get_the_terms = get_the_terms( get_the_ID(), 'property_type' );
	
	$set_initial_cost[] = 'price';
	$set_initial_cost[] = 'maintenance_fee';
	$set_initial_cost[] = 'deposit';
	$set_initial_cost[] = 'key_money';
	$set_initial_cost[] = 'weekly_price';
	$set_initial_cost[] = 'deposit_short';
	
	if( preg_match('/buy/', $get_the_terms[0]->slug ) ){
		$set_initial_cost[] = 'minimum_stay';
		$set_initial_cost[] = 'rent_investment';
		$set_initial_cost[] = 'maintenance_fee_buy';
		$set_initial_cost[] = 'reserve_fund_buy';
	}else{
		$set_initial_cost[] = 'fire_insurance';
		$set_initial_cost[] = 'rental_guarantee_fee';
		$set_initial_cost[] = 'key_exchange_fee';
		$set_initial_cost[] = 'brokerage_fee';
		$set_initial_cost[] = 'other_expenses';
	}
	
	foreach( $set_initial_cost as $key => $value ){
		$get_field_price[] = get_field_price( $value );
	}
	
	$get_field_price = array_filter( $get_field_price );
	$setCost = array_sum( $get_field_price );
	$setCost = '&yen '.number_format( $setCost );
	return str_replace( 0, $setCost, get_field_articnet('initial_cost_total') );
}


function get_date_picker_value(){
	
	$qtranxf_getLanguage = qtranxf_getLanguage();
	if( $qtranxf_getLanguage=='ja' ){
		$months = '"1月", "2月", "3月", "4月", "5月", "6月", "7月", "8月", "9月", "10月", "11月", "12月"';
		$monthsShort = $months;
		$weekdays = '"日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日"';
		$weekdaysShort = '"日", "月", "火", "水", "木", "金", "土"';
	}else if( $qtranxf_getLanguage=='zh' ){
		$months = '"一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"';
		$monthsShort = $months;
		$weekdays = '"星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"';
		$weekdaysShort = '"周日", "周一", "周二", "周三", "周四", "周五", "周六"';
	}else if( $qtranxf_getLanguage=='kr' ){
		$months = '"일월", "이월", "삼월", "사월", "오월", "유월", "칠월", "팔월", "구월", "시월", "십일월", "십이월"';
		$monthsShort = $months;
		$weekdays = '"일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"';
		$weekdaysShort = '"일", "월", "화", "수", "목", "금", "토"';
	}
	
	if( $qtranxf_getLanguage!='en' ){
echo <<<datepicker
jQuery('.datepicker').datepicker({
    format: "yyyy-mm-dd",
    selectYears: 1,
    setDefaultDate:true,
    i18n:{
      months:  [{$months}],
      monthsShort: [{$months}],
      weekdays: [{$weekdays}],
      weekdaysShort: [{$weekdays}],
      weekdaysAbbrev: [{$weekdaysShort}],
      nextMonth: "翌月",
      previousMonth: "前月",
      labelMonthSelect: "月を選択",
      labelYearSelect: "年を選択",
      setDefaultDate:true,
      cancel:'Cancel',
      clear: 'Clear',
      done: 'OK',
      close: "Close",
      format: "yyyy-mm-dd",
    }
});
datepicker;
	}else{
echo <<<datepicker
	jQuery('.datepicker').datepicker({
		'format':'yyyy-mm-dd',
		'selectYears': 1,
		'setDefaultDate':true,
	});
datepicker;
	}
	
}


#コンタクトフォーム＞物件データ一件用
function set_view_contact_single_property(){
	
	global $post;
	
	$property_area = wp_get_post_terms( get_the_ID(), 'area');
	if( !empty( $property_area ) ){
		$property_area = $property_area[0]->name;
	}
	
	echo '<div class="col s6 offset-s3 card inquiry_property_wrap">
			<div class="card-content inquiry_property">
			<h5 style="margin-top: 0;">'.$post->post_title.'</h5>
			<div>('.$property_area.')</div>
			<div>'.get_price_format( $post->ID ).'</div>';
	
	get_near_stations( $post->ID );
	
	$property_layout = get_field( 'property_layout',  $post->ID );
	if( !empty( $property_layout['label'] ) ) $property_layout = $property_layout['label'];
	$property_size = get_field( 'property_size', $post->ID );
	
	echo '<div>'.$property_layout.' / '.$property_size.'㎡</div>';
	echo '</div>
		</div>';
}


#コンタクトフォーム＞物件データ一覧用
function set_view_contact_property_list( $request ){
	$args = array(
		'post__in' => $request,
		'post_type' => 'property'
	);
	$get_posts = get_posts( $args );
	
	$offset = ( count($get_posts)==1 ) ? 'offset-s3 ' : null ;
	
	foreach( $get_posts as $key => $value ){
		
		$property_area = wp_get_post_terms( $value->ID, 'area');
		if(!empty($property_area)){
			$property_area = $property_area[0]->name;
		}
		
		echo '<div class="col s6 '.$offset.'card inquiry_property_wrap">
				<div class="card-content inquiry_property">
				<h5 style="margin-top: 0;">'.$value->post_title.'</h5>
				<div>('.$property_area.')</div>
				<div>'.get_price_format( $value->ID ).'</div>';
		
		get_near_stations( $value->ID );
		
		$property_layout = get_field( 'property_layout',  $value->ID );
		if( !empty( $property_layout['label'] ) ) $property_layout = $property_layout['label'];
		$property_size = get_field( 'property_size', $value->ID );
		
		echo '<div>'.$property_layout.' / '.$property_size.'㎡</div>';
		echo '</div>
			</div>';
	}
}


#最寄り駅
function get_near_stations( $post_id ){
	if( have_rows( 'near_stations', $post_id ) ){
		$i = 0;
	    while ( have_rows( 'near_stations', $post_id ) ) : the_row();
	        $near_station = get_sub_field('station');
	        if( !empty( $near_station->name ) ){
		        echo "<div>".$near_station->name." ";
		        $minutes_from_station = get_sub_field( 'minutes_from_station' );
		        echo articnet_echo_string( 'minutes_from_station' )." ";
		        echo $minutes_from_station." ";
		        echo articnet_echo_string( 'minutes_symbol' );
		        echo "</div>";
		        if( $i==0 ) break;
		        $i++;
		    }
	    endwhile;
	}
}


#アーカイブ＞サムネイル
function get_archive_image( $post_id ){
	$get_archive_image = NULL;
	if( get_post_type()=='area_info' ){
		$header_bg_image = get_field( "header_bg_image", get_the_ID() );
		$get_archive_image = $header_bg_image['url'];
	}else{
		if( has_post_thumbnail( $post_id ) ){
			$get_archive_image = get_the_post_thumbnail_url( $post_id, 'large' );
		}
	}
	$get_archive_image = set_resize_image( $get_archive_image );
	return $get_archive_image;
}


#ログアウト＞トップページリダイレクト
function redirect_logout_page(){
  $url = site_url('', 'http');
  wp_safe_redirect($url);
  exit();
}
add_action('wp_logout','redirect_logout_page');



?>