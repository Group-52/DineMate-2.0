<!DOCTYPE html>

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/orders.css">
    <style>
        .card {
            height: 180px;
            margin-bottom: 20px;
            margin-left: 10px;
            margin-right: 10px;
            width: 200px;
            border: 3px solid black;
            border-radius: 5px;
        }

        .card-header {
            background-color: #f2f2f2;
            padding: 10px;
            font-weight: bold;
            height: 50px;
        }

        .card-body {
            padding: 10px;
            height: 130px;
            overflow: scroll;
        }

        .card-deck {
            clear: both;
            display: flex;
            flex-wrap: wrap;
            justify-content: left;
        }

    </style>
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
<!--                    </select>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--        </div>-->
        <br>
        <div id="order-table">
            <div class="card-deck">
                <?php if (isset($order_list)) : ?>
                    <?php foreach ($order_list as $order) : ?>
                        <div class="card" data-order-id="<?= $order->order_id ?>" data-order-type="<?= $order->type ?>"
                             data-order-status="<?= $order->status ?>">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <?php
                                        $formattedTime = formatOrderTime($order->scheduled_time,$order->time_placed);
                                        echo "<div>$formattedTime</div>";
                                        ?>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <div>
                                        <?php
                                        if ($order->type == "dine-in")
                                            echo "<img src='" . ASSETS . "/icons/table.png' alt='dine-in' width='30' height='30'> ";
                                        else if ($order->type == "takeaway")
                                            echo "<img src=" . ASSETS . "/icons/fastcart.png alt='takeaway' width='30' height='30'>";
                                        else if ($order->type == "bulk")
                                            echo "<img src='" . ASSETS . "/icons/bulk.svg' alt='bulk' width='30' height='30'>";
                                        ?>
                                    </div>
                                    <?php if ($order->type == "dine-in") : ?> <div><?= $order->table_id ?></div> <?php endif; ?>
                                    &nbsp;&nbsp;&nbsp;
                                    <div data-order-status="<?= $order->status ?>" id="circle"></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php foreach ($order_dishes[$order->order_id] as $dish) : ?>
                                    <div style="display: flex; justify-content: space-between;">
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
        <?php include VIEWS . "/partials/admin/paginationbar.partial.php" ?>
    </div>
</div>
</body>

</html>
<?php
function formatOrderTime($scheduled_time, $time_placed) {
    if (!isset($scheduled_time)) {
        return date("h:i A", strtotime($time_placed));
    }

    $scheduled_date = date("Y-m-d", strtotime($scheduled_time));
    $today_date = date("Y-m-d");

    if ($scheduled_date == $today_date) {
        return date("h:i A", strtotime($scheduled_time));
    } else {
        $diff_days = strtotime($scheduled_date) - strtotime($today_date);
        if ($diff_days == 86400) {
            return "Tomorrow";
        } else {
            return "Future";
        }
    }
}

?>