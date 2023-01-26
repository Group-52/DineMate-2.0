<?php include "partials/dashboard.header.php" ?>
<!DOCTYPE html>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>viewOrders</title>

    

</head>

<body>
<h3>View Order></h3><br>
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
            echo "<td><a class='edit-icon-link' href='orders/edit/" . $order->order_id . "'><i class='fa fa-edit edit-icon' aria-hidden='true'></i></a></td>";
            echo "<td><a class='edit-icon-link' href='orders/payment/" . $order->order_id . "'><i class='fa fa-cash-register money-icon' aria-hidden='true'></i></a></td>";
            echo "</tr>";
        }
    }

    ?>

</table>


</body>
</div>
</html>
<?php include "partials/dashboard.footer.php" ?>
 
 

<style type="text/css">
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

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        td {
            padding: 10px;
            text-align: center;
        }

        .editable {
            border: 2px solid green;
        }

        .fa-edit {
            cursor: pointer;
            color: #588c7e ;
        }

        .fa-edit:hover {
            color: #c0392b;
        }

        .fa-edit:active {
            transform: scale(0.9);
        }

        .fa-cash-register {
            cursor: pointer;
            color:  #588c7e;
        }

        .fa-cash-register:hover {
            color: #c0392b;
        }

        .fa-cash-register:active {
            transform: scale(0.9);
        }

        .shrink {
            transition: height 2s ease-out;
        }

      


input[type="text"] {
    padding: 10px 10px;
    margin: 4px 0;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
}

select {
    margin: 0 10px;
    padding: 10px 10px;
    border: 2px solid #ccc;
    border-radius: 4px;
}


    </style>