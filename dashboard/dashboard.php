<?php
session_start();

if (isset($_GET["logout"])) {
    unset($_SESSION["user"], $_SESSION["user_id"], $_SESSION["fullname"]);
    header("Location: ../index/index.php");
    exit;
}

if (!isset($_SESSION["user"])) {
    header("Location: ../index/index.php");
    exit;
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Dashboard | DOUBLE A WATER STATION</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=140">
    <link rel="stylesheet" href="../shop/style.css?v=140">
</head>
<body class="dash">

    <div class="topbar">
        <strong>DOUBLE A PURIFIED WATER STATION</strong>

        <button type="button" class="logout-btn" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <path d="M16 17l5-5-5-5"/>
                <path d="M21 12H9"/>
            </svg>
            <span>Logout</span>
        </button>
    </div>

    <!-- SHOP  -->
    <div class="section active" id="shop">
        <?php include __DIR__ . "/../shop/shop.php"; ?>
    </div>

    <!-- MAP -->
    <div class="section" id="map-section">
    </div>

    
    <!-- PROFILE -->
    <div class="section" id="profile">
        <?php include __DIR__ . "/profile.php"; ?>
    </div>

    <!-- BOTTOM MENU -->
    <nav class="bottom-nav">
        <button type="button" class="active" data-target="shop">
            <span class="icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9L5 4H19L21 9"/>
                    <path d="M3 9q1.5 3 3 0q1.5 3 3 0q1.5 3 3 0q1.5 3 3 0q1.5 3 3 0q1.5 3 3 0"/>
                    <path d="M5 12V20M19 12V20M3 20H21"/>
                    <path d="M8 20V14H12V20"/>
                    <rect x="14" y="14" width="3" height="3"/>
                </svg>
            </span>Shop
        </button>

        <button type="button" data-target="map-section">
            <span class="icon">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 2C8.1 2 5 5.1 5 9c0 5.2 7 13 7 13s7-7.8 7-13c0-3.9-3.1-7-7-7zM12 6.5a2.5 2.5 0 1 0 0 5a2.5 2.5 0 1 0 0-5z"/>
                </svg>
            </span>Map
        </button>

        <button type="button" data-target="profile">
            <span class="icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/>
                </svg>
            </span>Profile
        </button>
    </nav>

    <!-- LOGOUT CONFIRM -->
    <div class="modal fade logout-modal" id="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center p-3">
                <h5 class="mt-2 mb-1">Log out?</h5>
                <p class="text-muted small mb-3">Are you sure you want to log out?</p>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-cancel w-100" data-bs-dismiss="modal">Cancel</button>
                    <a href="dashboard.php?logout=1" class="btn btn-danger w-100">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../shop/java.js"></script>
    <script src="java.js"></script>
</body>
</html>