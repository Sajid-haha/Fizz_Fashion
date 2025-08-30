<?php
include('../includes/connect.php');
if (isset($_POST['insert_brand'])) {
    $brand_title = $_POST['brand_title'];

    // Select data from database
    $select_query = "SELECT * FROM `brands` WHERE brand_title='$brand_title'";
    $result_select = mysqli_query($con, $select_query);
    $number = mysqli_num_rows($result_select);
    if ($number > 0) {
        echo "<script>alert('This Brand is already present in the database')</script>";
    } else {
        $insert_query = "INSERT INTO `brands` (brand_title) VALUES ('$brand_title')";
        $result = mysqli_query($con, $insert_query);
        if ($result) {
            echo "<script>alert('Brand has been inserted successfully')</script>";
        } else {
            echo "<script>alert('Error inserting brand: " . mysqli_error($con) . "')</script>";
        }
    }
}
?>

<h2 class="text-center">Insert Brands</h2>

<form action="" method="post" class="mb-2">
<div class="input-group w-90 mb-2 flex-nowrap">
  <span class="input-group-text bg-info" id="addon-wrapping"><i class="fa-solid fa-receipt"></i></span>
  <input type="text" class="form-control" name="brand_title" 
  placeholder="Insert Brands" aria-label="brands" aria-describedby="addon-wrapping">
</div>
<div class="input-group w-10 mb-2 m-auto">
<button class="btn btn-outline-secondary bg-info" type="submit" name="insert_brand" id="button-addon1">Insert Brands</button>
</div>
</form>