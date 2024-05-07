<?php include 'vars.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$name ?></title>
	<meta name="description" content="Save your large files and share them around the world.">
    <link rel="icon" type="image/png" href="favicon.png" />
    <link rel="stylesheet" href="styles.css">
  </head>
  <body>
    <h1>><?=$name ?><span class="blink">_</span></h1>
    <?php if($info != ''){ ?><h2 class="info"><?=$info ?></h2><?php } ?>

    <input type="hidden" name="MAX_FILE_SIZE" value="<?=$MAX_FILE_SIZE ?>" />
    <label class="checkbox">🔐 Keep my link private <input type="checkbox" name="link_private"></label>
    <label class="time">🕒 Link expiration <select name="time">
      <option value="0">Never</option>
      <option value="1">1 day</option>
      <option value="7" selected>1 week</option>
      <option value="30">1 month</option>
      <option value="365">1 year</option>
    </select></label>

    <input name="file" type="file" id="file-input"/>
    <label for="file-input" id="file-label" draggable="true">
    <div id="upload-box">
      <span id="dynamic-status">Click or drag a file here</span>
      <span id="static-status">Max file size: <?=$MAX_FILE_SIZE/1024/1024 ?>MB</span>
    </div>
    </label>
    <br>

    <div class="table">
      <a class="tr">
        <div class="th">filename</div>
        <div class="th">size</div>
        <div class="th">date</div>
      </a>
      <div id="file-list">
      </div>
    </div>

    <br><br>
    <a href="https://github.com/mdcyt/files.mdcdev.me"><p><img src="https://github.githubassets.com/images/modules/logos_page/GitHub-Mark.png" width="28px" class="logo">mdcyt</p></a>
	  
	<div class="footer-links">
      <a href="https://files.mdcdev.me/support/kb/faq.php?id=3">Terms of Service</a> - 
      <a href="https://files.mdcdev.me/support/kb/faq.php?id=2">Privacy Policy</a> - 
      <a href="https://files.mdcdev.me/support/kb/faq.php?id=1">DMCA Policy</a> - 
      <a href="https://files.mdcdev.me/support/index.php">Support</a>
    </div>

    <script src="index.js" charset="utf-8"></script>
  </body>
</html>
