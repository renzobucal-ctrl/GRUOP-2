<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (basename($_SERVER["SCRIPT_FILENAME"]) === "shop.php") {
    header("Location: ../dashboard/dashboard.php");
    exit;
}


$products = [
    ["id" => 1, "name" => "Round Gallon", "detail" => "5 gallon",   "price" => 200, "type" => "jug",    "best" => true],
    ["id" => 2, "name" => "Slim Gallon",  "detail" => "5 gallon",   "price" => 220, "type" => "jug",    "best" => false],
    ["id" => 3, "name" => "Small Gallon", "detail" => "3 gallon",   "price" => 150, "type" => "jug",    "best" => false],
    ["id" => 4, "name" => "Bottle",       "detail" => "1 gallon",   "price" => 60,  "type" => "bottle", "best" => false],
    ["id" => 5, "name" => "Bottle Case",  "detail" => "500ml x 24", "price" => 150, "type" => "bottle", "best" => false],
    ["id" => 6, "name" => "Bottle Case",  "detail" => "350ml x 24", "price" => 120, "type" => "bottle", "best" => false],
];
?>
<h5 class="mb-3">Shop</h5>

<div class="row g-3">
    <?php foreach ($products as $p): ?>
        <div class="col-6 col-md-4">
            <div class="item-card" data-price="<?= (int)$p["price"] ?>">

                <div class="item-img">
                    <?php if ($p["best"]): ?>
                        <span class="badge-best">Bestseller</span>
                    <?php endif; ?>

                    <?php if ($p["type"] === "jug"): ?>
                        <svg viewBox="0 0 64 80">
                            <rect x="24" y="2" width="16" height="8" rx="2" fill="#0077b6"/>
                            <path d="M22 10h20l8 14v46a8 8 0 0 1-8 8H22a8 8 0 0 1-8-8V24z" fill="#d9f1ff" stroke="#00aaff" stroke-width="2"/>
                            <path d="M16 44h32v26a6 6 0 0 1-6 6H22a6 6 0 0 1-6-6z" fill="#00aaff" opacity=".75"/>
                        </svg>
                    <?php else: ?>
                        <svg viewBox="0 0 40 80">
                            <rect x="15" y="2" width="10" height="7" rx="2" fill="#0077b6"/>
                            <path d="M16 9h8l6 12v50a6 6 0 0 1-6 6H16a6 6 0 0 1-6-6V21z" fill="#d9f1ff" stroke="#00aaff" stroke-width="2"/>
                            <path d="M12 42h24v28a4 4 0 0 1-4 4H16a4 4 0 0 1-4-4z" fill="#00aaff" opacity=".75"/>
                        </svg>
                    <?php endif; ?>
                </div>

                <div class="item-body">
                    <div class="item-name"><?= htmlspecialchars($p["name"]) ?></div>
                    <div class="item-detail"><?= htmlspecialchars($p["detail"]) ?></div>
                    <div class="item-price">₱<?= number_format($p["price"]) ?></div>

                    <button type="button" class="btn-add">Add</button>

                    <div class="stepper d-none">
                        <button type="button" class="step-minus">−</button>
                        <span class="step-count">1</span>
                        <button type="button" class="step-plus">+</button>
                    </div>
                </div>

            </div>
        </div>
    <?php endforeach; ?>
</div>


<div class="cart-bar" id="cartBar">
    <div>
        <div class="cart-count" id="cartCount">0 items</div>
        <div class="cart-total" id="cartTotal">₱0</div>
    </div>
    <button type="button" class="btn-order" id="orderBtn">Place order</button>
</div>


<div class="modal fade logout-modal" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content text-center p-3">
            <div class="fs-1 text-success">✓</div>
            <h5 class="mb-1">Order placed</h5>
            <p class="text-muted small mb-3">This is a demo. Saving orders comes later.</p>
            <button type="button" class="btn btn-success w-100" data-bs-dismiss="modal">OK</button>
        </div>
    </div>
</div>
