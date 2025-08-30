<?php
// Security: Hide admin registration from public access
// Only allow access with special parameter or from specific IP
$admin_access_key = "admin_secret_key_2024"; // Change this to a strong secret key
$allowed_ips = ['127.0.0.1', '::1']; // Add your admin IP addresses here

// Check for access permission
$has_access = false;

// Method 1: Secret key in URL (admin_registration.php?key=admin_secret_key_2024)
if (isset($_GET['key']) && $_GET['key'] === $admin_access_key) {
    $has_access = true;
}

// Method 2: Check if accessing from allowed IP (optional)
// if (in_array($_SERVER['REMOTE_ADDR'], $allowed_ips)) {
//     $has_access = true;
// }

// Method 3: Check if super admin is logged in (optional)
session_start();
if (isset($_SESSION['super_admin']) && $_SESSION['super_admin'] === true) {
    $has_access = true;
}

// If no access, show 404 error
if (!$has_access) {
    http_response_code(404);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>404 - Page Not Found</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5 text-center">
            <h1 class="display-1">404</h1>
            <h2>Page Not Found</h2>
            <p>The page you are looking for does not exist.</p>
            <a href="../index.php" class="btn btn-primary">Go Home</a>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// Include files only after access verification
include('../includes/connect.php');
include('../functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style> 
    .body{
      overflow-x:hidden;
    }
    .img-fluid{
        width: 1500px;
        height: 650px;
        object-fit: contain;
    }
    .security-notice {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 20px;
    }
    </style>
</head>
<body>
    <div class="container-fluid m-3">
        <!-- Security Notice -->
        <div class="security-notice">
            <i class="fas fa-shield-alt text-warning"></i>
            <strong>Secure Admin Area</strong> - Authorized access only
        </div>
        
        <h2 class="text-center mb-5">New Admin Registration</h2>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 col-lg-5">
                <img src="../images/admin_registration.jpg" alt="Admin Registration" class="img-fluid">
            </div>
            <div class="col-lg-6 col-lg-4">
                <form action="" method="post" onsubmit="return validateForm()">
                    <div class="form-outline w-50 m-auto mb-4">
                        <label for="username" class="form-label"><b>Username</b></label>
                        <input type="text" id="username" name="admin_adminname" placeholder="Enter your username" required="required" class="form-control" minlength="3">
                    </div>
                    <div class="form-outline w-50 m-auto mb-4">
                        <label for="email" class="form-label"><b>Email</b></label>
                        <input type="email" id="email" name="admin_email" placeholder="Enter your email" required="required" class="form-control">
                    </div>
                    <div class="form-outline w-50 m-auto mb-4">
                        <label for="password" class="form-label"><b>Password</b></label>
                        <input type="password" id="password" name="admin_password" placeholder="Enter your password" required="required" class="form-control" minlength="6">
                        <small class="text-muted">Minimum 6 characters</small>
                    </div>
                    <div class="form-outline w-50 m-auto mb-4">
                        <label for="confirm_password" class="form-label"><b>Confirm Password</b></label>
                        <input type="password" id="confirm_password" name="conf_admin_password" placeholder="Confirm your password" required="required" class="form-control">
                    </div>
                    <div class="form-outline w-50 m-auto mb-4">
                        <input type="submit" class="btn btn-info py-2 px-3" name="admin_registration" value="Register Admin">
                        <p class="medium fw-bold mt-2 pt-1">Already have an account? <a class="text-danger" href="admin_login.php?key=<?php echo $admin_access_key; ?>"><b>Login</b></a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function validateForm() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        if (password !== confirmPassword) {
            alert('Passwords do not match!');
            return false;
        }
        
        if (password.length < 6) {
            alert('Password must be at least 6 characters long!');
            return false;
        }
        
        return true;
    }
    </script>
</body>
</html>

<!-- PHP code -->
<?php
if(isset($_POST['admin_registration'])){
    $admin_adminname = trim($_POST['admin_adminname']);
    $admin_email = trim($_POST['admin_email']);
    $admin_password = $_POST['admin_password'];
    $conf_admin_password = $_POST['conf_admin_password'];

    // Server-side validation
    if (strlen($admin_adminname) < 3) {
        echo "<script>alert('Username must be at least 3 characters long')</script>";
        exit();
    }

    if (strlen($admin_password) < 6) {
        echo "<script>alert('Password must be at least 6 characters long')</script>";
        exit();
    }

    if (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address')</script>";
        exit();
    }

    // Check if passwords match
    if($admin_password != $conf_admin_password){
        echo "<script>alert('Passwords do not match')</script>";
        exit();
    }

    // Hash the password
    $hash_password = password_hash($admin_password, PASSWORD_DEFAULT);

    // Check for existing admin with prepared statement
    $select_query = "SELECT * FROM `admin_table` WHERE adminname=? OR admin_email=?";
    $stmt = mysqli_prepare($con, $select_query);
    mysqli_stmt_bind_param($stmt, "ss", $admin_adminname, $admin_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows_count = mysqli_num_rows($result);

    if($rows_count > 0){
        echo "<script>alert('Admin Name or Email already exists')</script>";
    } else {
        // Insert new admin with prepared statement
        $insert_query = "INSERT INTO admin_table (adminname, admin_email, admin_password) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt_insert, "sss", $admin_adminname, $admin_email, $hash_password);
        $sql_execute = mysqli_stmt_execute($stmt_insert);
        
        if($sql_execute){
            echo "<script>alert('Admin Registration Successful! You can now login.'); window.location.href='admin_login.php?key=$admin_access_key';</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.')</script>";
        }
    }
}
?>