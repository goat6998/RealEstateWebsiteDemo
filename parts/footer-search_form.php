<?php

if( !empty( get_query_swap('station') ) ){
	$get_query_swap['station'] = get_query_swap('station');
}else{
	$get_query_swap['station'] = 0;
}

if( !empty( get_query_swap('area') ) ){
	$get_query_swap['area'] = get_query_swap('area');
}else{
	$get_query_swap['area'] = 0;
}

?>

<script>
jQuery(function($){
	
	var title_all = '<?= get_field_articnet('all'); ?>';
	
	//沿線＞チェック要素＞タイトル表示
	var title_default_station = '<?= get_field_articnet('train_line') ?>';
	title_all_station = set_form_title_all( title_default_station, title_all );
	var element_title_station = '.search_title_station';
	//親沿線＞チェックアクション
	set_checkbox_parents( $, '.parent_station', '.checkbox_wrap_station' );
	//子沿線＞チェックアクション
	set_checkbox_station($);
	//要素クリック後タイトル変更
	set_form_title( $, element_title_station, title_all_station, '.parent_station, .child_station', '.checkbox_main_wrap_station', '.set_checkbox_station_home' );
	//初期値
	var get_title_station = '<?= $get_query_swap['station'] ?>';
	search_title_station = get_search_title( title_all_station, get_title_station );
	set_search_title( $, element_title_station, search_title_station );
	set_checkbox_reset( $, '.reset_station', '.checkbox_main_wrap_station', element_title_station, title_all_station, '.get_home_station');
	
	//エリア＞チェック要素＞タイトル表示
	var get_title_area = '<?= json_encode( $get_query_swap['area'] ) ?>';
	var title_default_area = '<?= get_field_articnet('area') ?>';
	title_all_area = set_form_title_all( title_default_area, title_all );
	search_title_area = get_search_title( title_all_area, get_title_area );
	element_title_area = '.search_title_area';
	check_elements = '.parent_area, .child_area, .child_sub_area';
	//親エリア＞チェックアクション
	set_checkbox_parents( $, '.parent_area', '.checkbox_wrap_in_area' );
	//子エリア＞チェックアクション＞孫あり
	set_checkbox_parents( $, '.child_area', '.child_wrap_area' );
	//孫エリア＞チェックアクション＞孫なし
	set_check_child($);
	//孫エリア＞チェックアクション
	set_check_gchild($);
	//要素クリック後タイトル変更
	set_form_title( $, element_title_area, title_all_area, '.parent_area, .child_area, .sub_child_area', '.checkbox_wrap_out_area', '.set_checkbox_area_home' );
	//初期値
	set_search_title( $, element_title_area, search_title_area );
	set_checkbox_reset( $, '.reset_area', '.checkbox_wrap_out_area', element_title_area, title_all_area, '.get_home_area');
});


function set_checkbox_reset( $, element_click, reset_element, element_title, title_all, get_home_query){
	$( element_click ).click(function(){
		$(reset_element).find('input').prop('disabled', false);
		$(reset_element).find('input').prop('checked', false);
		set_search_title( $, element_title, title_all);
		$(get_home_query).remove();
	});
}


//チェックボックス＞親クリック＞子disable
function set_checkbox_parents( $, element_click, element_parents ){
	$( element_click ).click(function(){
		var element_child = $(this).parents(element_parents).find('input').not($(this));
		if( $(this).prop("checked") ){
			element_child.prop('checked', false);
			element_child.prop('disabled', true);
		}else{
			element_child.prop('disabled', false);
		}
	});
}


//子沿線＞全チェック＞子全disaled＞親チェック
function set_checkbox_station($){
	var checked_cnt = 0;
	var count = 0;
	$( '.child_station' ).click(function(){
		var check_element = $(this).parents('.checkbox_child_wrap_station');
		checked_cnt = check_element.find('input:checked').length;
		count = check_element.find('input').length;
		if( checked_cnt==count ){
			check_element.prev('.checkbox_station').find('input').prop('checked', true);
			check_element.find('input').prop('checked', false);
			check_element.find('input').prop('disabled', true);
		}
		
	});
}


//子＞全チェック＞子全disaled＞親チェック
function set_check_child($){
	var checked_cnt = 0;
	var count = 0;
	$( '.child_area' ).click(function(){
		var check_element = $(this).parents('.child_wrap_area');
		checked_cnt = check_element.siblings().find('input:checked').length;
		count = check_element.siblings().length;
		if( checked_cnt==count ){
			$(this).parents('.child_out_wrap_area').prev('.parent_area_wrap').find('input').prop('checked', true);
			$(this).parents('.child_out_wrap_area').find('input').prop('checked', false);
			$(this).parents('.child_out_wrap_area').find('input').prop('disabled', true);
		}
		
	});
}


//孫＞全チェック＞子全disaled＞親チェック
function set_check_gchild($){
	var checked_cnt = 0;
	var count = 0;
	$( '.sub_child_area' ).click(function(){
		
		var check_element = $(this).parents('.sub_child_wrap_area');
		checked_cnt = check_element.find('input:checked').length;
		count = check_element.find('input').length;
		
		if( checked_cnt==count ){
			check_element.prev('.child_in_wrap_area').find('input').prop('checked', true);
			check_element.find('input').prop('checked', false);
			check_element.find('input').prop('disabled', true);
			
			var child_count = check_element.parents('.child_wrap_area').siblings().length;
			if( child_count==0 ){
				check_element.parents('.child_out_wrap_area').prev('.parent_area_wrap').find('input').prop('checked', true);
				check_element.parents('.child_out_wrap_area').find('input').prop('checked', false);
				check_element.parents('.child_out_wrap_area').find('input').prop('disabled', true);
			}
			
		}
	});
}


function set_form_title_all( title_default, title_all ){
	search_title_all = title_default +' '+ title_all;
	return search_title_all;
}


//検索タイトル設定＞すべて、パラメータ
function get_search_title( title_default, get_title ){
	if( get_title!=0 ){
		get_title = get_title.replace('"', '');
		search_title = get_title.replace('"', '');
	}else{
		search_title = title_default;
	}
	return search_title;
}

//検索タイトル設定
function set_search_title( $, element_title, search_title ){
	$( element_title ).text( search_title );
	$( element_title ).append('<i class="material-icons right">arrow_drop_down</i>');
}


//チェックボックス＞クリック＞全要素タイトル設定
function set_form_title( $, element_title, title_all, element_click, element_all, classname ){
	
	var check_title_object = {};
	var check_value_object = {};
	
	$( element_click ).click(function(){
		
		$( classname ).remove();
		
		var element_find_all = $(this).parents(element_all).find('input');
		element_find_all.each(function(key, value){
			if( $(value).prop('checked') ){
				check_title_object[key] = $(value).next('span').text();
				check_value_object[key] = $(value).val();
			}else{
				delete check_title_object[key];
				delete check_value_object[key];
			}
		});
		
		console.log( check_value_object );
		
		var set_send_key = null;
		if( element_title.search('area')!= -1 ){
			set_send_key = 'area[]';
		}else{
			set_send_key = 'station[]';
		}
		
		for(var i in check_value_object){
			$(element_title).after('<input type="hidden" name="'+ set_send_key +'" value="'+ check_value_object[i] +'" class="'+ classname.replace('.', '') +'">');
		}
		
		var array_parent_num = Object.keys(check_title_object).length;
		if( array_parent_num != 0 ){
			if( array_parent_num > 1 ){
				search_title = Object.values(check_title_object).join(',');
			}else{
				$.each(check_title_object, function(key, value){
					search_title = value;
				});
			}
		}else{
			search_title = title_all;
		}
		
		set_search_title( $, element_title, search_title );
	});
}

</script>