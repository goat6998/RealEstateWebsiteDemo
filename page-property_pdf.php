<?php
require_once get_template_directory().'/module/pdf/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();

if( qtranxf_getLanguage()=='kr' ){
	$font = 'malgun';
}else{
	$font = 'YuGothic-Medium';
}

$options->set('defaultFont', $font);
$options->set('isRemoteEnabled',true);
$dompdf = new Dompdf( $options );

if( empty( $_GET['url'] ) ) return;
$html = file_get_contents( $_GET['url'] );
$dompdf->loadHtml( $html );

$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$components = parse_url( $_GET['url'] );
parse_str($components['query'], $results);

$dompdf->stream( $results['property_id'].'.pdf', array( "Attachment" => 0 ) );

#$dompdf->stream('test.pdf');
#$dompdf->output();
#file_put_contents( get_template_directory()."/print.pdf", $dompdf->output());
?>