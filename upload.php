<?php
include 'vars.php';

function uploadError($str = ''){
  echo $str;
  http_response_code(403);
  exit();
}

if(!isset($_FILES['file'])) uploadError('Upload error: Maybe the file is too big. Maximum is 5GB.'); // No file provided

$filename = htmlspecialchars(basename($_FILES['file']['name'])); // File original name
$randomname = bin2hex(random_bytes(32)); // File destination name, to prevent enumeration
$uploadfile = $tmp . $randomname;

if (!file_exists($tmp)) mkdir($tmp); // Create tmp directory if doesnt exist already

if(file_exists($uploadfile)) uploadError(); // Destination file exist already, very unlikely

$log = file_get_contents($logfile);
$bdd = json_decode($log, true);

$bdd[$randomname]['filename'] = $filename;
$bdd[$randomname]['link_private'] = (($_POST['link_private'] == "true") ? "true" : "false");
$bdd[$randomname]['date'] = date('d/m/y \a\t H:i:s');
$bdd[$randomname]['ip'] = (($_POST['ip_private'] == "true") ? "???.???.???.???" : $_SERVER['REMOTE_ADDR']);
$bdd[$randomname]['size'] = $_FILES['file']['size'];

move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
file_put_contents($logfile, json_encode($bdd));

echo $randomname;

?>
