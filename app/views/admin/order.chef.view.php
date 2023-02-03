<!DOCTYPE html>

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/tables.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/orders.css">
    <script src="<?= ASSETS ?>/js/admin/orders.js"></script>
    <title>viewOrders</title>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header">
                <h1 class="display-3 active">Orders</h1>
            </div>
            <div>

                <select name="type" id="type">
                    <option value="Dine-in">Dine-in</option>
                    <option value="Take-away">Take-away</option>
                    <option value="Bulk">Bulk</option>
                </select>

                <select id="status">
                    <option value="Pending">Pending</option>
                    <option value="Accepted">Accepted</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            <br>

            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Id</th>
                        <th>Time Placed</th>
                        <th>Scheduled Time</th>
                        <th>Request</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($order_list)) : ?>
                        <?php foreach ($order_list as $order) : ?>
                            <tr>
                                <td><?= $order->order_id ?></td>
                                <td><?= $order->reg_customer_id ?? $order->guest_id ?></td>
                                <td><?= $order->time_placed ?></td>
                                <td><?= $order->scheduled_time ?>
                                <?php if($order->scheduled_time == null || $order->scheduled_time == "") :
                                    echo "-";
                                endif; ?>

                                </td>
                                <td><?= substr($order->request, 0, 30); if (strlen($order->request) > 30) : echo "..."; endif; ?></td>
                                <td><?= $order->type ?></td>
                                <td>
                                    <div data-status="<?= $order->status ?>"id="circle" class="pending"></div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</body>
</html>

<script>
    //    function filterOptions(value) {
    //     // Get the select element
    //     let select = document.getElementById("type");
    //     // Remove all current options
    //     select.innerHTML = "";
    //     // Add the desired options back
    //     switch (value) {
    //       case "Dine-in":
    //         select.innerHTML += '<option name="Dine-in" value="Dine-in">Dine-in</option>';
    //         break;
    //       case "Take-away":
    //         select.innerHTML += '<option name="Take-away" value="Take-away">Take-away</option>';
    //         break;
    //       case "Bulk":
    //         select.innerHTML += '<option  name="Bulk" value="Bulk">Bulk</option>';
    //         break;
    //     }
    // }




    let orders = [{
            type: "Dine-in",
            name: "type"
        },
        {
            type: "Take-away",
            name: "type"
        },
        {
            type: "Bulk",
            name: "type"
        },
        {
            type: "Dine-in",
            name: "type"
        }
    ];

    function filterOptions(value) {
        // Get the select element
        let select = document.getElementById("type");
        // Remove all current options
        select.innerHTML = "";
        // Filter the data based on the passed in value
        let filteredOrders = orders.filter(order => order.type === value);
        // Add the filtered data to the select element
        filteredOrders.forEach(order => {
            select.innerHTML += `<option value="${order.name}">${order.name}</option>`;
        });
    }
</script>