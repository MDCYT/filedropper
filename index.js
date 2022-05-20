var form = document.getElementById('form');
var fileInput = document.getElementById('file_input');
var statusL = document.getElementById('statusL');
var filename = document.getElementById('filename');
var log = document.getElementById('log');


let label = document.getElementById('file_label');


function upload() {
    if(!confirm("Upload this file: '" + fileInput.files[0].name + "' ?")) return;
    drop_enable = false;

    statusL.innerHTML = 'Uploading...';
    filename.innerHTML = "\"" + fileInput.files[0].name + "\"";

    var files = fileInput.files;
    var formData = new FormData();
    var file = files[0];

    formData.append('file', file, file.name);
    formData.append('ip_private', document.getElementsByName("ip_private")[0].checked);
    formData.append('link_private', document.getElementsByName("link_private")[0].checked);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload.php', true);
    xhr.onload = function () {
      if (xhr.status == 200) {
        statusL.innerHTML = xhr.response;
        label.setAttribute("for",""); //delink le label
        updateLog();
      } else {
        statusL.innerHTML = 'Upload error. Try again.';
      }
    };

    xhr.upload.addEventListener("progress", function(evt) {
      let percent = parseInt(100 * evt.loaded / evt.total);
      statusL.innerHTML = percent + "%";

      let gradient = `linear-gradient(to right, rgba(84, 36, 255, 0.3) ${percent}%, rgba(0, 0, 0, 0.2) ${percent}%)`;
      label.style.background = gradient;

    });

    xhr.send(formData);
  }

  drop_enable = true;
  label.addEventListener("drop", function(evt) {
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

  label.addEventListener("dragover", function(evt) {
    evt.preventDefault();
  });

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
        log.innerHTML = xhr.response;
      }
    };
    xhr.send();
  }
  updateLog();
  let l = setInterval(updateLog, 1000);


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
