<?php
 $dir_referee = "../images/arbitraje/*.jpg";
 //get the list of all files in the directory with jpg extension and safe it in an array named $images
 $images_ref  = glob($dir_referee);
 //extract only the name of the file without the extension and save in an array named $find
  foreach( $images_ref as $image ):
     echo '<div class="mb-3 pics animation all 1 ">'.'<img class="img-fluid" src="' . $image . '"></div>';
 endforeach;

  $dir_basquet = "../images/basquet/*.jpg";
  //get the list of all files in the directory with jpg extension and safe it in an array named $images
  $images_bq  = glob($dir_basquet);
  //extract only the name of the file without the extension and save in an array named $find
   foreach( $images_bq as $image ):
      echo '<div class="mb-3 pics animation all 2 ">'.'<img class="img-fluid" src="' . $image . '"></div>';
  endforeach;
   ?>
