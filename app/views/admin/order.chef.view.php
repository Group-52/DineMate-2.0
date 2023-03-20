<!DOCTYPE html>

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
            <div class="filter">
                <div>
                    <select name="type" id="type" class="form-control">
                        <option value="all">All</option>
                        <option value="dine-in">Dine-in</option>
                        <option value="takeaway">Take-away</option>
                        <option value="bulk">Bulk</option>
                    </select>
                </div>
                <div>
                    <select id="status" class="form-control" style="width: 125px;">
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="accepted">Accepted</option>
                        <!-- <option value="rejected">Cancelled</option>
                        <option value="completed">Completed</option> -->
                    </select>
                </div>
            </div>


        </div>
        <br>
        <div id="order-table">
            <table class="table">
                <thead>
                <tr>
<!--                    <th>Order ID</th>-->
<!--                    <th>Customer Id</th>-->
                    <th>Time Placed</th>
<!--                    <th>Scheduled Time</th>-->
                    <th>Request</th>
                    <th>Type</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($order_list)) : ?>
                    <?php foreach ($order_list as $order) : ?>
                        <tr data-order-id="<?= $order->order_id ?>" data-order-type="<?= $order->type ?>"
                            data-order-status="<?= $order->status ?>">
<!--                            <td class="order-id-field">--><?php //= $order->order_id ?><!--</td>-->
<!--                            <td>--><?php //= $order->reg_customer_id ?? $order->guest_id ?><!--</td>-->
                            <td<?= $order->scheduled_time ? ' style="color: green;"' : '' ?>>
                                <?= $order->scheduled_time ?? $order->time_placed ?>
                            </td>

                            <td><?= substr($order->request, 0, 30);
                                if (strlen($order->request) > 30) : echo "...";
                                endif; ?></td>
                            <td>
                                <?php
                                if ($order->type == "dine-in")
                                    echo "<img src='" . ASSETS . "/icons/table.png' alt='dine-in' width='30' height='30'> " . $order->table_id;
                                else if ($order->type == "takeaway")
                                    echo "<img src='" . ASSETS . "/icons/fastcart.png' alt='take-away' width='30' height='30'>";
                                else if ($order->type == "bulk")
                                    echo "<img src='" . ASSETS . "/icons/bulk.svg' alt='bulk' width='30' height='30'>";
                                ?>

                            </td>
                            <td>
                                <div data-order-status="<?= $order->status ?>" id="circle" class="pending"></div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>

            </table>
            <?php include VIEWS . "/partials/admin/paginationbar.partial.php" ?>
        </div>
    </div>
</body>

</html>