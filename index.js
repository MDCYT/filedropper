let fileInput = document.getElementById('file-input');
let fileLabel = document.getElementById('file-label');
let uploadBox = document.getElementById('upload-box');
let fileList = document.getElementById('file-list');

let dynamicStatus = document.getElementById('dynamic-status'); //color blend
let staticStatus = document.getElementById('static-status'); //no blend

// Main
let drop_enable = true;
let files = [];
let l = setInterval(updateLog, 10000);
updateLog();

fileLabel.addEventListener("drop", function(evt) {
  evt.preventDefault();
  if(drop_enable){
    var dT = evt.dataTransfer;
    var files = dT.files;
    if (files && files.length) {
      fileInput.files = files;
      upload();
    }
  }
});
fileInput.addEventListener("change", function(evt) {
  upload();
});
fileLabel.addEventListener("dragover", function(evt) {
  evt.preventDefault();
});


// FUNCTIONS:

function upload() {
  staticStatus.innerHTML = '';
  
    drop_enable = false;
    let file = fileInput.files[0];

    // Check file size
    if (file.size > (500 * 1024 * 1024)) {
      staticStatus.innerHTML = 'File too large. Max 500MB.';
      return;
    }

    if(!confirm("Upload this file: '" + escapeHTML(file.name) + "' ?")) return;

    let data = new FormData();
    data.append('file', file, file.name);
    data.append('link_private', document.getElementsByName("link_private")[0].checked);
    data.append('time_expiration', document.getElementsByName("time")[0].value);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload.php', true);
    xhr.onload = function () {
      dynamicStatus.innerHTML = '';
      if (xhr.status == 200) {
        let response = JSON.parse(xhr.response);
        staticStatus.innerHTML = `Successfully uploaded "${escapeHTML(file.name)}"<br>Here's your link:<br><a href="/d/${response.uuid}" id="download-link" onclick="copylink(this, event)">Click me to copy</a><br><br><a href="">Upload another file</a>`;
        fileLabel.setAttribute("for",""); //delink le label
        updateLog();
      } else {
        let response = JSON.parse(xhr.response);
        staticStatus.innerHTML = `${response.error}`;
      }
    };

    xhr.upload.addEventListener("progress", function(evt) {
      let percent = parseInt(100 * evt.loaded / evt.total);
      dynamicStatus.innerHTML = `Uploading "${fileInput.files[0].name}"<br>${percent}%`;
      let gradient = `linear-gradient(to right, var(--maincolor) ${percent}%, white ${percent}%)`;
      let gradient_text = `linear-gradient(to right, white ${percent}%, var(--maincolor) ${percent}%)`;
      uploadBox.style.backgroundImage = gradient;
      dynamicStatus.style.backgroundImage = gradient_text;

    });

    xhr.send(data);
  }



function copylink(elem, evt){
  copyToClipboard(elem.href);
  elem.innerHTML = "Copied!";
  elem.classList.add("copied");
  evt.preventDefault();
}

function updateLog(){
  let xhr = new XMLHttpRequest();
  xhr.open('GET', 'log.php?' + Date.now(), true);
  xhr.onload = function () {
    if (xhr.status == 200) {
      files = JSON.parse(xhr.response);
      buildFilelist();
    }
  };
  xhr.send();
}

function buildFilelist(){
  for (const file of files) {

    if(document.getElementById("item-"+file.uuid)) continue;

    let item = document.createElement('a');
    fileList.prepend(item);
    item.outerHTML = `
    <a href="/d/${file.uuid}" class="tr" id="item-${file.uuid}" title="${file.filename}">
      <div class="td">${file.filename}</div>
      <div class="td">${formatSizeUnits(file.size)}</div>
      <div class="td">${file.date}</div>
    </a>
    `;

  }
}

//Snippet d'internet
function copyToClipboard(textToCopy) {
    // navigator clipboard api needs a secure context (https)
    if (navigator.clipboard && window.isSecureContext) {
        // navigator clipboard api method'
        return navigator.clipboard.writeText(textToCopy);
    } else {
        // text area method
        let textArea = document.createElement("textarea");
        textArea.value = textToCopy;
        // make the textarea out of viewport
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        textArea.style.top = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        return new Promise((res, rej) => {
            // here the magic happens
            document.execCommand('copy') ? res() : rej();
            textArea.remove();
        });
    }
}

function formatSizeUnits(bytes) {
  if (bytes >= 1024 * 1024 * 1024) {
    bytes = (bytes / (1024 * 1024 * 1024)).toFixed(2) + ' GB';
  } else if (bytes >= 1024 * 1024) {
    bytes = (bytes / (1024 * 1024)).toFixed(2) + ' MB';
  } else if (bytes >= 1024) {
    bytes = (bytes / 1024).toFixed(2) + ' KB';
  } else {
    bytes = bytes + ' B';
  }
  return bytes;
}

function escapeHTML(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}