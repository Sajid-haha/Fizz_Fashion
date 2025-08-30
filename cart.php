<?php
include('includes/connect.php');
include('functions/common_function.php');
$total = 0;
session_start();

// Handle AJAX requests for real-time updates
if (isset($_POST['ajax_update']) && $_POST['ajax_update'] == 'true') {
    $get_ip_add = getIPAddress();
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    
    if ($quantity > 0) {
        $update_cart = $con->prepare("UPDATE cart_details SET quantity=? WHERE ip_address=? AND product_id=?");
        $update_cart->bind_param("isi", $quantity, $get_ip_add, $product_id);
        $update_cart->execute();
        
        // Get updated price
        $select_product = "SELECT product_price FROM products WHERE product_id=?";
        $stmt = $con->prepare($select_product);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $item_total = $row['product_price'] * $quantity;
        
        echo json_encode(['success' => true, 'item_total' => $item_total]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid quantity']);
    }
    exit();
}

// Handle item removal via AJAX
if (isset($_POST['ajax_remove']) && $_POST['ajax_remove'] == 'true') {
    $get_ip_add = getIPAddress();
    $product_id = (int)$_POST['product_id'];
    
    $delete_query = "DELETE FROM cart_details WHERE product_id=? AND ip_address=?";
    $stmt = $con->prepare($delete_query);
    $stmt->bind_param("is", $product_id, $get_ip_add);
    $success = $stmt->execute();
    
    echo json_encode(['success' => $success]);
    exit();
}

// Handle bulk operations (Update Cart button)
if (isset($_POST['update_cart'])) {
    global $con;
    $get_ip_add = getIPAddress();
    $selected_products = isset($_POST['selected_products']) ? $_POST['selected_products'] : [];

    // Update quantity for all products in cart
    foreach ($_POST['qty'] as $product_id => $quantity) {
        $quantity = (int)$quantity;
        if ($quantity > 0) {
            $update_cart = $con->prepare("UPDATE cart_details SET quantity=? WHERE ip_address=? AND product_id=?");
            $update_cart->bind_param("isi", $quantity, $get_ip_add, $product_id);
            $update_cart->execute();
        }
    }
}

// Enhanced total price calculation for selected products
function calculate_total_cart_price($selected_products = []) {
    global $con;
    $get_ip_add = getIPAddress();
    $total_cart_price = 0;

    if (!empty($selected_products)) {
        foreach ($selected_products as $product_id) {
            $cart_query = "SELECT quantity FROM cart_details WHERE ip_address=? AND product_id=?";
            $stmt = $con->prepare($cart_query);
            $stmt->bind_param("si", $get_ip_add, $product_id);
            $stmt->execute();
            $cart_result = $stmt->get_result();
            $quantity = 0;
            if ($cart_row = $cart_result->fetch_assoc()) {
                $quantity = $cart_row['quantity'];
            }

            $select_products = "SELECT product_price FROM products WHERE product_id=?";
            $stmt2 = $con->prepare($select_products);
            $stmt2->bind_param("i", $product_id);
            $stmt2->execute();
            $result_products = $stmt2->get_result();
            if ($row_product_price = $result_products->fetch_assoc()) {
                $product_price = $row_product_price['product_price'];
                $total_cart_price += $product_price * $quantity;
            }
        }
    } else {
        $cart_query = "SELECT * FROM cart_details WHERE ip_address=?";
        $stmt = $con->prepare($cart_query);
        $stmt->bind_param("s", $get_ip_add);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];

            $select_products = "SELECT product_price FROM products WHERE product_id=?";
            $stmt2 = $con->prepare($select_products);
            $stmt2->bind_param("i", $product_id);
            $stmt2->execute();
            $result_products = $stmt2->get_result();
            if ($row_product_price = $result_products->fetch_assoc()) {
                $product_price = $row_product_price['product_price'];
                $total_cart_price += $product_price * $quantity;
            }
        }
    }

    return $total_cart_price;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Website - FIZZ FASHION - Cart Details</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- css file -->
    <link rel="stylesheet" href="style.css">
    <style>
        .cart_img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }
        .total-display {
            font-size: 1.2em;
            font-weight: bold;
            color: #dc3545;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .quantity-controls button {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .quantity-controls input {
            width: 60px;
            text-align: center;
            border: 1px solid #ddd;
            border-left: none;
            border-right: none;
        }
        .remove-btn {
            color: #dc3545;
            cursor: pointer;
            font-size: 1.2em;
        }
        .remove-btn:hover {
            color: #a71e2a;
        }
        .updating {
            opacity: 0.6;
            pointer-events: none;
        }
        .select-all-container {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="./images/logo.png" alt="" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php"><b>Home</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="display_all.php"><b>Products</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><b>Contact</b></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup><?php cart_item(); ?></sup></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- calling cart function -->
        <?php cart(); ?>

        <!-- third child-->
        <div class="bg-light">
            <h3 class="text-center text-dark"><b>Mens Store</b></h3>
            <p class="text-center">Communication is at the heart of E-commerce and community</p>
        </div>

        <!-- product details table -->
        <div class="container">
            <div class="row">
                <form action="" method="post" id="cartForm">
                    
<?php 
global $con;
$get_ip_add = getIPAddress();
$cart_query = "SELECT * FROM cart_details WHERE ip_address='$get_ip_add'";
$result = mysqli_query($con, $cart_query);
$result_count = mysqli_num_rows($result);

// Get currently selected products if form was submitted
$selected_products = isset($_POST['selected_products']) ? $_POST['selected_products'] : [];

if($result_count > 0){
?>
                    <!-- Select All Controls -->
                    <div class="select-all-container">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <input type="checkbox" id="selectAllCheckbox" onchange="selectAllProducts()">
                                <label for="selectAllCheckbox" class="ms-2"><strong>Select All Items</strong></label>
                            </div>
                            <div>
                                <small class="text-muted">Auto-save enabled - changes save automatically</small>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered text-center">
                        <thead class="table-info">
                            <tr>
                                <th>Select</th>
                                <th>Product Title</th>
                                <th>Product Image</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
<?php
if ($result) {
    while ($row = mysqli_fetch_array($result)) {
        $product_id = $row['product_id'];
        $select_products = "SELECT * FROM products WHERE product_id='$product_id'";
        $result_products = mysqli_query($con, $select_products);
        if ($result_products) {
            while ($row_product_price = mysqli_fetch_array($result_products)) {
                $product_price = $row_product_price['product_price'];
                $product_title = $row_product_price['product_title'];
                $product_image = $row_product_price['product_image1'];
                $product_id = $row_product_price['product_id'];
                $select_cart = "SELECT * FROM cart_details WHERE product_id='$product_id' AND ip_address='$get_ip_add'";
                $result_cart = mysqli_query($con, $select_cart);
                $row_cart = mysqli_fetch_assoc($result_cart);
                $quantity = $row_cart['quantity'];
                
                $is_selected = in_array($product_id, $selected_products);
                $item_total = $product_price * $quantity;
?>
                            <tr id="row_<?php echo $product_id ?>">
                                <td>
                                    <input type="checkbox" 
                                           name="selected_products[]" 
                                           value="<?php echo $product_id ?>" 
                                           class="product-checkbox" 
                                           data-price="<?php echo $product_price ?>" 
                                           data-product-id="<?php echo $product_id ?>"
                                           <?php echo $is_selected ? 'checked' : ''; ?>
                                           onchange="updateTotal()">
                                </td>
                                <td><?php echo $product_title?></td>
                                <td><img src="./admin_area/product_images/<?php echo $product_image?>" alt="" class="cart_img"></td>
                                <td>
                                    <div class="quantity-controls">
                                        <button type="button" onclick="changeQuantity(<?php echo $product_id ?>, -1)">-</button>
                                        <input type="number" 
                                               name="qty[<?php echo $product_id ?>]" 
                                               id="qty_<?php echo $product_id ?>"
                                               value="<?php echo $quantity ?>" 
                                               min="1" max="99"
                                               data-product-id="<?php echo $product_id ?>"
                                               onchange="updateQuantityAjax(<?php echo $product_id ?>, this.value)"
                                               readonly>
                                        <button type="button" onclick="changeQuantity(<?php echo $product_id ?>, 1)">+</button>
                                    </div>
                                </td>
                                <td>$<?php echo number_format($product_price, 2) ?></td>
                                <td class="item-total" data-product-id="<?php echo $product_id ?>">
                                    $<span id="total_<?php echo $product_id ?>"><?php echo number_format($item_total, 2) ?></span>
                                </td>
                                <td>
                                    <i class="fas fa-trash remove-btn" 
                                       onclick="removeItem(<?php echo $product_id ?>)" 
                                       title="Remove item"></i>
                                </td>
                            </tr>
<?php 
            }
        }
    }
}
?>
                        </tbody>
                    </table>

                    <!-- Operations and Subtotal -->
                    <div class="d-flex mb-5 justify-content-between align-items-center">
                        <div>
                            <input type="submit" value="Update Selected Items" class="btn btn-info" name="update_cart">
                            <input type="submit" value="Remove Selected" class="btn btn-danger" name="remove_cart">
                        </div>
                        
                        <div>
                            <h4 class='px-3'>Selected Items Total: <span class='total-display' id='totalPrice'>$0.00</span></h4>
                            <input type='submit' value='Continue Shopping' class='btn btn-info' name='continue_shopping'>
                            <button class='btn btn-success' type='button' onclick='proceedToCheckout()'>Checkout Selected Items</button>
                        </div>
                    </div>

<?php 
} else {
    echo "<div class='text-center py-5'>
            <h2 class='text-danger'>Cart is empty</h2>
            <p>Add some products to your cart to get started!</p>
            <a href='index.php' class='btn btn-info'>Continue Shopping</a>
          </div>";
}
?>

                </form>
            </div>
        </div>
    </div>

<!-- Enhanced JavaScript with AJAX -->
<script>
// Change quantity with +/- buttons
function changeQuantity(productId, change) {
    const input = document.getElementById('qty_' + productId);
    const currentValue = parseInt(input.value) || 1;
    const newValue = Math.max(1, Math.min(99, currentValue + change));
    
    if (newValue !== currentValue) {
        input.value = newValue;
        updateQuantityAjax(productId, newValue);
    }
}

// AJAX update quantity
function updateQuantityAjax(productId, quantity) {
    const row = document.getElementById('row_' + productId);
    row.classList.add('updating');
    
    fetch('', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `ajax_update=true&product_id=${productId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const totalSpan = document.getElementById('total_' + productId);
            totalSpan.textContent = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(data.item_total);
            
            updateTotal();
        }
        row.classList.remove('updating');
    })
    .catch(error => {
        console.error('Error:', error);
        row.classList.remove('updating');
    });
}

// Remove item with AJAX
function removeItem(productId) {
    if (confirm('Are you sure you want to remove this item from your cart?')) {
        const row = document.getElementById('row_' + productId);
        row.classList.add('updating');
        
        fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `ajax_remove=true&product_id=${productId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                row.remove();
                updateTotal();
                
                // Check if cart is empty
                const tbody = document.querySelector('tbody');
                if (!tbody.children.length) {
                    location.reload();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            row.classList.remove('updating');
        });
    }
}

// Select all functionality
function selectAllProducts() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.product-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    
    updateTotal();
}

// Update total calculation
function updateTotal() {
    let total = 0;
    const checkboxes = document.querySelectorAll('.product-checkbox:checked');
    
    checkboxes.forEach(checkbox => {
        const productId = checkbox.getAttribute('data-product-id');
        const totalSpan = document.getElementById('total_' + productId);
        const itemTotal = parseFloat(totalSpan.textContent.replace(/,/g, '')) || 0;
        total += itemTotal;
    });
    
    document.getElementById('totalPrice').textContent = '$' + new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(total);
    
    // Update select all checkbox state
    const allCheckboxes = document.querySelectorAll('.product-checkbox');
    const checkedCheckboxes = document.querySelectorAll('.product-checkbox:checked');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.checked = allCheckboxes.length === checkedCheckboxes.length && allCheckboxes.length > 0;
        selectAllCheckbox.indeterminate = checkedCheckboxes.length > 0 && checkedCheckboxes.length < allCheckboxes.length;
    }
}

// Proceed to checkout
function proceedToCheckout() {
    const selectedProducts = document.querySelectorAll('.product-checkbox:checked');
    
    if (selectedProducts.length === 0) {
        alert('Please select at least one product to checkout.');
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = './users_area/checkout.php';
    
    selectedProducts.forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'selected_products[]';
        input.value = checkbox.value;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    form.submit();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.product-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotal);
    });
    
    updateTotal();
});
</script>

<?php 
// Enhanced function to remove selected items
function remove_cart_item(){
    global $con;
    if(isset($_POST['remove_cart']) && isset($_POST['removeitem'])){
        $get_ip_add = getIPAddress();
        foreach($_POST['removeitem'] as $remove_id){
            $delete_query = "DELETE FROM cart_details WHERE product_id=? AND ip_address=?";
            $stmt = $con->prepare($delete_query);
            $stmt->bind_param("is", $remove_id, $get_ip_add);
            $run_delete = $stmt->execute();
            if($run_delete){
                echo "<script>window.open('cart.php','_self')</script>";
            }
        }
    }
}

if(isset($_POST['continue_shopping'])){
    echo "<script>window.open('index.php','_self')</script>";
}

remove_cart_item();
?>

    <!-- bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>