<!DOCTYPE html>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>viewOrders</title>
</head>

<body>

<div>
    <input type="text" placeholder="Search..">
    <select>
        <option name="Dine-in" value="Dine-in">Dine-in</option>
        <option name="Take-away" value="Take-away">Take-away</option>
        <option  name="Bulk" value="Bulk">Bulk</option>
    </select>

    <select>
        <option value="Pending">Pending</option>
        <option value="Accepted">Accepted</option>
        <option value="Cancelled">Cancelled</option>
        <option value="Completed">Completed</option>
    </select>
</div>
<br>

<table>

    <tr>
        <th>Order ID</th>
        <th>Customer_id</th>
        <th>Time Placed</th>
        <th>Scheduled Time</th>
        <th>Request</th>
        <th>Qty</th>
        <th>Type</th>
        <th>Status</th>
    </tr>


    <?php
    if (isset($order_list)) {
        foreach ($order_list as $order) {
            echo "<tr>";
            echo "<td>" . $order->order_id . "</td>";
            echo "<td>" . $order->reg_customer_id ?? $order->guest_id . "</td>";
            echo "<td>" . $order->time_placed . "</td>";
            echo "<td>" . $order->scheduled_time . "</td>";
            echo "<td>" . $order->request . "</td>";
            echo "<td>" . $order->type . "</td>";
            echo "<td>" . $order->status . "</td>";
            echo "<td><a href='orders/edit/" . $order->order_id . "'>Edit</a>";
            echo "<td><a href='orders/payment/" . $order->order_id . "'>payment</a>";
            echo "</tr>";
        }
    }

    ?>

</table>


</body>
</div>
</html>

<style>

</style>