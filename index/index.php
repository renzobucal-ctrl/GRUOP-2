<?php
session_start();

if (isset($_SESSION["user"])) {
    header("Location: ../dashboard/dashboard.php");
    exit;
}


$error = "";
$username = $_SESSION["new_user"] ?? "";
$success = $_SESSION["flash"] ?? "";
unset($_SESSION["flash"], $_SESSION["new_user"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usernameInput = $_POST["username"] ?? "";
    $passwordInput = $_POST["password"] ?? "";

    if (is_string($usernameInput) && is_string($passwordInput)) {
        $username = trim($usernameInput);
        $user = $_SESSION["accounts"][$username] ?? null;

        if ($user && password_verify($passwordInput, $user["password"])) {
            session_regenerate_id(true);
            $_SESSION["user"] = $user["username"];
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["fullname"] = $user["fullname"];
            header("Location: ../dashboard/dashboard.php");
            exit;
        }
    }

    $error = "Wrong username or password.";
}

$message = $error ?: $success;
$color = $error ? "danger" : "success";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=10">
    <title>DOUBLE A WATER PURIFIED WATER STATION</title>
</head>
<body>
    <div class="bg">
        <div class="slide s1"></div>
        <div class="slide s2"></div>
        <div class="slide s3"></div>
    </div>

    <div class="center">
        <img src="../logo.jpg" id="myImage" alt="logo" class="img-fluid">

        <div id="loading" class="text-center" style="width: 300px;">
            <div class="loader-bar"><div class="loader-fill"></div></div>
            <p class="mt-3 text-muted">
                Loading<span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>
            </p>
        </div>
    </div>

    <div class="form-card">
        <h5 class="text-center mb-3 field" style="--i:0">Login</h5>

        <form id="loginForm" action="" method="post" autocomplete="off">
            <div class="mb-3 field" style="--i:1">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                       value="<?= htmlspecialchars($username, ENT_QUOTES, "UTF-8") ?>"
                       autocomplete="username" required>
            </div>

            <div class="mb-3 field" style="--i:2">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       autocomplete="current-password" required>
            </div>

            <button type="submit" id="loginBtn" class="btn btn-primary w-100 field" style="--i:3">Login</button>
        </form>

        <p class="text-center small mt-3 mb-0 field" style="--i:4">
            Don't have an account? <a href="../register/register.php">Create account</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($message): ?>
        <div class="modal fade" id="msgModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content text-center p-3">
                    <div class="modal-body pb-0">
                        <div class="fs-1 text-<?= $color ?>"><?= $error ? '✕' : '✓' ?></div>
                        <h5 class="mt-2"><?= $error ? 'Login failed' : 'Success' ?></h5>
                        <p class="mb-0"><?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?></p>
                    </div>
                    <button type="button" class="btn btn-<?= $color ?> w-100 mt-3" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <script src="java.js?v=10"></script>
</body>
</html>