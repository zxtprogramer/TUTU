<?php
$exif = exif_read_data('a.jpg', 0, true);
print_r($exif);
eval("\$du=" . $exif['GPS']['GPSLongitude'][0] . ".0;");
eval("\$fen=" . $exif['GPS']['GPSLongitude'][1] . ".0;");
eval("\$miao=" . $exif['GPS']['GPSLongitude'][2] . ".0;");
$lng=$du + $fen/60.0 + $miao/60.0/60.0;
eval("\$du=" . $exif['GPS']['GPSLatitude'][0] . ".0;");
eval("\$fen=" . $exif['GPS']['GPSLatitude'][1] . ".0;");
eval("\$miao=" . $exif['GPS']['GPSLatitude'][2] . ".0;");
$lat=$du + $fen/60.0 + $miao/60.0/60.0;
$shootTime=(float)$exif['FILE']['FileDateTime'];
?>
