setTimeout(function () {
    document.body.classList.add("ready");
}, 5000);

var registerErrorModal = document.getElementById("registerErrorModal");
if (registerErrorModal) {
    bootstrap.Modal.getOrCreateInstance(registerErrorModal).show();
}
