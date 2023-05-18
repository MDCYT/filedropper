<?php
include 'vars.php';

function uploadError(){
  echo 'Upload error. Maybe the file is too big. Maximum is 5GB.';
  http_response_code(403);
}

function fileAlreadyExistError(){
  echo 'Upload error. File already exist !';
  http_response_code(403);
}

if(isset($_FILES['file'])) {
  $filename = htmlspecialchars(basename($_FILES['file']['name']));
  $randomname = bin2hex(random_bytes(20));
  $uploadfile = $tmp . $randomname;

  if(file_exists($uploadfile) == false){
    if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)){
      $log = file_get_contents($logfile);
      $bdd = json_decode($log, true);

      $bdd[$randomname]['filename'] = $filename;
      $bdd[$randomname]['link_private'] = (($_POST['link_private'] == "true") ? "true" : "false");
      $bdd[$randomname]['date'] = date('d/m/y \a\t H:i:s');
      $bdd[$randomname]['ip'] = (($_POST['ip_private'] == "true") ? "???.???.???.???" : $_SERVER['REMOTE_ADDR']);
      $bdd[$randomname]['size'] = $_FILES['file']['size'];

      file_put_contents($logfile, json_encode($bdd));
      echo $randomname;
    } else { uploadError(); }
  } else { fileAlreadyExistError(); }
} else { uploadError(); }
?>
