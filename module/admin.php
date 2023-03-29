<?php
#------------------------------------------------------------管理画面
#管理画面＞フッターメニュー項目追加
register_nav_menu( 'property_search_menu', '物件検索メニュー' );
register_nav_menu( 'member_menu', '会員メニュー' );
register_nav_menu( 'useful_information_menu', 'お役立ち情報メニュー' );
register_nav_menu( 'corporate_information_menu', '企業情報メニュー' );
register_nav_menu( 'pc_sidebar_menu', 'PCサイドバーメニュー' );
register_nav_menu( 'sp_slide_menu', 'スマホスライドメニュー' );


#qTranslate-XT追加の際、カスタムタクソノミー、駅の親カテゴリー編集画面のレイアウトが崩れる問題の対応
function custom_css_code_fix() {
	global $post_type;
?>
	<?php if( !empty( $_GET["taxonomy"] ) && $_GET["taxonomy"]=="station" ): ?>
<style type="text/css">
.form-table tr td {
	max-width: 590px;
}
</style>
	<?php endif; ?>
	
	<?php if( is_admin('post') && $post_type=='property' ): ?>
<style type="text/css">
.tag-cloud-link{
    color: #0071a1;
    border-color: #0071a1;
    background: #f3f5f6;
    vertical-align: top;
    display: inline-block;
    text-decoration: none;
    font-size: 13px !important;
    line-height: 2.15384615;
    min-height: 30px;
    margin: 0;
    padding: 0 10px;
    cursor: pointer;
    border-width: 1px;
    border-style: solid;
    -webkit-appearance: none;
    border-radius: 3px;
    white-space: nowrap;
    box-sizing: border-box;
}
</style>
	<?php endif; ?>
	
<?php
}
add_action('admin_head', 'custom_css_code_fix');


#メニュー表記＞パラメータセット
function set_custom_menus() {
	global $menu;
	
	foreach( $menu as $key => $value ){
		if( $value[0]=='Translations' ){
			$value[0] = '翻訳';
			$menu[$key] = $value;
		}
	}
	
	global $wp_post_types;
	
	if( !empty( $wp_post_types["property"] ) ){
		$wp_post_types["property"]->labels->name = "物件一覧";
		$wp_post_types["property"]->labels->add_new = "新規物件を追加";
		$wp_post_types["property"]->labels->add_new_item = "新規物件を追加";
	}
	remove_menu_page( 'edit.php' );
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'set_custom_menus' );


#ビジュアルエディタ＞ショートコード追加
function add_add_shortcode_button_plugin( $plugin_array ) {
	if( !is_admin('post') ) return;
	$plugin_array[ 'example_shortcode_button_plugin' ] = get_theme_file_uri('/layout/js/editor-button.js');
	return $plugin_array;
}
add_filter( 'mce_external_plugins', 'add_add_shortcode_button_plugin' );


#テキストエディタ＞ショートコード用のHTMLコードボタン
function add_shortcode_button( $buttons ) {
	if( !is_admin('post') ) return;
	$buttons[] = 'titlebar';
	return $buttons;
}
add_filter( 'mce_buttons', 'add_shortcode_button' );


#テキストエディタ＞ショートコード追加
function add_shortcode_quicktags() {
	if( !is_admin('post') ) return;
	if ( wp_script_is('quicktags') ) {
?>
		<script>
			QTags.addButton( 'titlebar_shortcode', '[titlebar]', '[titlebar]', '[/titlebar]' );
		</script>
<?php
	}
}
add_action( 'admin_print_footer_scripts', 'add_shortcode_quicktags' );


#固定ページ＞日付
function set_page_columns( $columns ) {
	global $post_type;
	if( !is_admin('edit') && $post_type!='page' ) return;
	unset( $columns['date'] );
	$columns['post_date'] = '日付';
    return $columns;
}
add_filter( 'manage_edit-page_columns' , 'set_page_columns' );

#固定ページ＞日付修正
function set_page_custom_column( $columns, $post_id ) {
	global $post_type;
	
	if( !is_admin('edit') && $post_type!='page' ) return;
	if( $columns == 'post_date' ) {
		echo get_the_date( 'Y年m月d日　H:i' );
	}
    return $columns;
}
add_filter( 'manage_page_posts_custom_column' , 'set_page_custom_column', 10, 2 );

#固定ページ＞日付＞ソート可能な項目とする
function set_page_sortable_columns( $columns ) {
	global $post_type;
	if( !is_admin('edit') && $post_type!='page' ) return;
	$columns['post_date'] = 'post_date';
	return $columns;
}
add_filter( 'manage_edit-page_sortable_columns', 'set_page_sortable_columns' );


#お知らせ＞日付
function set_notice_columns( $columns ) {
	global $post_type;
	if( !is_admin('edit') && $post_type!='notice' ) return;
	unset( $columns['date'] );
	$columns['post_date'] = '日付';
    return $columns;
}
add_filter( 'manage_edit-notice_columns' , 'set_notice_columns' );

#お知らせ＞日付修正
function set_notice_custom_column( $columns, $post_id ) {
	global $post_type;
	
	if( !is_admin('edit') && $post_type!='notice' ) return;
	if( $columns == 'post_date' ) {
		echo get_the_date( 'Y年m月d日　H:i' );
	}
    return $columns;
}
add_filter( 'manage_notice_posts_custom_column' , 'set_notice_custom_column', 10, 2 );

#お知らせ＞日付＞ソート可能な項目とする
function set_notice_sortable_columns( $columns ) {
	global $post_type;
	if( !is_admin('edit') && $post_type!='notice' ) return;
	$columns['post_date'] = 'post_date';
	return $columns;
}
add_filter( 'manage_edit-notice_sortable_columns', 'set_notice_sortable_columns' );


#HOW TO＞日付
function set_how_to_columns( $columns ) {
	global $post_type;
	if( !is_admin('edit') && $post_type!='how_to' ) return;
	unset( $columns['date'] );
	$columns['post_date'] = '日付';
    return $columns;
}
add_filter( 'manage_edit-how_to_columns' , 'set_how_to_columns' );

#HOW TO＞日付修正
function set_how_to_custom_column( $columns, $post_id ) {
	global $post_type;
	
	if( !is_admin('edit') && $post_type!='how_to' ) return;
	if( $columns == 'post_date' ) {
		echo get_the_date( 'Y年m月d日　H:i' );
	}
    return $columns;
}
add_filter( 'manage_how_to_posts_custom_column' , 'set_how_to_custom_column', 10, 2 );

#HOW TO＞日付＞ソート可能な項目とする
function set_how_to_sortable_columns( $columns ) {
	global $post_type;
	if( !is_admin('edit') && $post_type!='how_to' ) return;
	$columns['post_date'] = 'post_date';
	return $columns;
}
add_filter( 'manage_edit-how_to_sortable_columns', 'set_how_to_sortable_columns' );


#エリア紹介＞日付
function set_area_info_columns( $columns ) {
	global $post_type;
	if( !is_admin('edit') && $post_type!='area_info' ) return;
	unset( $columns['date'] );
	$columns['post_date'] = '日付';
    return $columns;
}
add_filter( 'manage_edit-area_info_columns' , 'set_area_info_columns' );

#エリア紹介＞日付修正
function set_area_info_custom_column( $columns, $post_id ) {
	global $post_type;
	
	if( !is_admin('edit') && $post_type!='area_info' ) return;
	if( $columns == 'post_date' ) {
		echo get_the_date( 'Y年m月d日　H:i' );
	}
    return $columns;
}
add_filter( 'manage_area_info_posts_custom_column' , 'set_area_info_custom_column', 10, 2 );

#エリア紹介＞日付＞ソート可能な項目とする
function set_area_info_sortable_columns( $columns ) {
	global $post_type;
	if( !is_admin('edit') && $post_type!='area_info' ) return;
	$columns['post_date'] = 'post_date';
	return $columns;
}
add_filter( 'manage_edit-area_info_sortable_columns', 'set_area_info_sortable_columns' );


#物件一覧＞Sold/Rented
function add_sold_columns_title( $columns ) {
	global $post_type;
	if( !is_admin('edit') || $post_type!='property' ) return;
	unset( $columns['date'] );
	$columns['apartment_room'] = 'マンション号室';
	$columns['sold'] = 'Sold/Rented';
	$columns['post_date'] = '日時';
	$columns['vacancy_confirmation_date'] = '空室確認日';
    return $columns;
}
add_filter( 'manage_edit-property_columns' , 'add_sold_columns_title' );

//物件一覧＞ソート可能な項目とする
function sortable_vacancy_confirmation_date_column( $columns ) {
	global $post_type;
	if( !is_admin('edit') || $post_type!='property' ) return;
	$columns['post_date'] = 'post_date';
#	$columns['sold'] = 'sold';
	$columns['vacancy_confirmation_date'] = 'vacancy_confirmation_date';
	return $columns;
}
add_filter( 'manage_edit-property_sortable_columns', 'sortable_vacancy_confirmation_date_column' );


#物件一覧＞カラム表示並び替え
function sort_columns_title( $columns ) {
	global $post_type;
	if( !is_admin('edit') || $post_type!='property' ) return;
	$columns = array(
		'cb'     => '<input type="checkbox" />',
		'title' => 'タイトル',
		'apartment_room' => 'マンション号室',
        'property_type' => '物件タイプ',
        'station' => '駅',
        'area' => '地域',
        'property_category' => '物件カテゴリー',
        'language' => '言語',
        'sold' => 'Sold/Rented',
        'post_date' => '日時',
        'vacancy_confirmation_date' => '空室確認日'
    );
    return $columns;
}
add_filter( 'manage_property_posts_columns' , 'sort_columns_title' );


#物件一覧＞カラムデータ表示
function add_sold_columns_value( $columns, $post_id ) {
	global $post_type;
	if( !is_admin('edit') || $post_type!='property' ) return;
	if( $columns == 'apartment_room' ) {
		echo get_field( 'apartment_room', $post_id );
	}
	$set_category = set_category();
	foreach( $set_category as $key => $value ){
		if( $columns == $value ) {
			setAdminColumnCategory( $post_id, $value );
		}
	}
	if( $columns == 'sold' ) {
		if( get_field( 'sold', $post_id ) ){
			echo '成約済み';
		}
	}
	if( $columns == 'post_date' ) {
		echo get_the_date( 'Y年m月d日 H:i' );
	}
	if( $columns == 'vacancy_confirmation_date' ) {
		$vacancy_confirmation_date = get_field( 'vacancy_confirmation_date', $post_id );
		if( !emptY( $vacancy_confirmation_date ) ){
			echo date('Y年m月d日 H:i',  strtotime($vacancy_confirmation_date) );
		}
	}
    return $columns;
}
add_filter( 'manage_property_posts_custom_column' , 'add_sold_columns_value', 10, 2 );


#物件一覧＞カラム追加カテゴリー
function set_category(){
	$set_category[] = 'property_type';
	$set_category[] = 'station';
	$set_category[] = 'area';
	$set_category[] = 'property_category';
	return $set_category;
}


#物件一覧＞カラム追加カテゴリーデータ
function setAdminColumnCategory( $post_id, $taxonomy ){
	global $post_type;
	if( !is_admin('edit') || $post_type!='property' ) return;
	if( $property_type = get_the_terms( $post_id, $taxonomy ) ){
		foreach( $property_type as $key => $value ){
			if( !empty( $value->parent ) ){
				if( $property_type_parent = get_term( $value->parent, $taxonomy ) ){
					$property_type_array[] = get_inquiry_form_title_trans_text( $property_type_parent->name, 'ja' );
				}
			}
			$property_type_array[] = get_inquiry_form_title_trans_text( $value->name, 'ja' );
		}
		$property_type_array = array_unique( $property_type_array );
		echo implode( ', ', $property_type_array );
	}
}


#物件一覧＞絞り込み検索フォーム
function my_add_filter() {
	global $post_type;
	if( !is_admin('edit') || $post_type!='property' ) return;
	$management_company = ( !empty( $_GET['management_company'] ) ) ? $_GET['management_company'] : null ;
	echo '<input type="text" name="management_company" value="'.$management_company.'" placeholder="管理会社名"> ';
	
	$SoldRented[] = array( '全ての物件' => '' );
	$SoldRented[] = array( '空室のみ' => '0' );
	$SoldRented[] = array( '満室のみ' => '1' );
	echo '<select name="sold">';
	foreach( $SoldRented as $sk => $sv ){
		foreach( $sv as $sck => $scv ){
			echo '<option value="'.$scv.'"';
			if( isset($_GET['sold']) && $_GET['sold'] == $scv ) echo 'selected';
			echo '>'.$sck.'</option>';
		}
	}
	echo '</select>';
	
	
	echo '<select name="property_type">
		<option value="">物件タイプ指定なし</option>';
	$property_type = get_terms('property_type', array(
		'hide_empty' => false,
		'orderby' => 'name',
	));
	
	foreach( $property_type as $key => $value ){
		echo '<option value="'.$value->slug.'"';
		if( !empty( $_GET['property_type'] ) && $_GET['property_type'] == $value->slug ) echo 'selected';
		echo '>';
		if( $value->parent!=0 ) echo '　';
		echo get_inquiry_form_title_trans_text( $value->name, 'ja').'</option>';
	}
	echo '</select>';
}
add_action( 'restrict_manage_posts', 'my_add_filter' );


#物件一覧＞パラメータ設定
function add_query_vars_filter( $vars ){
    $vars[] = "property_type";
    $vars[] = "management_company";
	$vars[] = "sold";
	$vars[] = "vacancy_confirmation_date";
    return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );


#物件一覧＞絞り込み検索
add_action( 'pre_get_posts', function($query) {
	if( !is_admin('edit') ) return;
	
	if( !empty( get_query_var('property_type') ) ){
		$tax_query[] = array(
			'taxonomy' => 'property_type',
			'field' => 'slug',
			'terms' => get_query_var('property_type'),
			'operator' => 'IN'
		);
		$query->set( 'tax_query', $tax_query );
	}
	
	if( !empty( get_query_var('management_company') ) ){
		$meta_query[] = array(
			'key' => 'management_company',
			'value' => get_query_var('management_company'),
			'compare' => 'LIKE',
			'type' => 'CHAR'
		);
	}
	
	if( strlen(get_query_var('sold')) > 0 ){
		$meta_query[] = array(
			'key' => 'sold',
			'value' => get_query_var('sold'),
			'compare' => '=',
			'type' => 'NUMERIC'
		);
	}
	
	if( !empty( $meta_query ) ){
		$query->set( 'meta_query', $meta_query );
	}
	
	if( !empty( get_query_var('orderby') ) && get_query_var('orderby')=='vacancy_confirmation_date' ){
        $query->set('meta_key', get_query_var('orderby') );
        $query->set('orderby', 'meta_value_num');
        $query->set('order', get_query_var('order') );
	}
	
});


#物件一覧＞クイック編集＞sold,空室確認日
function display_my_quickmenu( $column_name, $post_type ) {
	if( !is_admin('edit') ) return;
    static $print_nonce = TRUE;
    if ( $print_nonce ) {
        $print_nonce = FALSE;
        wp_nonce_field( 'quick_edit_action', 'property_edit_nonce' ); //CSRF対策
    }
    ?>
<fieldset class="inline-edit-col-left inline-custom-meta">
<div class="inline-edit-col column-<?php echo $column_name ?>">
            <label class="inline-edit-group">
              <?php
                switch ( $column_name ) {
        			case 'apartment_room':
                        ?><span class="title">マンション号室</span><input type="text" name="apartment_room" value="" class=""><?php
                        break;
                    case 'sold':
                        ?><span class="title">Sold/Rented</span><input type="checkbox" name="sold" value="" class=""><?php
                        break;
                    case 'vacancy_confirmation_date':
                        ?><span class="title">空室確認日</span><input type="text" name="vacancy_confirmation_date" value="" id="datepicker" class="">
<script>
jQuery(function($){
	$('#datepicker').datepicker({
		minDate: '0y',
		maxDate: '+1y',
		dateFormat: 'yy-m-d',
		onSelect: function(dateText, inst) {
			$("#datepicker").val(dateText);
        }
});
});
</script>
<style>
.inline-edit-row fieldset label span.title{
	width: 6rem;
}
.inline-edit-row .input-text-wrap input[type=text]{
	width: 90%;
}
.inline-edit-row fieldset label span.input-text-wrap{
	margin-left: 7em;
}
</style>
                        <?php
                        break;
                }
                ?>
           </label>
        </div>
</fieldset>
<?php
}
add_action('quick_edit_custom_box', 'display_my_quickmenu', 10, 2 );


#物件一覧＞クイック編集＞sold,空室確認日用
function add_admin_enqueue( $hook ){
	global $post_type;
	if( $hook=='edit.php' && $post_type=='property' ) {
		global $wp_scripts;
		$ui = $wp_scripts->query('jquery-ui-core');
		wp_enqueue_style('jquery-ui-css', get_theme_file_uri('/layout/css/jquery-ui.css'), false, 'all' );
	    wp_enqueue_script('admin_custom_js', get_theme_file_uri('/layout/js/admin_custom.js'), array(), false, true );
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-datepicker');
	}
}
add_action( 'admin_enqueue_scripts', 'add_admin_enqueue' );


#物件一覧＞クイック編集＞データ保存
function save_custom_meta( $post_id ) {
    $slug = 'property'; //カスタムフィールドの保存処理をしたい投稿タイプを指定
    if ( $slug !== get_post_type( $post_id ) ) {
        return;
    }
    
    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    $_POST += array("{$slug}_edit_nonce" => '');
    if ( !wp_verify_nonce( $_POST["{$slug}_edit_nonce"], 'quick_edit_action' ) ) {
        return;
    }
    
    if ( isset( $_REQUEST['apartment_room'] ) ) {
        update_post_meta( $post_id, 'apartment_room', $_REQUEST['apartment_room'] );
    }
    
    if ( isset( $_REQUEST['vacancy_confirmation_date'] ) ) {
    	$vacancy_confirmation_date = str_replace( '-', '', $_REQUEST['vacancy_confirmation_date'] );
        update_post_meta( $post_id, 'vacancy_confirmation_date', $vacancy_confirmation_date );
    }
    
    if ( isset( $_REQUEST['sold'] ) ) {
        update_post_meta($post_id, 'sold', TRUE);
    } else {
        update_post_meta($post_id, 'sold', FALSE);
    }
}
add_action( 'save_post', 'save_custom_meta' );


function set_print_field() {
	global $post_type;
	if( $post_type=='property' ) return;
	add_meta_box( 'set_print_box_property', '物件印刷', 'set_print_box', 'property', 'side', 'high');
}
add_action('admin_init', 'set_print_field');


function set_admin_enqueue( $hook ){
	global $post_type;
	if( $hook=='post.php' && $post_type=='property' ) {
		wp_enqueue_script('property_print_js', get_theme_file_uri('/layout/js/property_print.js'), array(), false, true );
	}
}
add_action( 'admin_enqueue_scripts', 'set_admin_enqueue' );


function set_print_box( $param ) {
	$get_lang_list = get_lang_list();
	foreach( $get_lang_list as $key => $value ){
		echo '<a href="'.get_print_url_admin( $key ).'" class="button button-secondary get_property_print">'.$value.'</a><div class="set_property_print"></div>';
	}
}


?>