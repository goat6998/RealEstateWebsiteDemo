<?php

function create_dir( $directory_path ){
	if( !file_exists( $directory_path ) ){
		if( mkdir( $directory_path, 0777 ) ){
			chmod( $directory_path, 0777 );
		}
	}
}

function set_pdf_list(){
	
	$files_path = get_template_directory()."/files";
	create_dir( $files_path );
	
	$pdf_path = $files_path."/pdf";
	create_dir( $pdf_path );
	
	if( $_FILES  ){
		$upload_file = mb_convert_encoding( $_FILES["pdf"]["name"] , "utf-8", "auto");
		move_uploaded_file( $_FILES["pdf"]["tmp_name"], $pdf_path."/".$upload_file );
	}
	
	$set_url = get_template_directory_uri()."/files/pdf/";
	
	$pdf_dir_list = glob( $pdf_path."/*.pdf" );
	if( !empty( $pdf_dir_list ) ){
		foreach( $pdf_dir_list as $key => $value ){
			$pdf_name[$key] = str_replace( $pdf_path."/", "", $value );
			$pdf_list["name"][$key] = mb_convert_encoding( $pdf_name[$key], "utf-8","auto");
			$pdf_list["url"][$key] = $set_url.$pdf_list["name"][$key];
#			$pdf_list["url"][$key] = urlencode( $pdf_list["name"][$key] );
		}
	}
	
	if( !empty( $_POST["delete"] ) ){
		unlink( $pdf_path."/".$_POST["delete"] );
		echo '<script>location.reload();</script>';
		exit();
	}
	
#	dump( $pdf_list );
	
	
?>

<h1>PDF一覧</h1>

<div style="margin: 1rem 0 1rem 0;">
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="pdf">
<input type="submit" value="アップロード" class="button">
</form>
</div>

<table class="wp-list-table widefat fixed striped table-view-list posts">
<?php
if( !empty( $pdf_list["name"] ) ){
	foreach( $pdf_list["name"] as $key => $value ){
		echo '<tr>';
		echo '<td><a href="'.$pdf_list["url"][$key].'" target="_blank">'.$value.'</a></td>';
		echo '<td align="right"><form action="" method="post"><input type="hidden" name="delete" value="'.$value.'"><button type="submit" class="button delete">削除</button></form></td>';
		echo '</tr>';
	}
}
?>
</table>


<script>
jQuery(function($){
	
	$('.delete').click(function(){
	    if(!confirm('削除しますか？')){
	        /* キャンセルの時の処理 */
	        return false;
	    }else{
	        /*　OKの時の処理 */
	        location.href = '';
	    }
	});
});
</script>

<?php

}





