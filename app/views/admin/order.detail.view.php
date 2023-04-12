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
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-3">Order Details</h1>
            <div class="dashboard-buttons">
                <a class="btn btn-primary text-uppercase fw-bold" href="<?= ROOT ?>/admin/orders">Back</a>
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="add-button">Add Dishes</a>
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="finish-button">Finish Editing</a>
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="edit-button">Edit</a>
                <a class="btn btn-primary text-uppercase fw-bold"
                   href=<?= ROOT . "/admin/orders/delete/" . $order->order_id ?> id="delete-button">Delete</a>
            </div>
        </div>
        <div class="blur-container">

            <h5>Estimated Time: <?=(new models\Order())->getEstimate($order->order_id)?> minutes</h5><br>
            <h2><span class="order-id"
                      data-order-id="<?= $order->order_id ?>">Order ID: <?= $order->order_id ?></span>
            </h2>
            <br>
            <div id="parent-detail">

                <div class="detail-field">
                    <h4 class="type-display" data-type="<?= $order->type ?>">Order Type:
                        <?php
                        if ($order->type == "dine-in")
                            echo "<img src='" . ASSETS . "/icons/table.png' alt='dine-in' width='30' height='30'> " . $order->table_id;
                        else if ($order->type == "takeaway")
                            echo "<img src='" . ASSETS . "/icons/fastcart.png' alt='take-away' width='30' height='30'>";
                        else if ($order->type == "bulk")
                            echo "<img src='" . ASSETS . "/icons/bulk.svg' alt='bulk' width='30' height='30'>";
                        ?></h4><br>
                    <strong class="type-field">Order Type:</strong>
                    <select class="type-field">
                        <option value="dine-in">dine-in</option>
                        <option value="takeaway">takeaway</option>
                    </select>
                </div>


                <div class="detail-field">
                    <h4 class="request-display">Request: <?= $order->request ?></h4>
                    <strong class="request-field"><label for="request-field">Request:</label></strong>
                    <textarea class="request-field"></textarea>
                </div>


            </div>

            <h4>Order Status:</h4>
            <div class='form-group'>
                <select data-order-status="<?= $order->status ?>" class="order-status form-control">
                    <option value="pending" <?= ($order->status == 'pending') ? 'selected' : '' ?>>Pending
                    </option>
                    <option value="accepted" <?= ($order->status == 'accepted') ? 'selected' : '' ?>>Accepted
                    </option>
                    <option value="rejected" <?= ($order->status == 'rejected') ? 'selected' : '' ?>>Rejected
                    </option>
                    <option value="completed" <?= ($order->status == 'completed') ? 'selected' : '' ?>>Completed
                    </option>
                </select>
            </div>


            <?php if ($order->scheduled_time != null) : ?>
                <h4>Scheduled Time: <?= substr($order->scheduled_time, 0, 16) ?></h4>
            <?php endif; ?>
            <h4>Placed Time: &nbsp &nbsp&nbsp &nbsp <?= substr($order->time_placed, 0, 16) ?></h4>
            <br>
            <div class="col-6">
                <div id="order-details-table">

                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Dish</th>
                        <th class="editorderoption">-</th>
                        <th>Quantity</th>
                        <th class="editorderoption">+</th>
                        <!--                        <th class="editorderoption"></th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($dishes)) : ?>
                        <?php foreach ($dishes as $od) : ?>
                            <tr data-dish-id="<?= $od->dish_id ?>">
                                <td><?= $od->dish_name ?></td>
                                <td class="editorderoption">
                                    <button class="quantity decrease">-</button>
                                </td>
                                <td><?= $od->quantity ?></td>
                                <td class="editorderoption">
                                    <button class="quantity increase">+</button>
                                </td>
                                <td class="editorderoption"><i class="fa fa-trash trash-icon"></i></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <tr class="input-row">
                        <td>
                            <select class="form-control" id="dish-select">
                                <?php foreach ($allDishes as $d) : ?>
                                    <option value="<?= $d->dish_id ?>"><?= $d->dish_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="number" class="form-control" id="quantity-input" value="1"></td>
                        <td>
                            <button class="save-dish">Add</button>
                        </td>
                        <td>
                            <button class="cancel-dish">Cancel</button>
                        </td>
                    </tr>
                    <tr class="dummy-row" data-dish-id="0">
                        <td></td>
                        <td class="editorderoption">
                            <button class="quantity decrease">-</button>
                        </td>
                        <td></td>
                        <td class="editorderoption">
                            <button class="quantity increase">+</button>
                        </td>
                        <td class="editorderoption"><i class="fa fa-trash trash-icon"></i></td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>

        <div id="button-div">
            <button class="btn btn-danger" value="rejected" id="reject-button">Reject</button>
            <button class="btn btn-success" value="accepted" id="accept-button">Accept</button>
            <button class="btn btn-success" value="completed" id="complete-button">Complete</button>
        </div>
        <div class="popup" id="complete-popup">
            <p>
                Are you sure this order is completed?
            </p>
            <div class="popup-button-div">
                <button class="btn btn-success" id="confirm">Yes</button>
                <button class="btn btn-danger" id="cancel">No</button>
            </div>
        </div>
        <div class="popup" id="reject-popup">
            <p>
                Are you sure you want to reject this order?
            </p>
            <div class="popup-button-div">
                <button class="btn btn-success" id="confirm">Yes</button>
                <button class="btn btn-danger" id="cancel">No</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>