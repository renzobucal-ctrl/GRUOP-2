var cartBar = document.getElementById("cartBar");

function updateCart() {
    var count = 0, total = 0;

    document.querySelectorAll(".item-card").forEach(function (card) {
        if (!card.querySelector(".stepper").classList.contains("d-none")) {
            var q = Number(card.querySelector(".step-count").textContent);
            count += q;
            total += q * Number(card.dataset.price);
        }
    });

    document.getElementById("cartCount").textContent = count + (count === 1 ? " item" : " items");
    document.getElementById("cartTotal").textContent = "₱" + total.toLocaleString();
    cartBar.classList.toggle("show", count > 0);
}

document.querySelectorAll(".item-card").forEach(function (card) {
    var add = card.querySelector(".btn-add");
    var stepper = card.querySelector(".stepper");
    var countEl = card.querySelector(".step-count");

    add.addEventListener("click", function () {
        countEl.textContent = 1;
        add.classList.add("d-none");
        stepper.classList.remove("d-none");
        updateCart();
    });

    card.querySelector(".step-plus").addEventListener("click", function () {
        countEl.textContent = Number(countEl.textContent) + 1;
        updateCart();
    });

    card.querySelector(".step-minus").addEventListener("click", function () {
        var n = Number(countEl.textContent) - 1;
        if (n <= 0) {
            stepper.classList.add("d-none");
            add.classList.remove("d-none");
        } else {
            countEl.textContent = n;
        }
        updateCart();
    });
});

document.getElementById("orderBtn").addEventListener("click", function () {
    new bootstrap.Modal(document.getElementById("orderModal")).show();
});
