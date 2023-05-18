<?php
include 'vars.php';
header("Content-Type: text/plain");
$log = file_get_contents($logfile);

$bdd = json_decode($log, true);
$list = [];
foreach ($bdd as $randomname => $elem) {
  if($elem['link_private'] == 'false'){
  $list[] = array(
    "uuid"=>$randomname,
    "filename"=>$elem['filename'],
    "size"=>$elem['size'],
    "date"=>$elem['date'],
    "ip"=>$elem['ip']);
  }
}
echo json_encode($list);
?>
