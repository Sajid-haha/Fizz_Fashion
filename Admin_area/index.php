<!-- connect file -->
<?php
include('../includes/connect.php');
include('../functions/common_function.php');
@session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style> 
    .body{
      overflow-x:hidden;
    }
    .img-fluid{
        width: 1500px;<?php
// Method 1: Create a separate admin directory with .htaccess protection
// Create a folder called 'admin' and move your admin files there
// Then create an .htaccess file in the admin folder:

/*
# .htaccess file content for admin folder
AuthType Basic
AuthName "Admin Area"
AuthUserFile /path/to/.htpasswd
Require valid-user

# Or block direct access
<Files "*.php">
    Order Allow,Deny
    Deny from all
</Files>
*/

// Method 2: Add access control to admin pages
// Add this at the top of your admin_login.php and admin_registration.php files:

// Check if accessing directly from index or unauthorized source
if (!isset($_SERVER['HTTP_REFERER']) || 
    (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'index.php') !== false)) {
    // Redirect to index page or show 404
    header("Location: index.php");
    exit();
}

// Method 3: Create a hidden admin access route
// In your index.php, add this hidden trigger:
if (isset($_GET['admin_access']) && $_GET['admin_access'] === 'secure_key_123') {
    // Show admin login link or redirect
    header("Location: admin/admin_login.php");
    exit();
}

// Method 4: Session-based access control
// Add this to the top of admin pages:
session_start();
if (!isset($_SESSION['admin_access_granted'])) {
    // Check for special access code
    if (isset($_POST['access_code']) && $_POST['access_code'] === 'your_secret_code') {
        $_SESSION['admin_access_granted'] = true;
    } else {
        // Show access code form or redirect
        header("Location: index.php");
        exit();
    }
}

// Method 5: IP-based restriction (if you have fixed admin IPs)
function checkAdminIP() {
    $allowed_ips = array('192.168.1.100', '10.0.0.50'); // Add your admin IPs
    $user_ip = $_SERVER['REMOTE_ADDR'];
    
    if (!in_array($user_ip, $allowed_ips)) {
        header("HTTP/1.0 404 Not Found");
        exit("Page not found");
    }
}

// Method 6: Remove admin links from navigation
// In your index.php navigation, comment out or remove admin links:
/*
<!-- Remove or comment these lines from your navigation -->
<a href="admin_login.php">Admin Login</a>
<a href="admin_registration.php">Admin Registration</a>
*/

// Method 7: Rename admin files to obscure names
// Rename your files to something non-obvious:
// admin_login.php -> sys_auth_portal.php
// admin_registration.php -> sys_reg_portal.php

// Method 8: Create a secure admin entrance
// Create a new file: secure_admin_entrance.php
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Access</title>
    <style>
        body { 
            background: #000; 
            color: #0f0; 
            font-family: monospace; 
            text-align: center; 
            padding-top: 100px; 
        }
    </style>
</head>
<body>
    <form method="post">
        <h3>Access Code Required</h3>
        <input type="password" name="access_code" placeholder="Enter access code" required>
        <button type="submit">Enter</button>
    </form>
    
    <?php
    if (isset($_POST['access_code']) && $_POST['access_code'] === 'your_secret_code') {
        session_start();
        $_SESSION['admin_access_granted'] = true;
        header("Location: admin_login.php");
        exit();
    }
    ?>
</body>
</html>

<?php
// Method 9: Modified admin_login.php with access control
// Replace your existing admin_login.php content with this enhanced version:

include('../includes/connect.php');
include('../functions/common_function.php');
@session_start();

// Security check - prevent direct access from index
$allowed_referrers = array('secure_admin_entrance.php', 'admin_profile.php');
$referrer = isset($_SERVER['HTTP_REFERER']) ? basename($_SERVER['HTTP_REFERER']) : '';

if (!isset($_SESSION['admin_access_granted']) && !in_array($referrer, $allowed_referrers)) {
    header("HTTP/1.0 404 Not Found");
    exit("Page not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Authentication</title>
    <!-- Rest of your existing head content -->
</head>
<body>
    <!-- Your existing body content -->
</body>
</html>

<?php
// Your existing PHP login logic here
if(isset($_POST['admin_login'])){
    $admin_adminname=$_POST['username'];
    $admin_password=$_POST['password'];

    // Add additional security: escape inputs
    $admin_adminname = mysqli_real_escape_string($con, $admin_adminname);
    
    $select_query="SELECT * FROM `admin_table` WHERE adminname='$admin_adminname'";
    $result=mysqli_query($con,$select_query);
    $row_count=mysqli_num_rows($result);
    $row_data=mysqli_fetch_assoc($result);

    if($row_count>0){
        if(password_verify($admin_password, $row_data['admin_password'])){
            $_SESSION['adminname']=$admin_adminname;
            $_SESSION['admin_logged_in'] = true;
            echo "<script>alert('Login Successful')</script>";
            echo "<script>window.open('admin_profile.php' , '_self')</script>";
        } else {
            echo "<script>alert('Invalid Password')</script>";
        }
    } else {
        echo "<script>alert('Invalid Admin Name')</script>";
    }
}
?>
        height: 650px;
        object-fit: contain;
    } 

    </style>
</head>
<body>
    <div class="container-fluid m-3">
        <h2 class="text-center mb-5">Admin Login</h2>
        <div class="row d-flex justify-content-center ">
            <div class="col-lg-6 col-lg-5">
                <img src="../images/admin_login.jpg" alt="Admin Login" class="img-fluid">
            </div>
            <div class="col-lg-6 col-lg-4">
                <form action="" method="post">
                    <div class="form-outline w-50 m-auto mb-4">
                        <label for="username" class="form-label"><b>Username</b></label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required="required" class="form-control">
                    </div>
                    <div class="form-outline w-50 m-auto mb-4">
                        <label for="password" class="form-label"><b>Password</b></label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required="required" class="form-control">
                        <p class="message"> <a href="#" class="text-info mt-2 pt-2">Forgot password</a></p>
                    </div>
                    <div class="form-outline w-50 m-auto mb-4">
                        <input type="submit" class="bg-info py-2 px-3 border-0" name="admin_login" value="Login">
                        <p class="medium fw-bold mt-2 pt-1 ">Don't have an account? <a class="text-success" href="admin_registration.php"><b>Register</b></a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


<!-- Php code -->
<?php
if(isset($_POST['admin_login'])){
    $admin_adminname=$_POST['username'];
    $admin_password=$_POST['password'];

    $select_query="SELECT * FROM `admin_table` WHERE adminname='$admin_adminname'";
    $result=mysqli_query($con,$select_query);
    $row_count=mysqli_num_rows($result);
    $row_data=mysqli_fetch_assoc($result);

    if($row_count>0){
        if(password_verify($admin_password, $row_data['admin_password'])){
            $_SESSION['adminname']=$admin_adminname;
            echo "<script>alert('Login Successful')</script>";
            echo "<script>window.open('admin_profile.php' , '_self')</script>";
        } else {
            echo "<script>alert('Invalid Password')</script>";
        }
    } else {
        echo "<script>alert('Invalid Admin Name')</script>";
    }
}
?>
