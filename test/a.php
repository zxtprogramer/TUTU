<?php
  require("../Command.php");
  $exif = exif_read_data('a.jpg', 0, true);
  print_r($exif);
  foreach ($exif as $key => $section) {
      foreach ($section as $name => $val) {
              echo "$key.$name: $val<br />\n";
      }
  }

?>


