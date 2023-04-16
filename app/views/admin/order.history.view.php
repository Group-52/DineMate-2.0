<!DOCTYPE html>

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/order.history.css">
    <script src="<?= ASSETS ?>/js/admin/order.history.js"></script>
    <title>viewOrders</title>
</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-3 active">Orders</h1>
            <div class="dashboard-buttons">
                <a class="btn btn-primary text-uppercase fw-bold" href="<?= ROOT ?>/admin/orders">Today's Orders</a>
            </div>
        </div>
        <!--        <div>-->
        <!--            <div class="filter">-->
        <!--                <div>-->
        <!--                    <select name="type" id="type" class="form-control">-->
        <!--                        <option value="all">All</option>-->
        <!--                        <option value="dine-in">Dine-in</option>-->
        <!--                        <option value="takeaway">Take-away</option>-->
        <!--                        <option value="bulk">Bulk</option>-->
        <!--                    </select>-->
        <!--                </div>-->
        <!--                <div>-->
        <!--                    <select id="status" class="form-control" style="width: 125px;">-->
        <!--                        <option value="all">All</option>-->
        <!--                        <option value="pending">Pending</option>-->
        <!--                        <option value="accepted">Accepted</option>-->
        <!--                        <option value="rejected">Cancelled</option>-->
        <!--                        <option value="completed">Completed</option>-->
        <!--                    </select>-->
        <!--                </div>-->
        <!--            </div>-->

        <!--        </div>-->
        <!--        <br>-->
        <div id="order-table">
            <table class="table">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Id</th>
                    <th>Time Placed</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Time Completed</th>
                    <th>Paid</th>
                    <th>Total Cost</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($order_list)) : ?>
                    <?php foreach ($order_list as $order) : ?>
                        <tr data-order-id="<?= $order->order_id ?>" data-order-type="<?= $order->type ?>"
                            data-order-status="<?= $order->status ?>">
                            <td class="order-id-field"><?= $order->order_id ?></td>
                            <td><?= $order->guest_id ? "G" : "" ?><?= $order->reg_customer_id ?? $order->guest_id ?></td>
                            <td>
                                <?= $order->time_placed ?>
                            </td>

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
                                <div data-order-status="<?= $order->status ?>" id="circle"
                                     class="<?= $order->status ?>"></div>
                            </td>
                            <td>
                                <?= $order->time_completed ?>
                            </td>
                            <td>
                                <?php
                                if ($order->paid == 1)
                                    echo "<i class='fas fa-check-circle' style='color: green;'></i>";
                                else
                                    echo "<i class='fas fa-times-circle' style='color: red;'></i>";
                                ?>
                            </td>
                            <td> <?= $order->total_cost ?></td>
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
<!--"order_id",-->
<!--"reg_customer_id",-->
<!--"guest_id",-->
<!--"request",-->
<!--"time_placed",-->
<!--"time_completed",-->
<!--"type",-->
<!--"status",-->
<!--"scheduled_time",-->
<!--"table_id",-->
<!--"paid",-->
<!--"promo",-->
<!--"total_cost"-->