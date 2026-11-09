<?php
session_start();

if (isset($_SESSION["user"])) {
    header("Location: ../dashboard/dashboard.php");
    exit;
}

$error = "";
$fullname = "";
$username = "";
$phone = "";
$address = "";
$landmark = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fields = ["fullname", "username", "phone", "address", "landmark", "password", "confirm_password"];
    $input = [];

    foreach ($fields as $field) {
        $value = $_POST[$field] ?? "";
        $input[$field] = is_string($value) ? trim($value) : "";
    }

    $fullname = $input["fullname"];
    $username = $input["username"];
    $phone = $input["phone"];
    $address = $input["address"];
    $landmark = $input["landmark"];

    if ($fullname === "" || $username === "" || $input["password"] === "") {
        $error = "Please fill in your full name, username, and password.";
    } elseif ($phone !== "" && !preg_match('/^09\d{9}$/', $phone)) {
        $error = "Phone must be 11 digits, starting with 09.";
    } elseif (strlen($input["password"]) < 8) {
        $error = "Password must be at least 8 characters.";
    } elseif ($input["password"] !== $input["confirm_password"]) {
        $error = "Passwords do not match.";
    } else {
        if (isset($_SESSION["accounts"][$username])) {
            $error = "That username is already taken.";
        } else {
            $_SESSION["accounts"][$username] = [
                "id" => count($_SESSION["accounts"] ?? []) + 1,
                "fullname" => $fullname,
                "username" => $username,
                "password" => password_hash($input["password"], PASSWORD_DEFAULT),
                "phone" => $phone,
                "address" => $address,
                "landmark" => $landmark,
            ];
            $_SESSION["new_user"] = $username;
            $_SESSION["flash"] = "Account created. Please log in.";
            header("Location: ../index/index.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=10">
    <title>Create account | DOUBLE A WATER PURIFIED WATER STATION</title>
</head>
<body>
    <div class="bg">
        <div class="slide s1"></div>
        <div class="slide s2"></div>
        <div class="slide s3"></div>
    </div>

    <div class="center">
        <img src="../logo.jpg" alt="Double A Water Station logo" class="img-fluid">
        <div id="loading" class="text-center" style="width: 300px;">
            <div class="loader-bar"><div class="loader-fill"></div></div>
            <p class="mt-3 text-muted">Loading<span class="dot">.</span><span class="dot">.</span><span class="dot">.</span></p>
        </div>
    </div>

    <div class="form-card">
        <h5 class="text-center mb-3 field" style="--i:0">Create account</h5>

        <form method="post" action="register.php" autocomplete="on">
            <div class="mb-3 field" style="--i:1">
                <label for="fullname" class="form-label">Full name</label>
                <input type="text" class="form-control" id="fullname" name="fullname"
                       value="<?= htmlspecialchars($fullname, ENT_QUOTES, "UTF-8") ?>" autocomplete="name" required>
            </div>

            <div class="mb-3 field" style="--i:2">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                       value="<?= htmlspecialchars($username, ENT_QUOTES, "UTF-8") ?>" autocomplete="username" required>
            </div>

            <div class="mb-3 field" style="--i:3">
                <label for="phone" class="form-label">Phone number <span class="text-muted">(optional)</span></label>
                <input type="tel" class="form-control" id="phone" name="phone" maxlength="11"
                       placeholder="09XXXXXXXXX" value="<?= htmlspecialchars($phone, ENT_QUOTES, "UTF-8") ?>" autocomplete="tel">
            </div>

            <div class="mb-3 field" style="--i:4">
                <label for="address" class="form-label">Delivery address <span class="text-muted">(optional)</span></label>
                <textarea class="form-control" id="address" name="address" rows="2" autocomplete="street-address"><?= htmlspecialchars($address, ENT_QUOTES, "UTF-8") ?></textarea>
            </div>

            <div class="mb-3 field" style="--i:5">
                <label for="landmark" class="form-label">Landmark <span class="text-muted">(optional)</span></label>
                <input type="text" class="form-control" id="landmark" name="landmark"
                       value="<?= htmlspecialchars($landmark, ENT_QUOTES, "UTF-8") ?>">
            </div>

            <div class="mb-3 field" style="--i:6">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                       minlength="8" autocomplete="new-password" required>
            </div>

            <div class="mb-3 field" style="--i:7">
                <label for="confirm_password" class="form-label">Confirm password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                       minlength="8" autocomplete="new-password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 field" style="--i:8">Create account</button>
        </form>

        <p class="text-center small mt-3 mb-0 field" style="--i:9">
            Already have an account? <a href="../index/index.php">Log in</a>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($error): ?>
        <div class="modal fade" id="registerErrorModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content text-center p-3">
                    <div class="modal-body pb-0">
                        <div class="fs-1 text-danger">✕</div>
                        <h5 class="mt-2">Registration failed</h5>
                        <p class="mb-0"><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></p>
                    </div>
                    <button type="button" class="btn btn-danger w-100 mt-3" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <script src="java.js"></script>
</body>
</html>
