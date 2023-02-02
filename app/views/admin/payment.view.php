<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>

</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <?php if (isset($order)) : ?>
    <div class="w-100 h-100 p-5">
        <div class="container">
            <h2>Payment ></h2><br>
            <h3>Order ID: #<?= $order->order_id ?></h3>
            <h3>Customer ID: #<?= $order->reg_customer_id ?? $order->guest_id ?></h3><br><br>
            <h3>order Details</h3><br><br>
        </div>
        <?php endif ?>

        <table>
            <thead>

            <tr>
                <th>Orders</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th></th>

            </tr>
            </thead>

            <tbody>
            <?php if (isset($dish))
                foreach ($dish as $orderDish) {
                    echo '<tr>';
                    echo '<td>' . $orderDish->dish_name . '</td>';
                    echo '<td>' . $orderDish->quantity . '</td>';
                    echo '<td>' . $orderDish->unit_price . '</td>';
                    echo '<td>' . $orderDish->quantity * $orderDish->unit_price . '</td>';
                    echo '</tr>';

                }
            ?>

            </tbody>

        </table>


        <div>
            <br><br><br>
            <h3>cash payment</h3>
            <label>Total Amount: <input type="text" id="Total" name="Total" placeholder="Enter Total"></label><br>
            <label>Cash: <input type="text" id="Cash" name="Cash" placeholder="Cash"></label><br>
            <label>Change: <input type="text" id="Change" name="Change" placeholder="Change"></label><br><br><br>
            <button type="submit" class="pay">Pay</button>

        </div>
    </div>
</div>
</body>
</html>
<?php include "partials/dashboard.footer.php" ?>

<style>
    table {
        border-collapse: collapse;
        width: 100%;
        color: #588c7e;
        font-family: monospace;
        font-size: 15px;
        text-align: left;
    }

    th {
        background-color: #588c7e;
        color: white;
        padding: 10px;
        text-align: center;
    }

    .pay-cash {
        display: flex;
        background-color: #4CAF50; /* Green */
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .pay {
        width: 20%;
        background-color: #588c7e;
        color: white;
        padding: 5px 5px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float: right;


    }

    .pay:hover {
        background-color: #c0392b;
    }

    input {
        border: none;
        float: right;
    }


</style>