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
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-3 active">Orders</h1>
            <a class="btn btn-primary" id="KDS-button">KDS mode</a>
        </div>
        <br>
        <div id="order-table">
            <div class="card-deck row justify-content-start">
                <?php if (isset($order_list)) : ?>
                    <?php foreach ($order_list as $order) : ?>
                        <div class="card" data-order-id="<?= $order->order_id ?>" data-order-type="<?= $order->type ?>"
                             data-order-status="<?= $order->status ?>" data-user-id="<?= $order->guest_id ?? $order->reg_customer_id ?>"
                            data-user-type="<?php if ($order->reg_customer_id) echo "registered"; else echo "guest" ?>">
                            <div class="card-header <?php if (isset($order->scheduled_time)) echo "timer" ?>">
                                <div class="d-flex justify-content-between">
                                    <div class="id-strip">#<?= $order->order_id ?>&nbsp</div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="type-icon">
                                        <?php
                                        if ($order->type == "dine-in")
                                            echo "<img src='" . ASSETS . "/icons/table.png' alt='dine-in' width='30' height='30'>";
                                        else if ($order->type == "takeaway")
                                            echo "<img src=" . ASSETS . "/icons/fastcart.png alt='takeaway' width='30' height='30'>";
                                        else if ($order->type == "bulk")
                                            echo "<img src='" . ASSETS . "/icons/bulk.svg' alt='bulk' width='30' height='30'>";
                                        ?>
                                    </div>
                                    <?php if ($order->type == "dine-in") : ?>
                                        <div><?= $order->table_id ?></div> <?php endif; ?>
                                    <div>
                                        <?php
                                        $formattedTime = formatOrderTime($order->scheduled_time, $order->time_placed);
                                        echo "<div class='time'>$formattedTime</div>";
                                        ?>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;
                                    <div data-order-status="<?= $order->status ?>" id="circle"></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php foreach ($order_dishes[$order->order_id] as $dish) : ?>
                                    <div class="dish-component" style="display: flex; justify-content: space-between;">
                                        <div style="flex: 1;"><?= $dish->dish_name ?></div>
                                        <div style="margin-left: auto;"><?= $dish->quantity ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>

</html>
<?php
function formatOrderTime($scheduled_time, $time_placed): string
{
    if (isset($scheduled_time)) {
        return date("h:i A", strtotime($scheduled_time));
    }
    return date("h:i A", strtotime($time_placed));
}

?>

<div class="card dummy-card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="id-strip"></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="type-icon">
                <img src='' alt='' width='30' height='30'>
            </div>
            <div></div>&nbsp;&nbsp;&nbsp;
            <div>
                <div class="time"></div>
            </div>
            <div id="circle"></div>
        </div>
    </div>
    <div class="card-body">
        <div class="dish-component" style="display: flex; justify-content: space-between;">
            <div style="flex: 1;"></div>
            <div style="margin-left: auto;"></div>
        </div>
    </div>
</div>
