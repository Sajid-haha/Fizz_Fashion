<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "fizz_fashion";

$con = mysqli_connect ($servername, $username, $password, $database);

if (!$con) {
    die(mysqli_error($con));
}

?>
