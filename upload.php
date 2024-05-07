<?php
include 'vars.php';

function uploadError($str = '', $code = 403) {
  header('Content-Type: application/json');
  http_response_code($code);
  echo json_encode(array('error' => $str, 'success' => false, 'status' => 403));
  exit();
}

if(!isset($_FILES['file'])) uploadError('Upload error: Maybe the file is too big. Maximum is 25GB.'); // No file provided

$filename = htmlspecialchars(basename($_FILES['file']['name'])); // File original name
$randomname = bin2hex(random_bytes(64)); // File destination name, to prevent enumeration

// If file is a mp4, please put mp4 at the end of the file
if(pathinfo(basename($_FILES['file']['name']), PATHINFO_EXTENSION) == 'mp4') $randomname .= '.mp4';

// Make the same, using the actual time for better randomness and less collisions
$uploadfile = $tmp . $randomname;

if (!file_exists($tmp)) mkdir($tmp); // Create tmp directory if doesnt exist already

if(file_exists($uploadfile)) uploadError('Upload error: File already exists.'); // File already exists

// Check if time_expiration is set and if is 0 or a number, maximum 1 year and 0 is never
if(!isset($_POST['time_expiration']) || !is_numeric($_POST['time_expiration']) || $_POST['time_expiration'] < 0 || $_POST['time_expiration'] > 365) uploadError('Upload error: Invalid expiration time. '.$_POST['time_expiration']);

// Upload to sql
$sql;

// If is 0, use null, else use the actual time + the time in days
if($_POST['time_expiration'] == 0) {
  $sql = "INSERT INTO files (uuid, filename, link_private, size) VALUES ('$randomname', '$filename', ".(($_POST['link_private'] == "true") ? "true" : "false").", ".$_FILES['file']['size'].")";
} else {
  $sql = "INSERT INTO files (uuid, filename, link_private, size, expiration_date) VALUES ('$randomname', '$filename', ".(($_POST['link_private'] == "true") ? "true" : "false").", ".$_FILES['file']['size'].", '".date('Y-m-d H:i:s', strtotime('+'.$_POST['time_expiration'].' days'))."')";
}

if ($conn->query($sql) === FALSE) {
  uploadError('Upload error: Error uploading to database.');
}

// move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
// Upload the file
if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) uploadError('Upload error: File could not be uploaded.');

// echo $randomname;
// Response a json with the randomname
header('Content-Type: application/json');
echo json_encode(array('url' => $url."download.php?d=".$randomname, 'uuid' => $randomname, 'success' => true, 'status' => 200));

?>
