<!doctype html>
<html <?php language_attributes() ?>>

<head>
	<meta charset="<?= bloginfo('charset') ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#006a6c">
	<meta name="description" content="<?= set_page_description() ?>">
	
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# <?= set_meta_og_type() ?>: http://ogp.me/ns/website#">
	<meta property="og:locale" content="<?= get_my_locale() ?>">
	<meta property="og:type" content="<?= set_meta_og_type() ?>">
	<meta property="og:site_name" content="<?= bloginfo('name') ?>">
	<meta property="og:title" content="<?= set_page_title() ?>">
	<meta property="og:url" content="<?= set_page_url() ?>">
	<meta property="og:description" content="<?= set_page_description() ?>">
	<meta property="og:image" content="<?= set_page_image() ?>">
	
    <title><?= set_page_title() ?></title>
    <link rel="apple-touch-icon" sizes="76x76" href="<?= get_site_icon_url() ?>">
    <link rel="icon" type="image/png" href="<?= get_site_icon_url() ?>" sizes="32x32">
    <link rel="icon" type="image/png" href="<?= get_site_icon_url() ?>" sizes="16x16">
    <link rel="manifest" href="<?= get_favicon_url() ?>/manifest.json">
    <link rel="mask-icon" href="<?= get_favicon_url() ?>/safari-pinned-tab.svg" color="#5bbad5">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link href="//www.google-analytics.com" rel="dns-prefetch">
	
	<?php wp_head() ?>
		
<!--//エリア紹介-->
<?php if( is_single() && get_post_type()=="area_info" ): ?>
<style>
<?= get_field("custom_titlebar") ?>
.languages_position{
	position: relative;
}
.languages-div{
	position: absolute;
	top: .5rem;
	right: .5rem;
	margin: 0;
}
.page_contents{
	padding-top: 1rem !important;
}
</style>
<?php endif; ?>
<?php set_view_first_login() ?>
</head>
<body>


	<nav class="nav_sptab white black-text" role="navigation">
		<div class="nav-wrapper container header_sp">
			<a id="logo-container" href="<?= home_url('/') ?>" class="brand-logo"><img src="<?= get_the_logo_url(); ?>" alt="Logo" class="logo_sp"></a>
			<ul class="header_icons">
				<?= get_select_lang_sp() ?>
				<?php if( is_user_logged_in() ): ?>
				
				<?php if( is_page('profile') ): ?>
				<li class="active"><a href="<?= home_url('/profile') ?>"><i class="material-icons teal-text">account_circle</i></a></li>
				<?php else: ?>
				<li><a href="<?= home_url('/profile') ?>"><i class="material-icons">account_circle</i></a></li>
				<?php endif; ?>
				
				<?php else: ?>
				<li><a href="<?= home_url('/login') ?>"><i class="fas fa-sign-in-alt"></i></a></li>
				<?php endif; ?>
				
				<?php if( is_page('favorite') ): ?>
				<li class="active"><a href="<?= home_url('/favorite') ?>"><i class="material-icons middle teal-text">favorite</i></a></li>
				<?php else: ?>
				<li><a href="<?= home_url('/favorite') ?>"><i class="material-icons middle">favorite_border</i></a></li>
				<?php endif; ?>
				
			</ul>
			<a href="#" data-target="nav-mobile" class="side_menu_btn sidenav-trigger"><i class="material-icons">menu</i></a>
			<ul id="nav-mobile" class="sidenav side_menu">
				<?php if( is_user_logged_in() ): ?>
				<li><a class="member_login_sp"><?=articnet_echo_string('howdy')?><?= get_full_name() ?><?=articnet_echo_string('mr')?><i class="material-icons right teal-text">account_circle</i></a></li>
				
				<?php if( is_page('profile') ): ?>
				<li class="active"><a class="teal-text"><i class="material-icons teal-text">account_circle</i><?=articnet_echo_string('registration_information')?></a></li>
				<?php else: ?>
				<li><a href="<?= home_url('/profile') ?>"><i class="material-icons">account_circle</i><?=articnet_echo_string('registration_information')?></a></li>
				<?php endif; ?>
				
				<?php if( is_page('favorite') ): ?>
				<li class="active"><a class="teal-text"><i class="material-icons teal-text">favorite</i><?=articnet_echo_string('favorite')?></a></li>
				<?php else: ?>
				<li><a href="<?= home_url('/favorite') ?>"><i class="material-icons">favorite_border</i><?=articnet_echo_string('favorite')?></a></li>
				<?php endif; ?>
				<?php else: ?>
				<li><a href="<?= home_url('/login') ?>"><i class="fas fa-sign-in-alt"></i><?= articnet_echo_string('login') ?></a></li>
				<?php endif; ?>
<?php
if ( ( $locations = get_nav_menu_locations() ) && isset( $locations['sp_slide_menu'] ) ) {
	$menu = wp_get_nav_menu_object( $locations['sp_slide_menu'] );
	$menu_items = wp_get_nav_menu_items( $menu->term_id );
	
	if( !empty( $_REQUEST["property_type"] ) ){
		if( is_array( $_REQUEST["property_type"] ) && count( $_REQUEST["property_type"] )==1 ){
			$property_type = $_REQUEST["property_type"][0];
		}else{
			$property_type = $_REQUEST["property_type"];
		}
	}
	
	foreach ( $menu_items as $key => $value ):
?>
<?php if( !empty( $property_type ) && preg_match('/'.$property_type.'/', $value->url ) ): ?>
				<li class="active"><a><?= get_menu_icon_sp()[ $key ] ?><?= $value->title ?></a></li>
<? else: ?>
				<li><a href="<?= $value->url ?>"><?php if( !empty( get_menu_icon_sp()[ $key ] ) ): ?><?= get_menu_icon_sp()[ $key ] ?><?php endif; ?><?= $value->title ?></a></li>
<?php endif; ?>
<?php
	endforeach;
}
?>
				<?php if( is_user_logged_in() ): ?>
				<li><a href="<?= wp_logout_url(get_permalink()) ?>"><i class="small material-icons">exit_to_app</i><?= articnet_echo_string('logout') ?></a></li>
				<?php endif; ?>
			</ul>
		</div>
	</nav>


<header role="banner">
	
<?php if( is_single() && get_post_type()=="area_info" ): ?>
<?= set_area_info_header() ?>
<?php else: ?>
	    <div class="row container_header">
	    	
	        <div class="col s3 header_left">
	            <a href="<?php echo home_url() ?>" class="logo_link">
	                <img src="<?= get_the_logo_url(); ?>" alt="Logo" class="logo">
	            </a>
	        </div>
	        
	        <div class="col s9 header_right" align="right">
	        	
				<div class="col s12 header_nav">
					<div>
<?php
echo '<ul>';
$menu_name = 'property-search-menu';
if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
	$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
	$menu_items = wp_get_nav_menu_items($menu->term_id);
	foreach ( (array) $menu_items as $menu_item ) {
		echo '<li><a href="' . $menu_item->url . '">' . $menu_item->title . '</a></li>';
	}
}
echo '</ul>';
?>
					</div>
	
					<div class="login_area" align="right">
						<?= set_user_menu(); ?>
					</div>
						
				</div>
					
	            <div class="col s12 header_right_bottom">
	            	
	        		<div align="right">
	        		<?= get_select_lang() ?>
	        		</div>
	            	
	            	<div class="header_contact_phone" align="right">
		                <a href="tel:0666269305"><i class="material-icons middle">local_phone</i>06-6626-9305</a>
	                </div>
	            	
					<div class="header_contact_messenger">
						<a href="<?= set_messanger_url(); ?>" target="_blank"><img src="<?= get_theme_file_uri('/layout/img/messenger.png') ?>" class="icon_messenger"><?=articnet_echo_string('inquire_by_messenger')?></a>
					</div>
	            	
                	<div class="header_contact_line">
						<a href="https://lin.ee/0Dopnjq" target="_blank"><img border="0"
	src="<?= get_theme_file_uri('/layout/img/line.png'); ?>" class="icon_line"><?=articnet_echo_string('inquire_by_line')?></a>
					</div>
					
				</div>
				
			</div>
<?php endif; ?>

</header>
<!-- header -->

