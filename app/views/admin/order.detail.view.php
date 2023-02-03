<!DOCTYPE html>

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/order.detail.css">
    <script src="<?= ASSETS ?>/js/admin/order.detail.js"></script>
    <title>Orders</title>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header">
                <h1 class="display-3 active">Order Details</h1>
            </div>

            <h2>#<?= $order->order_id ?></h2>
            <h3>Request: <br><?= $order->request ?></h3>
            <h3>Order Type: <?php
                            if ($order->type == "dine-in")
                                echo "<img src='" . ASSETS . "/favicons/table.png' alt='dine-in' width='30' height='30'> " . $order->table_id;
                            else if ($order->type == "takeaway")
                                echo "<img src='" . ASSETS . "/favicons/fastcart.png' alt='take-away' width='30' height='30'>";
                            else if ($order->type == "bulk")
                                echo "<img src='" . ASSETS . "/favicons/bulk.svg' alt='bulk' width='30' height='30'>";
                            ?></h3>
            <h3>Order Status: <?= $order->status ?> </h3>
            <?php if ($order->scheduled_time != null) : ?>
                <h3>Scheduled Time: <?= $order->scheduled_time ?></h3>
            <?php endif; ?>
            <h3>Time Placed: <?= $order->time_placed ?></h3>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>Dish</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($dishes)) : ?>
                        <?php foreach ($dishes as $od) : ?>
                            <tr>
                                <td><?= $od->dish_name ?></td>
                                <td><?= $od->quantity ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

            </table>

            <div id="button-div">
                <button class="btn btn-danger" value="rejected" id="accept-button">Reject</button>
                <button class="btn btn-success" value="accepted" id="reject-button">Accept</button>
            </div>
        </div>
    </div>
</body>

</html>