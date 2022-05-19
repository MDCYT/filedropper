<?php
include 'vars.php';

if(isset($_GET['d'])){
  $randomname = basename($_GET['d']);
  $filepath = $tmp . $randomname;

  $log = file_get_contents($logfile);
  $bdd = json_decode($log, true);

  if(isset($bdd[$randomname])){
    $filename = $bdd[$randomname]['filename'];
    if (file_exists($filepath)) {
      header('Content-Type: application/octet-stream');
      header("Content-Transfer-Encoding: Binary");
      header("Content-disposition: attachment; filename=\"" . $filename . "\"");
      readfile($filepath);
      die();
    }
  }
}

http_response_code(404);
header('Location: 404.php');
die();
?>
