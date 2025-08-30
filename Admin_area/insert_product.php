<?php
include('../includes/connect.php');

if (isset($_POST['insert_product'])) {
    $product_title = $_POST['product_title'];
    $discription = $_POST['discription'];
    $keywords = $_POST['keywords'];
    $category_id = $_POST['product_categories'];
    $brand_id = $_POST['product_brands'];
    $product_price = $_POST['product_price'];
    $product_status = 'true';

    // Store errors
    $errors = [];

    // Check if files are images
    $allowed_image_types = ["image/jpeg", "image/jpg", "image/png", "image/gif"];
    foreach (['product_image1', 'product_image2', 'product_image3', 'product_image4'] as $image_name) {
        if (!in_array($_FILES[$image_name]['type'], $allowed_image_types)) {
            $errors[] = "$image_name is not a valid image.";
        }
    }

    // If there are any errors, display them and exit
    if (!empty($errors)) {
        echo "<script>alert('" . implode(", ", $errors) . "')</script>";
        exit();
    }

    if (empty($product_title) || empty($discription) || empty($keywords) || empty($category_id) || empty($brand_id) || empty($product_price)) {
        echo "<script>alert('Please fill all the available fields')</script>";
        exit();
    } else {
        $stmt = $con->prepare("INSERT INTO `products` (product_title, product_discription, product_keywords, category_id, brand_id, product_image1, product_image2, product_image3, product_image4, product_price, date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");

        $stmt->bind_param("sssssssssss", $product_title, $discription, $keywords, $category_id, $brand_id, $_FILES['product_image1']['name'], $_FILES['product_image2']['name'], $_FILES['product_image3']['name'], $_FILES['product_image4']['name'], $product_price, $product_status);

        if ($stmt->execute()) {
            foreach (['product_image1', 'product_image2', 'product_image3', 'product_image4'] as $image_name) {
                move_uploaded_file($_FILES[$image_name]['tmp_name'], "./product_images/" . $_FILES[$image_name]['name']);
            }
            echo "<script>alert('Successfully inserted the Products')</script>";
        } else {
            echo "<script>alert('Error inserting the product. Please try again.')</script>";
        }
        $stmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products - Admin Dashboard</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- css file -->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Insert Products</h1>
        <!-- form -->
        <form action="" method="post" enctype="multipart/form-data">
            <!-- title -->
            <div class="form-outline mb-4 m-auto w-50">
                <label for="product_title" class="form-label">Product title</label>
                <input type="text" name="product_title" id="product_title" class="form-control" 
                placeholder="Enter product title" autocomplete="off" required="required">
            </div>

            <!-- discription -->
            <div class="form-outline mb-4 m-auto w-50">
                <label for="discription" class="form-label">Product discription</label>
                <input type="text" name="discription" id="discription" class="form-control" 
                placeholder="Enter product discription" autocomplete="off" required="required">
            </div>

            <!-- keywords -->
            <div class="form-outline mb-4 m-auto w-50">
                <label for="keywords" class="form-label">Product keywords</label>
                <input type="text" name="keywords" id="keywords" class="form-control" 
                placeholder="Enter product keywords" autocomplete="off" required="required">
            </div>

            <!-- Categories -->
            <div class="form-outline mb-4 m-auto w-50">
                <select name="product_categories" id="" class="form-select">
                    <option value="">Select a Category</option>
                    <?php
                        $select_query="SELECT * FROM `categories`";
                        $result_query=mysqli_query($con, $select_query);
                        while($row=mysqli_fetch_assoc($result_query)){
                            $category_title=$row['category_title'];
                            $category_id=$row['category_id'];
                            echo "<option value='$category_id'>$category_title</option>";
                        }
                    ?>
                </select>
            </div>

            <!-- Brands -->
            <div class="form-outline mb-4 m-auto w-50">
                <select name="product_brands" id="" class="form-select">
                    <option value="">Select a Brand</option>
                    <?php
                        $select_query="SELECT * FROM `brands`";
                        $result_query=mysqli_query($con, $select_query);
                        while($row=mysqli_fetch_assoc($result_query)){
                            $brand_title=$row['brand_title'];
                            $brand_id=$row['brand_id'];
                            echo "<option value='$brand_id'>$brand_title</option>";
                        }
                    ?>
                </select>
            </div>
           
            <!-- Image 1 -->
           <div class="form-outlibe mb-4 m-auto w-50">
              <label for="product_image1" class="form-label">Product Image 1</label>
              <input type="file" name="product_image1" id="product_image1" class="form-control" 
              placeholder="Enter product image1" required="required">
           </div>

           <!-- Image 2 -->
           <div class="form-outlibe mb-4 m-auto w-50">
              <label for="product_image2" class="form-label">Product Image 2</label>
              <input type="file" name="product_image2" id="product_image2" class="form-control" 
              placeholder="Enter product image2" required="required">
           </div>

           <!-- Image 3 -->
           <div class="form-outlibe mb-4 m-auto w-50">
              <label for="product_image3" class="form-label">Product Image 3</label>
              <input type="file" name="product_image3" id="product_image1" class="form-control" 
              placeholder="Enter product image1" required="required">
           </div>

           <!-- Image 4 -->
           <div class="form-outlibe mb-4 m-auto w-50">
              <label for="product_image4" class="form-label">Product Image 4</label>
              <input type="file" name="product_image4" id="product_image4" class="form-control" 
              placeholder="Enter product image4" required="required">
           </div>

           <!-- Price -->
            <div class="form-outline mb-4 m-auto w-50">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="text" name="product_price" id="product_price" class="form-control" 
                placeholder="Enter product price" autocomplete="off" required="required">
            </div>

            <!-- Price -->
            <div class="form-outline text-center mb-4 m-auto w-50">
                <input type="submit" name="insert_product" class="btn btn-success mb-3 px-3" value="Insert Products">
            </div>
        </form>
    </div>

    <!-- last child-->
    <?php include("../includes/footer.php")?>
    
</body>
</html>