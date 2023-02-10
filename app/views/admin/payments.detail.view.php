<!DOCTYPE html>

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/payment.detail.css">
    <script src="<?= ASSETS ?>/js/admin/order.detail.js"></script>
    <title>pay</title>
</head>


<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header">
                <h1 class="display-3 active">Payment Details</h1>
            </div>


    <?php if (isset($order)) : ?>
            <h3>Order ID: #<?= $order->order_id ?></h3>
            <h3>Customer ID: #<?= $order->reg_customer_id ?? $order->guest_id ?></h3><br><br>
        <?php endif ?>

        <div id="order-details-table">
                <table class="table">
            <thead>

            <tr>
                <th>Dish</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            if (isset($dishes))
                foreach ($dishes as $orderDish) {
                    echo '<tr>';
                    echo '<td>' . $orderDish->dish_name . '</td>';
                    echo '<td>' . $orderDish->quantity . '</td>';
                    echo '<td>' . $orderDish->selling_price . '</td>';
                    echo '<td>' . $orderDish->quantity * $orderDish->selling_price . '</td>';
                    $total += $orderDish->quantity * $orderDish->selling_price;
                    echo '</tr>';

                }
         
            ?>

            </tbody>

        </table>


            <div >
                <br><br><br>
                <h3>Cash Payment</h3><br>
                <label id="total" >Total Amount: </label><span class="payment" id="tot"> <?= $total ?> </span><br> 
                <label>Cash:</label> <input class="payment" onchange="balance()" type="text" id="Cash" name="Cash" placeholder="Enter Ammount"><br>
                <label id="change" >Balance: </label>


                    <script id="payment">
                    function balance(){
                        var cash= document.getElementById("Cash")
                        var total = document.getElementById("tot")
                        var change = document.getElementById("change")
                        var balance = parseInt(cash.value) - parseInt(total.innerHTML)

                        let text1 = "Balance:";

                        change.innerHTML = text1.concat(" ", balance); 

                        }
                    
                        </script>

        <br>
            <br><br><a href="<?php echo ROOT ?>/admin/payments/"><button type="submit" class="pay">Pay</button></a>

        </div>
   </div>
</div>
</body>
</html>


   






