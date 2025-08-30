<?php
    $get_payments = "SELECT * FROM `user_table`";
    $result = mysqli_query($con, $get_payments);
    $row_count = mysqli_num_rows($result);
?>

<h3 class="text-center text-success">All users</h3> 
<table class="table table-bordered mt-5">
    <thead class="bg-info text-center">
        <tr>
            <th>Sl no</th>
            <th>Username</th> 
            <th>User email</th>
            <th>User address</th> 
            <th>User mobile</th> 
        </tr>    
    </thead>
    <tbody class="bg-secondary text-light text-center">
        <?php
            if($row_count == 0){
                echo "<h2 class='bg-danger text-center mt-5'>No users yet</h2>";
            }else{
                $number = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $user_id = $row['user_id'];
                    $username = $row['username'];
                    $user_email = $row['user_email'];
                    $user_address = $row['user_address'];
                    $user_mobile = $row['user_mobile'];
                    $number++;
                    echo
                    "<tr'>
                    <td>$number</td>
                    <td>$username</td>
                    <td>$user_email</td>
                    <td>$user_address</td>
                    <td>$user_mobile</td>
                    </tr>";
                }
            }
        ?>
    </tbody>
</table>
