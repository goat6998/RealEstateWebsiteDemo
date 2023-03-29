<form action="/property_list" method="get" enctype="multipart/form-data" id="home_search" role="search" aria-label="物件データ検索フォーム">
	
	<div class="row search_form_home">
		<div class="col s4 offset-s4 right">

				<div class="col s12 m12">
<?php
$getPropertyType = get_parent_child('property_type');
echo '<select name="property_type" class="search_property_type">';
foreach( $getPropertyType['parent'] as $key => $value ){
	echo '<option value="'.$value->slug.'">'.$value->name.'('.$value->count.')</option>';
}
echo '</select>';
?>
				</div>
				
			    <div class="col s12 m6 form_select_area_pc"></div>
			    <div class="col s12 m6 form_select_station_pc"></div>

<?php
$set_price_rental = set_price_rental();
$set_price_real_estate = set_price_real_estate();
?>
				<div class="col s12 m6 form_select_price">
					<div class="front_price_low_rentals"><?= set_form_select('price_low', 'for_rent_low', $set_price_rental ); ?></div>
					<div class="front_price_low_real_estate"><?= set_form_select('price_low', 'price_low', $set_price_real_estate ); ?></div>
				</div>

	<!--高値-->
		    	<div class="col s12 m6 form_select_price">
					<div class="front_price_high_rentals"><?= set_form_select('price_high', 'for_rent_high', $set_price_rental ); ?></div>
					<div class="front_price_high_real_estate"><?= set_form_select('price_high', 'price_high', $set_price_real_estate ); ?></div>
				</div>
				
		    	<div class="col s12 remodal_property_layout_wrap">
		    		<div class="floor_plan_all"><?= articnet_echo_string('floor_plan'); ?><?= articnet_echo_string('all'); ?></div>
		    		<a data-remodal-target="modal-property_layout" class="btn_remodal_property_layout"></a>
		    		<div data-remodal-id="modal-property_layout" data-remodal-options="hashTracking: false" class="remodal remodal_property_layout">
		    			<div class="search_property_layout_remodal_title"><?= articnet_echo_string('floor_plan'); ?></div>
						<?php $field_obj = get_field_object('field_58b682978e86f'); ?>
						<?php foreach( $field_obj["choices"] as $key => $value ): ?>
						<div class="checkbox_property_layout">
							<label>
								<input type="checkbox" name="property_layout" value="<?= $key ?>">
								<span><?= $value ?></span>
							</label>
						</div>
						<?php endforeach; ?>
						<div class="modal-footer">
							<div align="center">
								<a class="waves-effect waves-light btn bgwhite blue-text reset_property_layout"><?= articnet_echo_string('reset'); ?></a>
							</div>
							<div align="center">
								<a data-remodal-action="confirm" class="remodal-confirm waves-effect waves-light btn teal white-text"><?= articnet_echo_string('decision'); ?></a>
							</div>
						</div>
				    </div>
				    <div class="send_property_layout">
				    </div>
			    </div>
			
			<div class="input-field col s12 m12 property_name_search_wrap">
				<input type="text" class="validate property_name_search" name="property_name" placeholder="<?=articnet_echo_string('property_name_search')?>">
			</div>
				
			<div class="col s12 m12" align="center">
				<button class="btn waves-effect waves-light submit btn_search" type="submit"><?= articnet_echo_string('search') ?>
					<i class="material-icons right">search</i>
				</button>
		    </div>
		</div>
	</div>
</form>