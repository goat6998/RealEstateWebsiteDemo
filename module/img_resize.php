<?php
$original_file = $_GET['url'];
$thumb_width = $_GET['width'];

list($original_width, $original_height, $type) = getimagesize( $_GET['path'] );
$thumb_height = round( $original_height * $thumb_width / $original_width );

header("Cache-control: no-cache");
switch($type){
    case IMAGETYPE_JPEG:
    	header ('Content-Type: image/jpeg');
        break;
    case IMAGETYPE_PNG:
    	header("Content-type: image/png");
        break;
    case IMAGETYPE_GIF:
    	header ('Content-Type: image/gif');
        break;
}



$image = new Imagick( $_GET['path'] );
$image->thumbnailImage( $thumb_width , 0);
echo $image;

?>