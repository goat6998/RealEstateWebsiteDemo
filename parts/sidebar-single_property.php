<?php
$get_the_terms = get_the_terms( get_the_ID(), 'property_type' );
?>
<section>
	<h2 class="sub_title sidebar_title_floorplan"><i class="material-icons center bottom">apps</i><?php articnet_echo_string('floor_plan'); ?></h2>
<?php 
$floorp = get_field('floorplan');
if( !empty( $floorp ) ){
	$floorp['url'] = set_resize_image( $floorp['url'], 376 );
	echo '<div align="center"><img src="'.$floorp['url'].'" alt="'.$floorp['alt'].'" /></div>';
}
?>
</section>

<section>
	<h2 class="sub_title sidebar_title_property_details"><i class="fa fa-check-square-o bottom" aria-hidden="true"></i><?php articnet_echo_string('property_details'); ?></h2>
	<table class="property_details">
		<tbody>
			<tr>
				<td>
<?php
if( preg_match('/rent/', $get_the_terms[0]->slug ) ){
	echo articnet_echo_string('monthly_rent');
}else{
	echo articnet_echo_string('price');
}
?>
				</td>
				<td><?= get_field_price('price', true) ?></td>
			</tr>

<?php if( preg_match('/long/', $get_the_terms[0]->slug ) ): ?>
			<tr>
				<td><?php articnet_echo_string('maintenance_fee'); ?></td>
				<td><?= get_field_price('maintenance_fee', true) ?></td>
			</tr>

			<tr>
				<td><?php articnet_echo_string('deposit'); ?></td>
				<td><?= get_field_price('deposit', true) ?></td>
			</tr>

			<tr>
				<td><?php articnet_echo_string('key_money'); ?></td>
				<td><?= get_field_price('key_money', true) ?></td>
			</tr>
<?php endif; ?>

<?php if( preg_match('/short/', $get_the_terms[0]->slug ) ): ?>
			<tr>
				<td><?php articnet_echo_string('weekly_price'); ?></td>
				<td><?= get_field_price('weekly_price', true) ?></td>
			</tr>

			<tr>
				<td><?php articnet_echo_string('deposit'); ?></td>
				<td><?= get_field_price('deposit_short', true) ?></td>
			</tr>

			<tr>
				<td><?php articnet_echo_string('minimum_stay'); ?></td>
				<td><?= get_field_price('minimum_stay') ?></td>
			</tr>
<?php endif; ?>

			<tr>
				<td><?php articnet_echo_string('property_layout'); ?></td>
				<td>
<?php
$property_layout = get_field('property_layout');
echo $property_layout['label'];
?>
				</td>
			</tr>

			<tr>
				<td><?php articnet_echo_string('floor'); ?></td>
				<td>
<?php
$floor = get_field('floor');
if( !empty( $floor ) ){
	echo $floor;
	articnet_echo_string('floor_symbol');

	$floor_totals = get_field('floor_totals');
	if( !empty( $floor_totals ) ){
		echo ' / ' . get_field('floor_totals');
	articnet_echo_string('floor_symbol');
	}
}else{
	echo '-';
}
?>
				</td>
			</tr>

			<tr>
				<td><?php articnet_echo_string('property_size'); ?></td>
				<td>
<?php
$property_size = get_field('property_size');
if( empty( $property_size ) ){
	echo '-';
}else{
	echo $property_size.'㎡';
}
?>
				</td>
			</tr>

<?php if( preg_match('/buy/', $get_the_terms[0]->slug ) ): ?>
			<tr>
				<td><?php articnet_echo_string('land_size'); ?></td>
				<td>
<?php
if( empty( $land_size = get_field('land_size') ) ){
	echo '-';
}else{
	echo $land_size.'㎡';
}
?>
				</td>
			</tr>

			<tr>
				<td><?php articnet_echo_string('land_rights'); ?></td>
				<td>
<?php
$land_rights = get_field('land_rights');
if( empty( $land_rights ) ) $land_rights = '-';
echo $land_rights;
?>
				</td>
			</tr>
<?php endif; ?>

<?php if( preg_match('/investment/', $get_the_terms[0]->slug ) ): ?>
			<tr>
				<td><?php articnet_echo_string('occupancy'); ?></td>
				<td>
<?php
$occupancy = get_field('occupancy');
if( empty( $occupancy ) ) $occupancy = '-';
echo $occupancy;
?>
				</td>
			</tr>

			<tr>
				<td><?php articnet_echo_string('yearly_yield'); ?></td>
				<td>
<?php
if( empty( $yearly_yield = get_field('yearly_yield') ) ){
	echo '-';
}else{
	echo $yearly_yield.'%';
}
?>
				</td>
			</tr>

			<tr>
				<td><?php articnet_echo_string('net_yield'); ?></td>
				<td>
<?php
if( empty( $net_yield = get_field('net_yield') ) ){
	echo '-';
}else{
	echo $net_yield.'%';
}
?>
				</td>
			</tr>

			<tr>
				<td><?php articnet_echo_string('rent_investment'); ?></td>
				<td><?= get_field_price('rent_investment', true) ?></td>
			</tr>
<?php endif; ?>

<?php if( preg_match('/buy/', $get_the_terms[0]->slug ) ): ?>
			<tr>
				<td><?php articnet_echo_string('maintenance_fee'); ?></td>
				<td><?= get_field_price('maintenance_fee_buy', true) ?></td>
			</tr>

			<tr>
				<td><?php articnet_echo_string('reserve_fund'); ?></td>
				<td><?= get_field_price('reserve_fund_buy', true) ?></td>
			</tr>
<?php endif; ?>

			<tr>
				<td><?php articnet_echo_string('year_built'); ?></td>
				<td>
<?php
$year_built = get_field('year_built');
$year_built .= get_field_articnet('year_of_construction', false);
if( empty( $year_built ) ) $year_built = '-';
echo $year_built;
?>
				</td>
			</tr>
		</table>
		<table class="property_details2">
			<tr>
				<td><?php articnet_echo_string('nearest_station'); ?></td>
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
		</table>
	
<?php
$city = NULL;
$prefecture = NULL;
$area_terms = wp_get_post_terms( get_the_ID(), 'area');
if( !empty( $area_terms ) ){
	$tmp_terms_array = array();
	$area_term = $area_terms[0];
	$city = $area_term->name;
	while ( ( !empty( $area_term ) ) && ( $area_term->parent != 0 ) ){
		$area_term = get_term( $area_term->parent, 'area' );
		if( !empty( $area_term ) ){
			$tmp_terms_array[]= $area_term->name;
		}
	}
	
	if( !empty( $tmp_terms_array ) ){
		for( $i=0; $i<sizeof($tmp_terms_array)-1; $i++) { 
			$city = $tmp_terms_array[$i] . ', ' . $city;
		}
		$prefecture = $tmp_terms_array[sizeof($tmp_terms_array)-1];
	}
}
?>
		<table class="property_details3">
			<tr>
				<td><?php articnet_echo_string('prefecture'); ?></td>
				<td><?php echo $prefecture; ?></td>
			</tr>
			<tr>
				<td><?php articnet_echo_string('city'); ?></td>
				<td><?php echo $city; ?></td>
			</tr>
		</table>
		<table class="property_details4">
			<tr>
				<td><?php articnet_echo_string('address'); ?></td>
				<td>
<?php
$address = get_field('address');
if( empty( $address ) ) $address = '-';
echo $address;
?>
				</td>
			</tr>
		</table>
						
</section>

<section>
	<div class="property_print_pc">
		<div class="property_print_wrap">
			<h2 class="sub_title sidebar_title_floorplan"><i class="material-icons center bottom">print</i><?php articnet_echo_string('property_printing'); ?></h2>
			<div align="center">
				<p><a href="<?= get_print_url() ?>" class="btn get_property_print"><i class="material-icons center bottom">print</i> <?php articnet_echo_string('property_printing'); ?></a><div class="set_property_print"></div></p>
			</div>
		</div>
	</div>
</section>

