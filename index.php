<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>File dropper</title>
    <link rel="icon" type="image/png" href="favicon.png" />
    <link rel="stylesheet" href="styles.css" media="screen and (min-device-width: 800px)">
    <link rel="stylesheet" href="styles-mobile.css" media="screen and (max-device-width: 800px)">
  </head>
  <body>
    <div id="content">
      <h1><span class="highlight_purple">&#60;File dropper.ml/&#62;</span></h1>

      <form enctype="multipart/form-data" action="upload.php" method="post" id="form">
        <input type="hidden" name="MAX_FILE_SIZE" value="5000000000" />
        <label class="checkbox_label"><input type="checkbox" name="ip_private"/> Keep my IP private</label>
        <label class="checkbox_label"><input type="checkbox" name="link_private"/> Keep my link private</label>
        <input name="file" type="file" id="file_input"/>
        <label for="file_input" id="file_label" draggable="true">
          <div>
            <span id="filename">Click or drag a file here</span>
            <br>
            <span id="statusL"></span>
          </div>
        </label>
      </form>

      <h2><span class="highlight_red">&#60;Logs/&#62;</span></h2>

      <p id="log"></p>
      <script src="index.js" charset="utf-8"></script>

      <div id="footer" onclick="clearInterval(l);">
        <a href="https://github.com/fullfox/filedropper">filedropper.ml / @fullfox 2022</a>
      </div>

    </div>
  </body>
</html>
