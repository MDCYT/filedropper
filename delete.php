<?php
include 'vars.php';

if(hash('sha256', $_GET["p"] . 'filedropper.ml') == $password){
  $files = glob($tmp . '*');
  foreach($files as $file){
    if(is_file($file)) {
      unlink($file);
    }
  }
  file_put_contents($logfile, "");
}
die();
?>
