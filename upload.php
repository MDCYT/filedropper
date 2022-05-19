<?php
include 'vars.php';

if(isset($_FILES['file'])) {
  $tmp = 'tmp/';
  $filename = htmlspecialchars(basename($_FILES['file']['name']));
  $randomname = bin2hex(random_bytes(20));
  $uploadfile = $tmp . $randomname;

  if(file_exists($uploadfile) == false){
    if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)){
      ?>

      Upload complete! <br> Here goes your link: <br>
      <a href="download.php?d=/<?=$randomname?>" onclick="copylink(this, event)">Click me to copy!</a>
      <br><br>
      <span class="clickable" onclick="location.reload();">Upload another file</span>

      <?php
      $log = file_get_contents($logfile);
      $bdd = json_decode($log, true);

      $bdd[$randomname]['filename'] = $filename;
      $bdd[$randomname]['date'] = date('d/m/y \a\t H:i:s');
      $bdd[$randomname]['ip'] = (($_POST['ip_private'] == "true") ? "???.???.???.???" : $_SERVER['REMOTE_ADDR']);
      $bdd[$randomname]['size'] = $_FILES['file']['size'];

      file_put_contents($logfile, json_encode($bdd));

    } else {
      ?>
      Upload error. Maybe the file is too big. Maximum is 5GB.
      <br><br>
      <span class="clickable" onclick="location.reload();">Upload another file</span>
      <?php
    }
  } else {
    ?>
    Upload error. File already exist !
    <br><br>
    <span class="clickable" onclick="location.reload();">Upload another file</span>
    <?php
  }
}


?>
