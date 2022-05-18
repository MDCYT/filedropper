<?php

$logfile = "log.txt";
if(isset($_FILES['file'])) {
  $uploaddir = 'tmp/';
  $filename = htmlspecialchars(basename($_FILES['file']['name']));
  $uploadfile = $uploaddir . $filename;

  if(file_exists($uploadfile) == false){
    if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)){
      ?>

      Upload complete! <br> Here goes your link: <br>
      <a href="download.php?d=/<?=$filename?>" onclick="copylink(this, event)">Click me to copy!</a>
      <br><br>
      <span class="clickable" onclick="location.reload();">Upload another file</span>

      <?php
      $log = file_get_contents($logfile);
      $log = (($_POST['ip_private'] == "true") ? "???.???.???.???" : $_SERVER['REMOTE_ADDR'])
      . " uploaded <a href=\"download.php?d=" . $filename . "\">"
      . $filename . "</a> on "
      . date('d/m/y \a\t H:i:s') . "\n\n"
      . $log;
      file_put_contents($logfile, $log);

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
