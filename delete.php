<?php
include 'vars.php';

// Check the files in the database
$sql = "SELECT * FROM files";

$result = $conn->query($sql);

$files = glob($tmp . '*');

$deleted = array();

// If the file dont exist in the database, delete it, if the expiration_date is less than the actual date and is not null, delete it
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $filename = $row['filename'];
    $randomname = $row['uuid'];
    $filepath = $tmp . $randomname;
    $expiration_date = $row['expiration_date'];

    if ($expiration_date != null && strtotime($expiration_date) < time()) {
      if (file_exists($filepath)) {
        array_push($deleted, $filename." expired");
        unlink($filepath);
      }
      $sql = "DELETE FROM files WHERE uuid = '$randomname'";
      $conn->query($sql);
    }

    if (!file_exists($filepath)) {
      $sql = "DELETE FROM files WHERE uuid = '$randomname'";
      $conn->query($sql);
    }
  }

  foreach ($files as $file) {
    $filename = basename($file);
    $sql = "SELECT * FROM files WHERE uuid = '$filename'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
      array_push($deleted, $filename." not in database");
      unlink($file);
    }
  }
}

echo json_encode($deleted);

die();
