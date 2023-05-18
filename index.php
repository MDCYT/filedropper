<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>File dropper</title>
    <link rel="icon" type="image/png" href="favicon.png" />
    <link rel="stylesheet" href="styles.css" media="screen and (min-device-width: 800px)">
    <link rel="stylesheet" href="styles.css" media="screen and (max-device-width: 800px)">
  </head>
  <body>
    <h1>>filedropper.eu<span class="blink">_</span></h1>

    <input type="hidden" name="MAX_FILE_SIZE" value="5000000000" />
    <label class="checkbox">🕵 Keep my IP private <input type="checkbox" name="ip_private"/></label>
    <label class="checkbox">🔐 Keep my link private <input type="checkbox" name="link_private"></label>

    <input name="file" type="file" id="file-input"/>
    <label for="file-input" id="file-label" draggable="true">
    <div id="upload-box">
      <span id="dynamic-status">Click or drag a file here</span>
      <span id="static-status"></span>
    </div>
    </label>
    <br>

    <div class="table">
      <a class="tr">
        <div class="th">filename</div>
        <div class="th">size</div>
        <div class="th">date</div>
        <div class="th">IP</div>
      </a>
      <div id="file-list">
      </div>
    </div>

    <br><br>
    <a href="https://github.com/fullfox/filedropper"><p><img src="https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png" width="28px" class="logo">fullfox</p></a>

    <script src="index.js" charset="utf-8"></script>
  </body>
</html>
