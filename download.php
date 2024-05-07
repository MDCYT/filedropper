<?php
include 'vars.php';

// The link can be /d/:uuid
if(isset($_SERVER['REQUEST_URI'])){
  // Log the Request URI in php
  $url_parts = explode('/', $_SERVER['REQUEST_URI']);
  $randomname = end($url_parts);
  $filepath = $tmp . $randomname;
	
  if($randomname == "404.php") {
    header('Location: '.$url);
    exit();
  }

  $sql = "SELECT * FROM files WHERE uuid = '$randomname'";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $filename = $row['filename'];
    if (file_exists($filepath)) {
      $ext = pathinfo($filename, PATHINFO_EXTENSION);
      $mime = mime_content_type($filepath);
      if($ext == 'mp4'){
        $size=filesize($filepath);
        $fm=@fopen($filepath,'rb');
        if(!$fm) {
          // You can also redirect here
          header ("HTTP/1.0 404 Not Found");
          die();
        }

        $begin=0;
        $end=$size;

        if(isset($_SERVER['HTTP_RANGE'])) {
          if(preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches)) {
            $begin=intval($matches[0]);
            if(!empty($matches[1])) {
              $end=intval($matches[1]);
            }
          }
        }
        
        if($begin>0||$end<$size)
          header('HTTP/1.0 206 Partial Content');
        else
          header('HTTP/1.0 200 OK');
        
        header("Content-Type: video/mp4");
        header('Accept-Ranges: bytes');
        header('Content-Length:'.($end-$begin));
        header("Content-Disposition: inline;");
        header("Content-Range: bytes $begin-$end/$size");
        header("Content-Transfer-Encoding: binary\n");
        header('Connection: close');
        
        $cur=$begin;
        fseek($fm,$begin,0);
        
        while(!feof($fm)&&$cur<$end&&(connection_status()==0))
        { print fread($fm,min(1024*16,$end-$cur));
          $cur+=1024*16;
          usleep(1000);
        }
        die();
      }else{
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . $filename . "\"");
        readfile($filepath);
        die();
      }
    }
  }
}

http_response_code(404);
header('Location: 404.php');
die();
?>
