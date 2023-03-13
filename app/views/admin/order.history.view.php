<!DOCTYPE html>

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/order.detail.css">
    <script src="<?= ASSETS ?>/js/admin/order.detail.js"></script>
    <script src="<?= ASSETS ?>/js/admin/orders.js"></script>
    <title>Orders</title>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header">
                <h1 class="display-3 active">Order History</h1>
            </div>

            <h2><span class="order-id" data-order-id="<?= $history[0]->reg_customer_id ?>">Customer ID: <?= $history[0]->reg_customer_id ?? $history[0]->reg_customer_id ?></span></h2><br>
            <br>
            <div id="order-details-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Request</th>
                            <th>Time Placed</th>
                            <th>Order Type</th>
                            <th>Status</th>
                            <th>View dish</th>
                            <!-- <th>Quantity</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($history)) : ?>
                            <?php foreach ($history as $od) : ?>
                                <tr>
                                    <td><?= $od->order_id ?></td>
                                    <td><?= $od->request ?></td>
                                    <td><?= $od->time_placed ?></td>
                                    <td><?= $od->type ?></td>
                                    <td><?= $od->status ?></td>
                                    <td><button class="btn" onclick="openpopup();">View Dishes</button></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>

                    </tbody>

                </table>
            </div>
            
            <div class="dishes" id="popup">
                <table>
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
                            <?php endforeach; ?>
                        <?php endif; ?>
                                </tr>
                    </tbody>
                </table>
                <button class="btn" onclick="closepopup();">Cancel</button>
            </div>
            </div>                      
    </div>
</body>

</html>