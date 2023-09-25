<?php
include 'vars.php';

echo "Is local directory writable for the webserver ? ";
if(is_writable('.')) {echo 'yes';} else {echo 'no';}

echo "<br> Is logfile writable for the webserver ? ";
if(is_writable($logfile)) {echo 'yes';} else {echo 'no';}

echo "<br>Make sure both are writable. If not, edit permission.";
?>
