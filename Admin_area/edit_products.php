<?php
if (isset($_GET['edit_products'])) {
    $edit_id = $_GET['edit_products'];
    $get_data = "SELECT * FROM `products` WHERE product_id = $edit_id";
    $result = mysqli_query($con, $get_data);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $product_title = $row['product_title'];
            $product_discription = $row['product_discription'];
            $product_keywords = $row['product_keywords'];
            $category_id = $row['category_id'];
            $brand_id = $row['brand_id'];
            $product_image1 = $row['product_image1'];
            $product_image2 = $row['product_image2'];
            $product_image3 = $row['product_image3'];
            $product_image4 = $row['product_image4'];
            $product_price = $row['product_price'];

            // fetch category name
            $select_category = "SELECT * FROM `categories` WHERE category_id = $category_id";
            $result_category = mysqli_query($con, $select_category);

            if ($result_category) {
                $row_category = mysqli_fetch_assoc($result_category);
                if ($row_category) {
                    $category_title = $row_category['category_title'];
                } else {
                    $category_title = "Category not found";
                }
            } else {
                die('Error fetching category: ' . mysqli_error($con));
            }

            // fetch brand name
            $select_brand = "SELECT * FROM `brands` WHERE brand_id = $brand_id";
            $result_brand = mysqli_query($con, $select_brand);

            if ($result_brand) {
                $row_brand = mysqli_fetch_assoc($result_brand);
                if ($row_brand) {
                    $brand_title = $row_brand['brand_title'];
                } else {
                    $brand_title = "Brand not found";
                }
            } else {
                die('Error fetching brand: ' . mysqli_error($con));
            }
        } else {
            die("Product with id $edit_id not found");
        }
    } else {
        die('Error fetching product: ' . mysqli_error($con));
    }
}
?>



<div class="contaner mt-5">
    <h1 class="text-center">Edit Product</h1>
    <form action="" method="post" enctype="multipart/form-data">

        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_title" class="form-label"><b>Product Title</b></label>
            <input type="text" id="product_title" value="<?php echo $product_title ?>" name="product_title" class="form-control" required="required">
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_discription" class="form-label"><b>Product Description</b></label>
            <input type="text" id="product_discription" value="<?php echo $product_discription ?>" name="product_discription" class="form-control" required="required">
        </div>

        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_keywords" class="form-label"><b>Product Keywords</b></label>
            <input type="text" id="product_keywords" value="<?php echo $product_keywords ?>" name="product_keywords" class="form-control" required="required">
        </div>


        <div class="form-outline w-50 m-auto mb-4">
    <label for="product_category" class="form-label"><b>Product Categories</b></label>
    <select name="product_category" class="form-select">
        <option value="<?php echo $category_id ?>"><?php echo $category_title ?></option>
        <?php 
        $select_category_all="Select * from `categories`";
        $result_category_all=mysqli_query($con,$select_category_all);
        while($row_category_all=mysqli_fetch_assoc($result_category_all)){
            $category_title_all=$row_category_all['category_title'];
            $category_id_all=$row_category_all['category_id'];
            echo "<option value='$category_id_all'>$category_title_all</option>";
        };
        ?>  
    </select>
</div>

<div class="form-outline w-50 m-auto mb-4">
    <label for="product_brands" class="form-label"><b>Product Brands</b></label>
    <select name="product_brands" class="form-select">
        <option value="<?php echo $brand_id ?>"><?php echo $brand_title ?></option>

        <?php 
        $select_brand_all="Select * from `brands`";
        $result_brand_all=mysqli_query($con,$select_brand_all);
        while($row_brand_all=mysqli_fetch_assoc($result_brand_all)){
            $brand_title_all=$row_brand_all['brand_title'];
            $brand_id_all=$row_brand_all['brand_id'];
            echo "<option value='$brand_id_all'>$brand_title_all</option>";
        };
        
        ?>
    </select>
</div>


        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image1" class="form-label"><b>Product Image1</b></label>
            <div class="d-flex">
            <input type="file" id="product_image1" name="product_image1" class="form-control w-90 m-auto" required="required">
            <img src="./product_images/<?php echo $product_image1 ?>" alt="" class="product_img">
            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image2" class="form-label"><b>Product Image2</b></label>
            <div class="d-flex">
            <input type="file" id="product_image2" name="product_image2" class="form-control w-90 m-auto" required="required">
            <img src="./product_images/<?php echo $product_image2 ?>" alt="" class="product_img">
            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image3" class="form-label"><b>Product Image3</b></label>
            <div class="d-flex">
            <input type="file" id="product_image3" name="product_image3" class="form-control w-90 m-auto" required="required">
            <img src="./product_images/<?php echo $product_image3 ?>" alt="" class="product_img">
            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image4" class="form-label"><b>Product Image4</b></label>
            <div class="d-flex">
            <input type="file" id="product_image4" name="product_image4" class="form-control w-90 m-auto" required="required">
            <img src="./product_images/<?php echo $product_image4 ?>" alt="" class="product_img">
            </div>
        </div>


        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_price" class="form-label"><b>Product Price</b></label>
            <input type="text" id="product_price" name="product_price" class="form-control" required="required" value="<?php echo $product_price ?>">
        </div>

        <div class="text-center">
            <input type="submit" name="edit_product" value="Update Product" class="btn btn-success text-light px-3 mb-3">
        </div>

    </form>
</div>

<!-- Editing Products -->
<?php
if (isset($_POST['edit_product'])) {
    $product_title = mysqli_real_escape_string($con, $_POST['product_title']);
    $product_discription = mysqli_real_escape_string($con, $_POST['product_discription']);
    $product_keywords = mysqli_real_escape_string($con, $_POST['product_keywords']);
    $product_category = mysqli_real_escape_string($con, $_POST['product_category']);
    $product_brand = mysqli_real_escape_string($con, $_POST['product_brands']);
    $product_price = mysqli_real_escape_string($con, $_POST['product_price']);

    $product_image1 = mysqli_real_escape_string($con, $_FILES['product_image1']['name']);
    $product_image2 = mysqli_real_escape_string($con, $_FILES['product_image2']['name']);
    $product_image3 = mysqli_real_escape_string($con, $_FILES['product_image3']['name']);
    $product_image4 = mysqli_real_escape_string($con, $_FILES['product_image4']['name']);

    $temp_image1 = mysqli_real_escape_string($con, $_FILES['product_image1']['tmp_name']);
    $temp_image2 = mysqli_real_escape_string($con, $_FILES['product_image2']['tmp_name']);
    $temp_image3 = mysqli_real_escape_string($con, $_FILES['product_image3']['tmp_name']);
    $temp_image4 = mysqli_real_escape_string($con, $_FILES['product_image4']['tmp_name']);

    // Check for empty fields
    if (
        $product_title == '' or
        $product_discription == '' or
        $product_keywords == '' or
        $product_category == '' or
        $product_brand == '' or
        $product_image1 == '' or
        $product_image2 == '' or
        $product_image3 == '' or
        $product_image4 == '' or
        $product_price == ''
    ) {
        echo "<script>alert('Please fill all the fields and continue the process')</script>";
    } else {
        // Move uploaded files
        move_uploaded_file($temp_image1, "./product_images/$product_image1");
        move_uploaded_file($temp_image2, "./product_images/$product_image2");
        move_uploaded_file($temp_image3, "./product_images/$product_image3");
        move_uploaded_file($temp_image4, "./product_images/$product_image4");

        // Query to update products (assuming $edit_id is defined)
        $update_product = "UPDATE `products` SET 
            product_title='$product_title',
            product_discription='$product_discription',
            product_keywords='$product_keywords',
            category_id='$product_category',
            brand_id='$product_brand',
            product_image1='$product_image1',
            product_image2='$product_image2',
            product_image3='$product_image3',
            product_image4='$product_image4',
            product_price='$product_price',
            date=NOW()
            WHERE product_id = $edit_id";

        // Execute the query (make sure $con is defined)
        $result_update = mysqli_query($con, $update_product);

        if ($result_update) {
            echo "<script>alert('Product updated successfully')</script>";
            echo "<script>window.open('./insert_product.php', '_self')</script>";
        } else {
            echo "Error updating product: " . mysqli_error($con);
        }
    }
}
?>
