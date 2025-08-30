<?php
include('../includes/connect.php');
session_start();

$error_message = "";
$success_message = "";

// If already logged in, redirect
if (isset($_SESSION['adminname'])) {
    header("Location: admin_profile.php");
    exit();
}

/* -------------------- LOGIN HANDLER -------------------- */
if (isset($_POST['admin_login'])) {
    $adminname = mysqli_real_escape_string($con, $_POST['adminname']);
    $admin_password = $_POST['admin_password'];

    $select_query = "SELECT * FROM admin_table WHERE adminname = '$adminname' LIMIT 1";
    $result = mysqli_query($con, $select_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row_data = mysqli_fetch_assoc($result);

        if (password_verify($admin_password, $row_data['admin_password']) || $admin_password === $row_data['admin_password']) {
            $_SESSION['adminname'] = $row_data['adminname'];
            header("Location: admin_profile.php");
            exit();
        } else {
            $error_message = "❌ Invalid Password!";
        }
    } else {
        $error_message = "❌ Admin not found!";
    }
}

/* -------------------- REGISTRATION HANDLER -------------------- */
if (isset($_POST['admin_register'])) {
    $new_name = mysqli_real_escape_string($con, $_POST['new_adminname']);
    $new_email = mysqli_real_escape_string($con, $_POST['new_admin_email']);
    $new_pass = $_POST['new_admin_password'];
    $confirm_pass = $_POST['confirm_admin_password'];

    // Check password match
    if ($new_pass !== $confirm_pass) {
        $error_message = "❌ Passwords do not match!";
    } else {
        // Check if username/email already exists
        $check_query = "SELECT * FROM admin_table WHERE adminname='$new_name' OR admin_email='$new_email' LIMIT 1";
        $check_result = mysqli_query($con, $check_query);

        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $error_message = "❌ Username or Email already exists!";
        } else {
            // Hash password before saving
            $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO admin_table (adminname, admin_email, admin_password) VALUES ('$new_name', '$new_email', '$hashed_pass')";
            if (mysqli_query($con, $insert_query)) {
                $success_message = "✅ Admin Registered Successfully! You can now log in.";
            } else {
                $error_message = "❌ Registration Failed: " . mysqli_error($con);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIZZ FASHION - Admin Login & Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow p-4" style="width: 450px;">
    <h3 class="text-center mb-4">👑 Admin Panel</h3>

    <!-- Alert Messages -->
    <?php if (!empty($error_message)) : ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if (!empty($success_message)) : ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-3" id="authTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button">Login</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button">Register</button>
        </li>
    </ul>

    <div class="tab-content" id="authTabsContent">
        <!-- Login Form -->
        <div class="tab-pane fade show active" id="login" role="tabpanel">
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label">Admin Username</label>
                    <input type="text" name="adminname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="admin_password" class="form-control" required>
                </div>
                <button type="submit" name="admin_login" class="btn btn-primary w-100">🔑 Login</button>
            </form>
        </div>

        <!-- Registration Form -->
        <div class="tab-pane fade" id="register" role="tabpanel">
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label">Admin Username</label>
                    <input type="text" name="new_adminname" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="new_admin_email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="new_admin_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_admin_password" class="form-control" required>
                </div>
                <button type="submit" name="admin_register" class="btn btn-success w-100">➕ Register</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
