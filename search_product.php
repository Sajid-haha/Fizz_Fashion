<!-- connect file -->
<?php
include('includes/connect.php');
include('functions/common_function.php');


if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $search = mysqli_real_escape_string($con, $search);

    $query = "SELECT * FROM products WHERE product_title LIKE '%$search%' OR product_discription LIKE '%$search%'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
                setcookie('user_search', $row['product_title'], time() + 86400 * 30, '/');



            $product_id=$row['product_id'];
                $product_title=$row['product_title'];
                $product_discription=$row['product_discription'];
                $product_image1=$row['product_image1'];
                $product_price=$row['product_price'];
                $category_id=$row['category_id'];
                $brand_id=$row['brand_id'];
                echo "<div class='col-md-4 mb-2'>
                <div class='card'>
                    <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
                    <div class='card-body'>
                        <h5 class='card-title'><b>$product_title</b></h5>
                        <p class='card-text'>$product_discription</p>
                        <p class='card-text'><b>Price: $product_price/-</b></p>
                        <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                        <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
                    </div>
                </div>
            </div>";
        }
    } else {
        echo "No products found.";
    }
}

mysqli_close($con);


?>