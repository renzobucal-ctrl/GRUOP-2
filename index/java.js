function showContent() {
  document.body.classList.add("ready");
}

setTimeout(showContent, 5000);

document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault();

  var btn = document.getElementById("loginBtn");
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Logging in...';

  var form = this;
  setTimeout(function () {
    form.submit();
  }, 1000);
});

var messageModal = document.getElementById("msgModal");
if (messageModal) {
  bootstrap.Modal.getOrCreateInstance(messageModal).show();
}
