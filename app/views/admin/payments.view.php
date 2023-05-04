<!DOCTYPE html>
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <script src="<?= ASSETS ?>/js/admin/payments.js"></script>
    <title>Payments</title>
</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div  id="blur-container">
            <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-3">Payments</h1>
                <div class="dashboard-buttons" style="width:400px;">
                    <select class="form-control d-inline px-2 mx-4" name="status" style="width:30%;">
                        <option value="all">All</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="accepted">Accepted</option>
                    </select>
                    <a class="btn btn-primary text-uppercase fw-bold d-inline-block"
                       href="<?php echo ROOT ?>/admin/payments/addOrder"
                       id="add-order-button">+ Create Order</a>

                </div>
            </div>
            <div class="w-100 p-2 d-flex justify-content-space-evenly" style="background-color: red">
                <span class="btn" id="unpaid-header">Unpaid</span>
                <span class="btn" id="tocollect-header">To Collect</span>
            </div>
            <div id="tobepaid-table" style="display: none;">
                <table class="table">
                    <thead>
                    <tr class="fs-6">
                        <th>O_ID</th>
                        <th>C_Id</th>
                        <th>Name</th>
                        <th>Time Placed</th>
                        <th>Type</th>
                        <th>Estimated Time</th>
                        <th>Total Cost (LKR)</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($tobepaid)) : ?>
                        <?php foreach ($tobepaid as $order) : ?>
                            <tr data-order-id="<?= $order->order_id ?>" data-order-type="<?= $order->type ?>"
                                data-order-status="<?= $order->status ?>">
                                <td class="order-id-field"><?= $order->order_id ?></td>
                                <td><?= $order->guest_id ? "G" : "" ?><?= $order->reg_customer_id ?? $order->guest_id ?></td>
                                <td>
                                    <?php if (isset($order->first_name))
                                        echo $order->first_name . " " . $order->last_name;
                                    else
                                        echo "Guest";
                                    ?>
                                </td>

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
                                <td><?php if ($order->status == "completed") echo "Completed";
                                    else if ($order->status == "rejected") echo "Rejected";
                                    else if ($order->status == "pending") echo "Pending";
                                    else {
                                        //x is in minutes $x=20
                                        $x = (new models\Order())->getEstimate($order->order_id);
                                        //time when order is placed $time = 2023-04-20 15:00:42
                                        $time = $order->time_placed;
                                        //time when order is completed
                                        $time2 = date('Y-m-d H:i:s', strtotime('+' . $x . ' minutes', strtotime($time)));
                                        if (isset($order->scheduled_time)) $time2 = $order->scheduled_time;
                                        //time now
                                        $time3 = date('Y-m-d H:i:s');
                                        //time remaining
                                        $time4 = strtotime($time2) - strtotime($time3);
                                        //time remaining in minutes
                                        $time5 = round($time4 / 60);
                                        if ($time5 > 0) echo $time5 . " minutes";
                                        else if ($time5 < 0) echo "5 minutes";
                                    } ?>

                                </td>
                                <td> <?= $order->total_cost ?></td>
                                <td><a class='edit-icon-link text-danger'
                                       href='<?= ROOT ?>/admin/payments/id/<?= $order->order_id ?>'><i
                                            class='fa fa-credit-card'></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr class="text-center no-orders">
                            <td colspan="7">No Orders available</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>

                </table>
            </div>
            <div id="tobecollected-table" style="display: none;">
                <table class="table">
                    <thead>
                    <tr class="fs-6">
                        <th>O_ID</th>
                        <th>C_Id</th>
                        <th>Name</th>
                        <th>Time Placed</th>
                        <th>Type</th>
                        <th>Estimated Time</th>
                        <th>Total Cost (LKR)</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($tobecollected)) : ?>
                        <?php foreach ($tobecollected as $order) : ?>
                            <tr data-order-id="<?= $order->order_id ?>" data-order-type="<?= $order->type ?>"
                                data-order-status="<?= $order->status ?>">
                                <td class="order-id-field"><?= $order->order_id ?></td>
                                <td><?= $order->guest_id ? "G" : "" ?><?= $order->reg_customer_id ?? $order->guest_id ?></td>
                                <td>
                                    <?php if (isset($order->first_name))
                                        echo $order->first_name . " " . $order->last_name;
                                    else
                                        echo "Guest";
                                    ?>
                                </td>

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
                                <td><?php if ($order->status == "completed")
                                        echo "Completed";
                                    else if ($order->status == "rejected")
                                        echo "Rejected";
                                    else if ($order->status == "pending")
                                        echo "Pending";
                                    else {
                                        $x = (new models\Order())->getTimeRemaining($order->order_id);
                                        echo $x . " minutes";
                                    }
                                    ?>

                                </td>
                                <td> <?= $order->total_cost ?></td>
                                <td><a class='edit-icon-link text-danger'
                                       href='<?= ROOT ?>/admin/payments/id/<?= $order->order_id ?>'><i
                                            class='fa fa-credit-card'></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="text-center no-orders">
                            <td colspan="7">No Orders available</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>
        <div class="popup pt-1" id="customer-type-popup">
            <div class="popup-button-div pt-0">
                <span class="p-0 row justify-content-end"> <i id="close-icon" class="fa fa-times"></i></span>
                <br>
                <button class="btn btn-success" id="return-customer">Returning Customer</button>
                <button class="btn btn-danger" id="new-customer">New Customer</button>
                <br>
            </div>
        </div>
        <div class="overlay">
            <form>

            </form>
        </div>
    </div>
</body>
</html>
