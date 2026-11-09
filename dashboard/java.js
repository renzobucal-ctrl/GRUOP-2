var buttons = document.querySelectorAll(".bottom-nav button");
var sections = document.querySelectorAll(".section");

buttons.forEach(function (btn) {
    btn.addEventListener("click", function () {
        buttons.forEach(function (b) { b.classList.remove("active"); });
        sections.forEach(function (s) { s.classList.remove("active"); });

        btn.classList.add("active");
        document.getElementById(btn.dataset.target).classList.add("active");

        document.getElementById("cartBar").classList.toggle("hide-on-tab", btn.dataset.target !== "shop");
    });
});

var profileModal = document.getElementById("profileModal");
if (profileModal) {
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector('.bottom-nav [data-target="profile"]').click();
        new bootstrap.Modal(profileModal).show();
    });
}
