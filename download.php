<?php
$tmp = "tmp/";

if(isset($_GET['d'])){
  $filename = basename($_GET['d']);
  $filepath = $tmp . $filename;
  if (file_exists($filepath)) {
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=\"" . $filename . "\"");
    readfile($filepath);
  } else {
    http_response_code(404);
    include('404.php');
    die();
  }
} else {
  http_response_code(404);
  header('Location: 404.php');
  die();
}


?>
