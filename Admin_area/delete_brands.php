<?php

if (isset($_GET['delete_brands'])) {
  $delete_brands = $_GET['delete_brands'];

  $delete_query = "DELETE FROM `brands` WHERE brand_id=$delete_brands";
  $result = mysqli_query($con, $delete_query);

  if ($result) {
    echo "<script>alert('Brand has been deleted successfully')</script>";
    echo "<script>window.open('./admin_profile.php?view_brands', '_self')</script>";
  }
}

?>
