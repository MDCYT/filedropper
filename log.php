<?php
include 'vars.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM files WHERE link_private = false ORDER BY date ASC";

$result = $conn->query($sql);

$list = [];
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $list[] = array(
      "uuid"=>$row['uuid'],
      "filename"=>$row['filename'],
      "size"=>$row['size'],
      "date"=>$row['date']);
  }
}

echo json_encode($list);
?>
