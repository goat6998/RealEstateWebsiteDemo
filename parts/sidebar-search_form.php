
<form action="/property_list" method="get" enctype="multipart/form-data" id="search" role="search">
	
	<div class="col s12 search_form_wrap">
		
<!--物件タイプ-->
    	<div class="col s12 form_section checkbox_property_type">
			<?= set_form_property_type() ?>
	    </div>
	    		
<!--沿線-->
	    <div class="col s12 form_section form_checkbox_station">
			<div align="left"><i class="material-icons left">train</i><?= articnet_echo_string('train_line'); ?></div>
			<?= set_form_station() ?>
			<?= get_search_query_home('station'); ?>
		</div>
		
<!--エリア-->
	    <div class="col s12 form_section form_checkbox_area">
			<div align="left"><i class="material-icons left">place</i><? articnet_echo_string('area'); ?></div>
			<?= set_form_area() ?>
			<?= get_search_query_home('area'); ?>
		</div>
		
<!--家賃、価格-->
		<div class="col s12 form_section select_price">
<?php
$set_price_rental = set_price_rental();
$set_price_real_estate = set_price_real_estate();
$icon_price = '<i class="fas fa-yen-sign bottom" aria-hidden="true"></i> ';
?>
			<div class="price_title_rentals" align="left"><?= $icon_price ?><?= articnet_echo_string('rent') ?></div>
			<div class="price_title_real_estate" align="left"><?= $icon_price ?><?= articnet_echo_string('price') ?></div>
<!--安値-->
			<div class="col s6 price_low_wrap">
				<div class="price_low_rentals"><?= set_form_select('price_low', 'for_rent_low', $set_price_rental ) ?></div>
				<div class="price_low_real_estate"><?= set_form_select('price_low', 'price_low', $set_price_real_estate ) ?></div>
			</div>

<!--高値-->
	    	<div class="col s6 price_high_wrap">
				<div class="price_high_rentals"><?= set_form_select('price_high', 'for_rent_high', $set_price_rental ) ?></div>
				<div class="price_high_real_estate"><?= set_form_select('price_high', 'price_high', $set_price_real_estate ) ?></div>
			</div>
		</div>

<!--間取り-->
    	<div class="col s12 form_section form_checkbox floor_plan">
			<div class="search_title_floor_plan" align="left"><i class="material-icons center bottom">apps</i><?= articnet_echo_string('floor_plan'); ?></div>
			<div class="checkbox_floor_plan_wrap form_checkbox">
<?php
$field_obj = get_field_object('field_58b682978e86f');
foreach( $field_obj["choices"] as $key => $value ):
?>
				<label>
					<input type="checkbox" name="property_layout[]" value="<?= $key ?>"<?php
if( !empty( get_query_var('property_layout') ) ){
	if( is_array( get_query_var('property_layout') ) ){
		if( in_array( $key, get_query_var('property_layout') )==true ){
			echo ' checked';
		}
	}else if( preg_match('/'.$key.'/', get_query_var('property_layout') )==true ){
		echo ' checked';
	}
}
?>>
					<span><?= $value ?></span>
				</label>
<?php endforeach; ?>
			</div>
	    </div>
		
<!--面積検索値-->
    	<div class="col s12 form_section property_size_wrap">
			<div align="left"><i class="material-icons left">zoom_out_map</i><?= articnet_echo_string('property_size'); ?></div>
			<!--小面積プルダウン-->
			<div class="col s6 property_size_low"><?= set_form_select('property_size_low', 'property_size_low', set_array_property_size() ); ?></div>
			<!--大面積プルダウン-->
			<div class="col s6 property_size_high"><?= set_form_select('property_size_high', 'property_size_high', set_array_property_size() ); ?></div>
	    </div>

<!--カテゴリー-->
		<div class="col s12 form_section property_category_wrap" align="center">
			<div align="left"><i class="material-icons left">store</i><?= articnet_echo_string('property_type'); ?></div>
			<div class="form_checkbox checkbox_property_category">
<?php
$get_property_category = get_my_category('property_category');
foreach( $get_property_category as $key => $value ):
?>
				<label>
					<input type="checkbox" name="property_category[]" value="<?= $value->slug ?>"<?php
if( !empty( get_query_var('property_category') ) ){
if( is_array( get_query_var('property_category') ) ){
	if( in_array( $value->slug, get_query_var('property_category') ) ){
		echo ' checked';
	}
}else{
	if( preg_match( '/'.$value->slug.'/', get_query_var('property_category') ) ){
		echo ' checked';
	}
}
}
?>>
					<span class="<?= qtranxf_getLanguage(); ?>"><?= $value->name ?></span>
				</label>
<?php endforeach; ?>
			</div>
		</div>

<!--設備-->
		<div class="col s12 form_section checkbox_facility_wrap" align="center">
			<div align="left"><i class="fa fa-bath"></i> <?= articnet_echo_string('facilities'); ?></div>
			<div class="form_checkbox checkbox_facility">
<?php
$set_array_facility = set_array_facility();
foreach( $set_array_facility as $key => $value ):
?>
				<label>
					<input type="checkbox" name="facility[]" value="<?=$key?>" <?php if( !empty( get_query_var('facility') ) && in_array( $key, get_query_var('facility') )==true ) echo 'checked';?>>
					<span class="<?= qtranxf_getLanguage(); ?>"><?= articnet_echo_string($value); ?></span>
				</label>
<?php endforeach; ?>
			</div>
		</div>
		
<!--フリーワード-->
		<div class="col s12 form_section property_name_search">
			<div align="left"><i class="material-icons left">text_fields</i><?= articnet_echo_string('property_name_search'); ?></div>
			<div class="input-field col s12 white property_name_search_wrap">
				<i class="material-icons prefix">search</i>
				<input type="text" class="property_name white" name="property_name" value="<?= get_query_var('property_name') ?>">
			</div>
		</div>
			
		<div class="col s12 btn_submit_wrap" align="center">
			<button class="btn waves-effect waves-light submit btn_search" type="submit"><?= articnet_echo_string('search'); ?>
				<i class="material-icons right">search</i>
			</button>
	    </div>
		
	</div>
</form>

