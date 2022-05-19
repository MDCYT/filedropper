<?php
$tmp = "tmp/";
$logfile = "log.txt";

$password = "1a489b1508e41d5c0075a0c8b7d94182e6f5b6b70234c7ed943e94647cc10a06";
//sha256 hash for changethispasswordfiledropper.ml

function formatSizeUnits($bytes){
       if ($bytes >= 1000000000) {$bytes = number_format($bytes / 1000000000, 2) . ' GB';}
       elseif ($bytes >= 1000000) {$bytes = number_format($bytes / 1000000, 2) . ' MB';}
       elseif ($bytes >= 1000) {$bytes = number_format($bytes / 1000, 2) . ' KB';}
       else {$bytes = $bytes . ' B';}
       return $bytes;
}
?>
