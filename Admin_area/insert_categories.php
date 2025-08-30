<?php 
include('../includes/connect.php');
if (isset($_POST['insert_cat'])) {
    $category_title = $_POST['cat_title'];

    // Select data from database
    $select_query = "SELECT * FROM `categories` WHERE category_title='$category_title'";
    $result_select = mysqli_query($con, $select_query);
    $number = mysqli_num_rows($result_select);
    if ($number > 0) {
        echo "<script>alert('This Category is already present in the database')</script>";
    } else {
        $insert_query = "INSERT INTO `categories` (category_title) VALUES ('$category_title')";
        $result = mysqli_query($con, $insert_query);
        if ($result) {
            echo "<script>alert('Category has been inserted successfully')</script>";
        } else {
            echo "<script>alert('Error inserting category: " . mysqli_error($con) . "')</script>";
        }
    }
}
?>

<h2 class="text-center">Insert Categories</h2>





<form action="" method="post" class="mb-2">
<div class="input-group w-90 mb-2 flex-nowrap">
  <span class="input-group-text bg-info" id="addon-wrapping"><i class="fa-solid fa-receipt"></i></span>
  <input type="text" class="form-control" name="cat_title" placeholder="Insert categories" 
  aria-label="Username" aria-describedby="addon-wrapping">
</div>
<div class="input-group w-10 mb-2 m-auto">
<button class="btn btn-outline-secondary bg-info" type="submit" name="insert_cat" id="button-addon1">Insert Categories</button>
</div>
</form>