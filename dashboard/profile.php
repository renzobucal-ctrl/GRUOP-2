<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (basename($_SERVER["SCRIPT_FILENAME"]) === "profile.php") {
    header("Location: dashboard.php");
    exit;
}

$uid = (int)($_SESSION["user_id"] ?? 0);
$username = $_SESSION["user"] ?? "";
$me = $_SESSION["accounts"][$username] ?? null;
$pMsg = "";
$pOk = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && $uid > 0 && $me) {
    $action = $_POST["action"] ?? "";

    if ($action === "save") {
        $fullname = $_POST["fullname"] ?? "";
        $phone = $_POST["phone"] ?? "";
        $address = $_POST["address"] ?? "";
        $landmark = $_POST["landmark"] ?? "";

        $fullname = is_string($fullname) ? trim($fullname) : "";
        $phone = is_string($phone) ? trim($phone) : "";
        $address = is_string($address) ? trim($address) : "";
        $landmark = is_string($landmark) ? trim($landmark) : "";

        if ($fullname === "") {
            $pMsg = "Full name is required.";
        } elseif ($phone !== "" && !preg_match('/^09\d{9}$/', $phone)) {
            $pMsg = "Phone must be 11 digits, starting with 09.";
        } else {
            $me["fullname"] = $fullname;
            $me["phone"] = $phone;
            $me["address"] = $address;
            $me["landmark"] = $landmark;
            $_SESSION["accounts"][$username] = $me;
            $_SESSION["fullname"] = $fullname;
            $pMsg = "Profile saved.";
            $pOk = true;
        }
    }

    if ($action === "password") {
        $old = $_POST["old"] ?? "";
        $new = $_POST["new"] ?? "";
        $confirm = $_POST["confirm"] ?? "";
        $old = is_string($old) ? $old : "";
        $new = is_string($new) ? $new : "";
        $confirm = is_string($confirm) ? $confirm : "";
        $hash = $me["password"];

        if (!$hash || !password_verify($old, $hash)) {
            $pMsg = "Old password is incorrect.";
        } elseif (strlen($new) < 8) {
            $pMsg = "New password must be at least 8 characters.";
        } elseif ($new !== $confirm) {
            $pMsg = "New passwords do not match.";
        } else {
            $me["password"] = password_hash($new, PASSWORD_DEFAULT);
            $_SESSION["accounts"][$username] = $me;
            $pMsg = "Password changed.";
            $pOk = true;
        }
    }
}

if (!$me) {
    echo '<p class="text-muted">Please log out and log in again.</p>';
    return;
}

$initial = strtoupper(substr($me["fullname"], 0, 1));
?>
<h5 class="mb-3">Profile</h5>

<!-- HEADER -->
<div class="profile-head">
    <div class="avatar"><?= htmlspecialchars($initial) ?></div>
    <div>
        <div class="profile-name"><?= htmlspecialchars($me["fullname"]) ?></div>
        <div class="profile-user">@<?= htmlspecialchars($me["username"]) ?></div>
    </div>
</div>

<!-- DETAILS -->
<div class="box mb-3">
    <div class="box-title">My details</div>

    <form method="post" action="" autocomplete="off">
        <input type="hidden" name="action" value="save">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($me["username"]) ?>" disabled>
        </div>

        <div class="mb-3">
            <label for="pfFullname" class="form-label">Full name</label>
            <input type="text" class="form-control" id="pfFullname" name="fullname"
                   value="<?= htmlspecialchars($me["fullname"]) ?>">
        </div>

        <div class="mb-3">
            <label for="pfPhone" class="form-label">Phone number</label>
            <input type="tel" class="form-control" id="pfPhone" name="phone" maxlength="11"
                   placeholder="09XXXXXXXXX" value="<?= htmlspecialchars($me["phone"]) ?>">
        </div>

        <div class="mb-3">
            <label for="pfAddress" class="form-label">Delivery address</label>
            <textarea class="form-control" id="pfAddress" name="address" rows="2"><?= htmlspecialchars($me["address"]) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="pfLandmark" class="form-label">Landmark</label>
            <input type="text" class="form-control" id="pfLandmark" name="landmark"
                   placeholder="e.g. beside the sari-sari store" value="<?= htmlspecialchars($me["landmark"]) ?>">
        </div>

        <button type="submit" class="btn btn-water w-100">Save</button>
    </form>
</div>

<!-- CHANGE PASSWORD -->
<div class="box">
    <div class="box-title">Change password</div>

    <form method="post" action="" autocomplete="off">
        <input type="hidden" name="action" value="password">

        <div class="mb-3">
            <label for="pfOld" class="form-label">Old password</label>
            <input type="password" class="form-control" id="pfOld" name="old">
        </div>

        <div class="mb-3">
            <label for="pfNew" class="form-label">New password</label>
            <input type="password" class="form-control" id="pfNew" name="new">
            <div class="form-text">At least 8 characters</div>
        </div>

        <div class="mb-3">
            <label for="pfConfirm" class="form-label">Confirm new password</label>
            <input type="password" class="form-control" id="pfConfirm" name="confirm">
        </div>

        <button type="submit" class="btn btn-water w-100">Change password</button>
    </form>
</div>

<?php if ($pMsg): ?>
    
    <div class="modal fade logout-modal" id="profileModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content text-center p-3">
                <div class="fs-1 text-<?= $pOk ? 'success' : 'danger' ?>"><?= $pOk ? '✓' : '✕' ?></div>
                <h5 class="mb-1"><?= $pOk ? 'Saved' : 'Cannot save' ?></h5>
                <p class="text-muted small mb-3"><?= htmlspecialchars($pMsg) ?></p>
                <button type="button" class="btn btn-<?= $pOk ? 'success' : 'danger' ?> w-100" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>

<?php endif; ?>