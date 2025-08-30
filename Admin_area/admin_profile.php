<!-- connect file -->
<?php
include('../includes/connect.php');
include('../functions/common_function.php');
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['adminname'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FIZZ FASHION - Admin Dashboard</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css file -->
    <link rel="stylesheet" href="../style.css">
    <style> 
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #3498db;
        --success-color: #27ae60;
        --danger-color: #e74c3c;
        --warning-color: #f39c12;
        --info-color: #17a2b8;
        --dark-color: #34495e;
        --light-color: #ecf0f1;
        --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --shadow: 0 10px 30px rgba(0,0,0,0.1);
        --border-radius: 15px;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow-x: hidden;
    }
    
    /* Top Navigation */
    .top-navbar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        box-shadow: var(--shadow);
        padding: 1rem 0;
    }
    
    .logo {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--secondary-color);
    }
    
    .brand-title {
        color: var(--primary-color);
        font-size: 1.5rem;
        font-weight: bold;
        margin-left: 15px;
    }
    
    .admin-info {
        background: var(--gradient-primary);
        color: white;
        padding: 10px 20px;
        border-radius: 25px;
        margin-right: 15px;
    }
    
    .logout-btn {
        background: var(--danger-color);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .logout-btn:hover {
        background: #c0392b;
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }
    
    /* Dashboard Header */
    .dashboard-header {
        background: var(--gradient-secondary);
        color: white;
        padding: 2rem 0;
        text-align: center;
        margin-bottom: 2rem;
        border-radius: 0 0 30px 30px;
    }
    
    .dashboard-title {
        font-size: 2.5rem;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        margin-bottom: 0.5rem;
    }
    
    .dashboard-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
    }
    
    /* Sidebar */
    .sidebar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 2rem;
        margin-bottom: 2rem;
        position: sticky;
        top: 2rem;
        height: fit-content;
    }
    
    .admin-profile {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .admin_image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid var(--secondary-color);
        box-shadow: var(--shadow);
        margin-bottom: 1rem;
    }
    
    .admin-name {
        color: var(--primary-color);
        font-size: 1.2rem;
        font-weight: bold;
    }
    
    /* Navigation Buttons */
    .nav-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    
    .nav-btn {
        background: var(--gradient-primary);
        border: none;
        border-radius: var(--border-radius);
        padding: 0;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .nav-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    
    .nav-btn a {
        display: block;
        color: white;
        text-decoration: none;
        padding: 15px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .nav-btn:hover a {
        color: white;
    }
    
    .nav-btn i {
        margin-right: 10px;
        width: 20px;
    }
    
    /* Special button styles */
    .nav-btn.products { background: var(--success-color); }
    .nav-btn.categories { background: var(--info-color); }
    .nav-btn.brands { background: var(--warning-color); }
    .nav-btn.orders { background: var(--secondary-color); }
    .nav-btn.payments { background: #9b59b6; }
    .nav-btn.users { background: #e67e22; }
    .nav-btn.logout { background: var(--danger-color); }
    
    /* Main Content */
    .main-content {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 2rem;
        min-height: 400px;
    }
    
    /* Product images */
    .product_img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    /* Tables */
    .table {
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
    }
    
    .table thead th {
        background: var(--gradient-primary);
        color: white;
        border: none;
        font-weight: 600;
    }
    
    .table tbody tr {
        transition: all 0.3s ease;
    }
    
    .table tbody tr:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    /* Footer */
    .footer {
        margin-top: 3rem;
        padding: 2rem 0;
        text-align: center;
        color: white;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-title {
            font-size: 2rem;
        }
        
        .nav-buttons {
            flex-direction: column;
        }
        
        .admin_image {
            width: 80px;
            height: 80px;
        }
        
        .sidebar {
            position: relative;
            top: auto;
        }
    }
    
    /* Loading Animation */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Admin Profile Section */
    .admin-profile-section {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .profile-header {
        background: var(--gradient-primary);
        color: white;
        border-radius: var(--border-radius);
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 3s ease-in-out infinite;
    }
    
    @keyframes shimmer {
        0%, 100% { transform: translate(-50%, -50%) rotate(0deg); }
        50% { transform: translate(-50%, -50%) rotate(180deg); }
    }
    
    .profile-avatar {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }
    
    .admin-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    
    .status-indicator {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 20px;
        height: 20px;
        background: #27ae60;
        border-radius: 50%;
        border: 3px solid white;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(39, 174, 96, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(39, 174, 96, 0); }
        100% { box-shadow: 0 0 0 0 rgba(39, 174, 96, 0); }
    }
    
    .profile-name {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .profile-role {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }
    
    .profile-email {
        font-size: 0.9rem;
        opacity: 0.8;
    }
    
    /* Statistics Cards */
    .stat-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        text-align: center;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }
    
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 1rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }
    
    .products-card .stat-icon { background: var(--success-color); }
    .orders-card .stat-icon { background: var(--warning-color); }
    .users-card .stat-icon { background: var(--info-color); }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #6c757d;
        font-weight: 500;
        margin: 0;
    }
    
    /* Quick Actions */
    .quick-actions {
        margin-top: 3rem;
    }
    
    .section-title {
        color: var(--primary-color);
        font-weight: bold;
        margin-bottom: 1.5rem;
    }
    
    .quick-action-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        text-decoration: none;
        color: inherit;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }
    
    .quick-action-card:hover {
        text-decoration: none;
        color: inherit;
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        border-color: var(--secondary-color);
    }
    
    .quick-action-card i {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--gradient-primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    
    .quick-action-card h5 {
        margin-bottom: 0.3rem;
        color: var(--primary-color);
    }
    
    .quick-action-card p {
        margin: 0;
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    /* Recent Activity */
    .recent-activity {
        background: #f8f9fa;
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-top: 2rem;
    }
    
    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .activity-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
    }
    
    .activity-icon.success { background: var(--success-color); }
    .activity-icon.info { background: var(--info-color); }
    .activity-icon.warning { background: var(--warning-color); }
    
    .activity-content h6 {
        margin-bottom: 0.2rem;
        color: var(--primary-color);
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg top-navbar">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <img src="../images/logo.png" alt="Logo" class="logo">
                <span class="brand-title">FIZZ FASHION</span>
            </div>
            
            <div class="d-flex align-items-center">
                <?php
                if(isset($_SESSION['adminname'])){
                    echo "<span class='admin-info'>
                            <i class='fas fa-user-shield me-2'></i>
                            Welcome, " . $_SESSION['adminname'] . "
                          </span>";
                    echo "<a href='admin_logout.php' class='logout-btn'>
                            <i class='fas fa-sign-out-alt me-2'></i>Logout
                          </a>";
                } else {
                    echo "<a href='admin_login.php' class='logout-btn'>
                            <i class='fas fa-sign-in-alt me-2'></i>Login
                          </a>";
                }
                ?>
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <h1 class="dashboard-title">
                <i class="fas fa-tachometer-alt me-3"></i>
                Admin Dashboard
            </h1>
            <p class="dashboard-subtitle">Manage your e-commerce store efficiently</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="sidebar">
                    <div class="admin-profile">
                        <?php if(isset($_SESSION['adminname'])): 
                            $adminname = $_SESSION['adminname'];
                            $get_admin = "SELECT * FROM admin_table WHERE adminname='$adminname'";
                            $result_admin = mysqli_query($con, $get_admin);
                            $admin_data = mysqli_fetch_assoc($result_admin);
                        ?>
                            <img src="../images/admin_image.png" alt="Admin" class="admin_image">
                            <p class="admin-name"><?php echo $admin_data['adminname']; ?></p>
                            <small class="text-muted d-block">Administrator</small>
                            <div class="online-status mt-2">
                                <span class="badge bg-success">
                                    <i class="fas fa-circle me-1" style="font-size: 0.6rem;"></i>Online
                                </span>
                            </div>
                        <?php else: ?>
                            <img src="../images/admin_image.png" alt="Admin" class="admin_image">
                            <p class="admin-name">Guest</p>
                            <small class="text-muted">Please Login</small>
                        <?php endif; ?>
                    </div>
                    
                    <div class="nav-buttons">
                        <button class="nav-btn products">
                            <a href="insert_product.php">
                                <i class="fas fa-plus-circle"></i>Insert Products
                            </a>
                        </button>
                        <button class="nav-btn products">
                            <a href="admin_profile.php?view_products">
                                <i class="fas fa-boxes"></i>View Products
                            </a>
                        </button>
                        <button class="nav-btn categories">
                            <a href="admin_profile.php?insert_category">
                                <i class="fas fa-plus-square"></i>Insert Categories
                            </a>
                        </button>
                        <button class="nav-btn categories">
                            <a href="admin_profile.php?view_category">
                                <i class="fas fa-list-alt"></i>View Categories
                            </a>
                        </button>
                        <button class="nav-btn brands">
                            <a href="admin_profile.php?insert_brands">
                                <i class="fas fa-plus"></i>Insert Brands
                            </a>
                        </button>
                        <button class="nav-btn brands">
                            <a href="admin_profile.php?view_brands">
                                <i class="fas fa-tags"></i>View Brands
                            </a>
                        </button>
                        <button class="nav-btn orders">
                            <a href="admin_profile.php?list_orders">
                                <i class="fas fa-shopping-cart"></i>All Orders
                            </a>
                        </button>
                        <button class="nav-btn payments">
                            <a href="admin_profile.php?list_payments">
                                <i class="fas fa-credit-card"></i>All Payments
                            </a>
                        </button>
                        <button class="nav-btn users">
                            <a href="admin_profile.php?list_users">
                                <i class="fas fa-users"></i>List Users
                            </a>
                        </button>
                        <button class="nav-btn logout">
                            <a href="admin_logout.php">
                                <i class="fas fa-power-off"></i>Logout
                            </a>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-9">
                <div class="main-content">
                    <?php   
                    if(!isset($_GET['insert_category']) && !isset($_GET['insert_brands']) && 
                       !isset($_GET['view_products']) && !isset($_GET['view_category']) && 
                       !isset($_GET['view_brands']) && !isset($_GET['edit_products']) && 
                       !isset($_GET['edit_category']) && !isset($_GET['edit_brands']) && 
                       !isset($_GET['delete_product']) && !isset($_GET['delete_category']) && 
                       !isset($_GET['delete_brands']) && !isset($_GET['list_orders']) && 
                       !isset($_GET['list_payments']) && !isset($_GET['list_users']) && 
                       !isset($_GET['admin_profile'])) {
                        
                        // Display Admin Profile by default after login
                        if(isset($_SESSION['adminname'])){
                            // Get admin details from database
                            $adminname = $_SESSION['adminname'];
                            $get_admin = "SELECT * FROM admin_table WHERE adminname='$adminname'";
                            $result_admin = mysqli_query($con, $get_admin);
                            $admin_data = mysqli_fetch_assoc($result_admin);
                            
                            // Get dashboard statistics
                            $total_products = mysqli_num_rows(mysqli_query($con, "SELECT * FROM products"));
                            $total_categories = mysqli_num_rows(mysqli_query($con, "SELECT * FROM categories"));
                            $total_brands = mysqli_num_rows(mysqli_query($con, "SELECT * FROM brands"));
                            $total_orders = mysqli_num_rows(mysqli_query($con, "SELECT * FROM orders_pending"));
                            $total_users = mysqli_num_rows(mysqli_query($con, "SELECT * FROM user_table"));
                            
                            echo "<div class='admin-profile-section'>
                                    <!-- Admin Profile Header -->
                                    <div class='profile-header text-center mb-5'>
                                        <div class='profile-avatar'>
                                            <img src='../images/admin_image.png' alt='Admin Avatar' class='admin-avatar'>
                                            <div class='status-indicator'></div>
                                        </div>
                                        <h2 class='profile-name'>" . $admin_data['adminname'] . "</h2>
                                        <p class='profile-role'>System Administrator</p>
                                        <p class='profile-email'>" . (isset($admin_data['admin_email']) ? $admin_data['admin_email'] : 'admin@fizzfashion.com') . "</p>
                                    </div>
                                    
                                    <!-- Dashboard Statistics -->
                                    <div class='row g-4 mb-5'>
                                        <div class='col-md-4'>
                                            <div class='stat-card products-card'>
                                                <div class='stat-icon'>
                                                    <i class='fas fa-boxes'></i>
                                                </div>
                                                <div class='stat-content'>
                                                    <h3 class='stat-number'>$total_products</h3>
                                                    <p class='stat-label'>Total Products</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-4'>
                                            <div class='stat-card orders-card'>
                                                <div class='stat-icon'>
                                                    <i class='fas fa-shopping-cart'></i>
                                                </div>
                                                <div class='stat-content'>
                                                    <h3 class='stat-number'>$total_orders</h3>
                                                    <p class='stat-label'>Total Orders</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-4'>
                                            <div class='stat-card users-card'>
                                                <div class='stat-icon'>
                                                    <i class='fas fa-users'></i>
                                                </div>
                                                <div class='stat-content'>
                                                    <h3 class='stat-number'>$total_users</h3>
                                                    <p class='stat-label'>Total Users</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Quick Actions -->
                                    <div class='quick-actions'>
                                        <h3 class='section-title mb-4'>
                                            <i class='fas fa-bolt me-2'></i>Quick Actions
                                        </h3>
                                        <div class='row g-3'>
                                            <div class='col-md-6'>
                                                <a href='insert_product.php' class='quick-action-card'>
                                                    <i class='fas fa-plus-circle'></i>
                                                    <div>
                                                        <h5>Add New Product</h5>
                                                        <p>Add products to your inventory</p>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class='col-md-6'>
                                                <a href='admin_profile.php?view_products' class='quick-action-card'>
                                                    <i class='fas fa-eye'></i>
                                                    <div>
                                                        <h5>View Products</h5>
                                                        <p>Manage existing products</p>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class='col-md-6'>
                                                <a href='admin_profile.php?list_orders' class='quick-action-card'>
                                                    <i class='fas fa-list-alt'></i>
                                                    <div>
                                                        <h5>Manage Orders</h5>
                                                        <p>Process customer orders</p>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class='col-md-6'>
                                                <a href='admin_profile.php?list_users' class='quick-action-card'>
                                                    <i class='fas fa-user-cog'></i>
                                                    <div>
                                                        <h5>Manage Users</h5>
                                                        <p>View customer accounts</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Recent Activity -->
                                    <div class='recent-activity mt-5'>
                                        <h3 class='section-title mb-4'>
                                            <i class='fas fa-clock me-2'></i>Recent Activity
                                        </h3>
                                        <div class='activity-list'>
                                            <div class='activity-item'>
                                                <div class='activity-icon success'>
                                                    <i class='fas fa-check'></i>
                                                </div>
                                                <div class='activity-content'>
                                                    <h6>System Status: Online</h6>
                                                    <small class='text-muted'>All systems operational</small>
                                                </div>
                                            </div>
                                            <div class='activity-item'>
                                                <div class='activity-icon info'>
                                                    <i class='fas fa-info'></i>
                                                </div>
                                                <div class='activity-content'>
                                                    <h6>Admin Login</h6>
                                                    <small class='text-muted'>Logged in as " . $adminname . "</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>";
                        } else {
                            // If not logged in, show login prompt
                            echo "<div class='text-center'>
                                    <h2 class='text-warning mb-4'>
                                        <i class='fas fa-exclamation-triangle me-3'></i>Access Denied
                                    </h2>
                                    <p class='text-muted mb-4'>Please log in to access the admin dashboard</p>
                                    <a href='admin_login.php' class='btn btn-primary btn-lg'>
                                        <i class='fas fa-sign-in-alt me-2'></i>Go to Login
                                    </a>
                                  </div>";
                        }
                    }
                    
                    // Include pages based on GET parameters
                    if(isset($_GET['insert_category'])){
                        include('insert_categories.php');
                    }
                    if(isset($_GET['insert_brands'])){
                        include('insert_brands.php');
                    }
                    if(isset($_GET['view_products'])){
                        include('view_products.php');
                    }
                    if(isset($_GET['view_category'])){
                        include('view_category.php');
                    }
                    if(isset($_GET['view_brands'])){
                        include('view_brands.php');
                    }
                    if(isset($_GET['edit_products'])){
                        include('edit_products.php');
                    }
                    if(isset($_GET['edit_category'])){
                        include('edit_category.php');
                    }
                    if(isset($_GET['edit_brands'])){
                        include('edit_brands.php');
                    }
                    if(isset($_GET['delete_product'])){
                        include('delete_product.php');
                    }
                    if(isset($_GET['delete_category'])){
                        include('delete_category.php');
                    }
                    if(isset($_GET['delete_brands'])){
                        include('delete_brands.php');
                    }
                    if(isset($_GET['list_orders'])){
                        include('list_orders.php');
                    }
                    if(isset($_GET['list_payments'])){
                        include('list_payments.php');
                    }
                    if(isset($_GET['list_users'])){
                        include('list_users.php');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <?php include("../includes/footer.php")?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- Custom JavaScript for enhanced interactions -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Add loading state to buttons
        document.querySelectorAll('.nav-btn a').forEach(button => {
            button.addEventListener('click', function(e) {
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="loading"></span> Loading...';
                
                // Restore original text after 2 seconds (adjust as needed)
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            });
        });
    });
    </script>
</body>
</html>