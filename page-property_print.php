<?php
/*
Template Name:物件詳細印刷ページ
*/
?>
<?php
if( !empty( $_REQUEST['property_id'] ) ){
	$post = get_post( $_REQUEST['property_id'] );
	
	if( have_rows( 'near_stations', get_the_ID() ) ){
		$i = 0;
	    while ( have_rows( 'near_stations', get_the_ID() ) ) : the_row();
	        $near_station = get_sub_field('station');
	        if( !empty( $near_station->name ) ){
	        	#最寄り駅の路線
	        	$station = get_term( $near_station->parent, 'station' );
	        	#最寄り駅
	        	$near_station_name = preg_replace( '/\(.*?\)/', '', $near_station->name );
		        $minutes_from_station = get_sub_field( 'minutes_from_station' );
		        if( $i==0 ) break;
		        $i++;
		    }
	    endwhile;
	    
	}
	
	$get_the_title = get_the_title();
	
	$address = get_field('address', get_the_ID() );
	$price = get_field( 'price',  get_the_ID() );
	
	$catchphrase = get_field( 'catchphrase',  get_the_ID() );
	if( qtranxf_getLanguage()=='en' ){
		$length = 51;
	}else{
		$length = 50;
	}
	$catchphrase = get_mb_strimwidth( $catchphrase, $length );
	
	$maintenance_fee = get_field( 'maintenance_fee',  get_the_ID() );
	if( empty( $maintenance_fee ) ) $maintenance_fee = 0;
	
	$deposit = get_field( 'deposit',  get_the_ID() );
	if( empty( $deposit ) ) $deposit = 0;
	
	$key_money = get_field( 'key_money',  get_the_ID() );
	if( empty( $key_money ) ) $key_money = 0;
	
	$property_layout = get_field('property_layout',  get_the_ID());
	
	$property_size = get_field('property_size');
	if( empty( $property_size ) ){
		$property_size = '-';
	}else{
		$property_size = $property_size.'㎡';
	}
	
	$year_built = get_field('year_built');
	if( empty( $year_built ) ) $year_built = '-';
	
	$property_qr = get_template_directory_uri().'/module/qr/php/qr_img.php?d='.get_permalink( get_the_ID() );
	
	$floorplan = get_field('floorplan');
	
}

?>
<!DOCTYPE html>
<html lang="<?= qtranxf_getLanguage(); ?>">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="<?= get_theme_file_uri('/layout/css/property_print.css'); ?>">
<link rel="stylesheet" type="text/css" href="<?= get_theme_file_uri('/layout/fontawesome/css/all.css'); ?>">
<script src="<?= get_theme_file_uri('/layout/js/jquery-3.5.1.min.js'); ?>"></script>
<style>
.catchphrase_wrap{
	background-image: url('<?= get_theme_file_uri('/layout/img/catchphrase_bg.jpg') ?>');
	background-size: cover;
	background-position: center center;
	background-repeat:no-repeat;
}
<?php if( qtranxf_getLanguage()=='kr' ): ?>
.header_left{
	line-height: 45px;
}
.address{
    line-height: 28px;
}
.station {
    line-height: 22px;
}
.catchphrase{
	line-height: 16px;
}
.property_category{
	padding-top: 5px;
}
.initial_cost th, .initial_cost td{
	padding: 10px 5px 8px 5px;
}
<?php endif; ?>

<?php
$floorplan_height = null;
if( !empty( $floorplan['url'] ) ){
	$size = getimagesize( $floorplan['url'] );
	if( 270 > $size[1] ){
		$floorplan_height = ( 270 - $size[1] ) / 2;
		$floorplan_height ='<div style="height:'.$floorplan_height.'px;"></div>';
	}
}
?>
</style>
</head>
<body>

<section class="sheet">
	<div class="header_wrap">
		<table class="header">
			<tr>
				<td class="header_left" valign="top">
					<div class="property_name"><?= the_title(); ?></div>
					<div class="address"><i class="fas fa-map-marker-alt"></i><?= $address ?></div>
				</td>
				<td class="header_right" valign="top">
					<div class="station">
						<div class="station_title"><img src="<?= get_theme_file_uri('/layout/img/train_white_48x48.png'); ?>" width="24"><?= $station->name ?></div>
						<div><?= $near_station_name ?><?= articnet_echo_string( 'station' ); ?></div>
						<div><?= articnet_echo_string( 'minutes_from_station' )." "; ?><?= $minutes_from_station ?> <?= articnet_echo_string( 'minutes_symbol' ); ?></div>
					</div>
				</td>
			</tr>
		</table>
	</div>
	
	<div class="body_wrap">
		<div class="body_left">

			<div class="catchphrase_wrap"><table><tr><td style="width: 36px;padding-left: 15px;"><i class="far fa-comment-dots" aria-hidden="true"></i></td><td class="catchphrase"><?= $catchphrase ?></td></tr></table></div>
			
			<table>
				<tr>
					<td>
						<div class="body_left_top">
							<div class="body_left_top_left">
				
								<table class="initial_cost">
									<tr>
										<th><?= articnet_echo_string( 'rent' ); ?></th>
										<td><?= number_format( $price ) ?> <?= articnet_echo_string( 'yen' ); ?></td>
									</tr>
									<tr>
										<th><div class="maintenance_fee_title"><?= articnet_echo_string('maintenance_fee'); ?></div></th>
										<td><?= number_format( $maintenance_fee ) ?> <?= articnet_echo_string( 'yen' ); ?></td>
									</tr>
									<tr>
										<th><?= articnet_echo_string('deposit'); ?></th>
										<td><?= number_format( $deposit ) ?> <?= articnet_echo_string( 'yen' ); ?></td>
									</tr>
									<tr>
										<th><?= articnet_echo_string('key_money'); ?></th>
										<td><?= number_format( $key_money ) ?> <?= articnet_echo_string( 'yen' ); ?></td>
									</tr>
									<tr>
										<th><?= articnet_echo_string('floor_plan'); ?></th>
										<td><?= $property_layout['label'] ?></td>
									</tr>
									<tr>
										<th><?= articnet_echo_string('size'); ?></th>
										<td><?= $property_size ?></td>
									</tr>
									<tr>
										<th><?= articnet_echo_string('year_built'); ?></th>
										<td><div class="year_built"><?= $year_built ?></div></td>
									</tr>
								</table>
				
							</div>
							<div class="body_left_top_right">
								
								<div class="facility_icon_wrap">
									<table>
									<?php
									$icons_folder = get_template_directory_uri().'/layout/img/single-property-icons/';
									$set_array_facility = set_array_facility();
									$i = 0;
									foreach( $set_array_facility as $key => $value ):
									$i = $i + 1;
									?>
									<?php if( $i==1 || $i==5 || $i==9 ) echo '<tr>'; ?>
									<td><div class="facility_list"><img title="<?= articnet_echo_string( $value ); ?>" src="<?php echo ( !empty( get_field($key) ) ) ? $icons_folder.$key.'_on.png' : $icons_folder.$key.'.png' ; ?>" class="facility_icon" width="37" height="37"></div></td>
									<?php if( $i==4 || $i==8 || $i==12 ) echo '</tr>'; ?>
									<?php endforeach; ?>
									</table>
								</div>
								
								<div class="property_category_wrap">
									<table><tr>
									<?php
									$property_category = wp_get_object_terms( get_the_ID(), 'property_category');
									foreach( $property_category as $key => $value ){
										$num = $key + 1;
										echo '<td><div class="property_category">'.$value->name.'</div></td>';
										if( $num % 2 == 0 ) echo '</tr><tr>';
									}
									?>
									</tr></table>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="body_left_bottom">
							<div class="body_left_bottom_left">
										
								<div class="management_company">
									<div class="logo" align="center"><img src="<?= get_the_logo_url(); ?>"></div>
									
									
									<div class="management_company_text">
										<div class="company_name" align="center"><?= articnet_echo_string('company_name'); ?></div>
										<div class="phone" align="center"><?= get_site_info()['tel'] ?></div>
										<div class="email" align="center"><?= get_site_info()['email'] ?></div>
										<div class="property_qr" align="center"><img src="<?= $property_qr ?>"></div>
									</div>

									

								</div>
									
							</div>
							<div class="body_left_bottom_right">
								
								<div class="floorplan">
									<?= $floorplan_height; ?>
									<table align="center"><tr><td valign="middle">
								<?php
								if( !empty( $floorplan['url'] ) ){
									$floorplan['url'] = set_resize_image( $floorplan['url'] );
									echo '<img src="'.$floorplan['url'].'">';
								}
								?>
									</td></tr></table>
								</div>
								
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
		
		<div class="body_right">
			
<?php
$gallery = get_field('gallery');
unset( $gallery[1] );
$gallery = array_values( $gallery );
foreach( $gallery as $key => $value ){
	$num = $key + 1;
	$thumbnail_url = set_resize_image( $value['sizes']['large'], 435 );
	if( $num==1 ){
		echo '<table><tr><td>';
		echo '<div class="property_main_image"><img src="'.$thumbnail_url.'"></div>';
		echo '</td></tr>';
	}

	if( $num==2 ){
		echo '<tr><td>';
		echo '<table><tr>';
	}

	if( $num >= 2 ){
		echo '<td><div class="property_list_image property_list_image'.$num.'"><img src="'.$thumbnail_url.'"></div></td>';
	}

	if( $num==3 ) echo '</tr><tr>';

	if( $num==5 ){
		echo '</table></td></tr></table>';
		break;
	}
}
?>
			
		</div>

	</div>

</section>


</body>
</html>