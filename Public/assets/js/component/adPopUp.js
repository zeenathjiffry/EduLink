var modal = document.getElementById("adRequestModal");
var btn = document.getElementById("openAdModalBtn");
var span = document.getElementsByClassName("adv-close-button")[0];
var fileInput = document.getElementById("ad_poster");
var fileNameSpan = document.getElementById("advFileName");

modal.style.display = "none";
btn.onclick = function () {
  modal.style.display = "block";
};

span.onclick = function () {
  modal.style.display = "none";
};

window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

fileInput.onchange = function () {
  if (fileInput.files.length > 0) {
    fileNameSpan.textContent = fileInput.files[0].name;
  } else {
    fileNameSpan.textContent = "No file selected.";
  }
};
