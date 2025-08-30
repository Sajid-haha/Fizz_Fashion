<?php
    $get_payments = "SELECT * FROM `user_payments`";
    $result = mysqli_query($con, $get_payments);
    $row_count = mysqli_num_rows($result);
?>

<h3 class="text-center text-success">All payments</h3> 
<table class="table table-bordered mt-5">
    <thead class="bg-info">
        <tr>
            <th>Order Number</th>
            <th>Invoice Number</th> 
            <th>Amount</th>
            <th>Payment mode</th> 
            <th>Order date</th> 
        </tr>    
    </thead>
    <tbody class="bg-secondary text-light">
        <?php
            if($row_count == 0){
                echo "<h2 class='bg-danger text-center mt-5'>No payments received yet</h2>";
            }else{
                $number = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $order_id = $row['order_id'];
                    $payment_id = $row['payment_id'];
                    $amount = $row['amount'];
                    $invoice_number = $row['invoice_number'];
                    $payment_mode = $row['payment_mode'];
                    $date = $row['date'];
                    $number++;
                    echo
                    "<tr>
                    <td>$number</td>
                    <td>$invoice_number</td>
                    <td>$amount</td>
                    <td>$payment_mode</td>
                    <td>$date</td>
                    </tr>";
                }
            }
        ?>
    </tbody>
</table>
