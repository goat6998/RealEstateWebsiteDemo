<?php
//親テーマ＞CSS読み込み
function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_theme_file_uri('/style.css') );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );


//デバッグ用
function dump( $data ){
	echo "<pre>";
	var_dump($data);
	echo "<pre>";
}

//共通
require_once("module/share.php");

if( is_admin() ){
	//管理画面
	require_once("module/admin.php");

}else{
	
	//フロント
	require_once("module/front.php");

	//検索フォーム設定
	require_once("module/search.php");

}


?>