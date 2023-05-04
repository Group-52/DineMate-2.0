<!DOCTYPE html>

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/order.detail.css">
    <script src="<?= ASSETS ?>/js/admin/order.detail.js"></script>
    <script src="<?= ASSETS ?>/js/admin/common.js"></script>
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
                <button class="btn text-danger ml-3" value="rejected" id="reject-button">Reject</button>
                <button class="btn text-warning mr-3" value="accepted" id="accept-button">Accept</button>
                <button class="btn text-success" value="completed" id="complete-button">Complete</button>
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="add-button">+ <i
                        class="fa-solid fa-bowl-rice d-inline"></i></a>
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="finish-button">Finish Editing</a>
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="edit-button">Edit</a>
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="delete-button">Delete</a>
            </div>
        </div>
        <div class="blur-container d-flex flex-column">
            <div class="px-5 pt-1" style="height: 40px">
                <h2>
                    <?php if ($order->reg_customer_id)
                        echo "Customer ID: " . $order->reg_customer_id;
                    else echo "Guest ID: ".$order->guest_id; ?>
                </h2>

            </div>
            <div class="row justify-content-space-between px-5 pt-2" style="height: 40px">
                <span class="order-id"
                      data-order-id="<?= $order->order_id ?>" data-user-id="<?=$order->reg_customer_id ?? $order->guest_id?>"
                      data-user-type="<?= $order->reg_customer_id ? 'registered' : 'guest' ?>">
                    <h2 class="d-inline">Order ID: <?= $order->order_id ?></h2>
                </span>
                <h5 class="pr-5">Estimated Time: <?= (new models\Order())->getEstimate($order->order_id) ?> minutes</h5>
            </div>
            <div class="row justify-content-space-between px-5 pt-2" style="height: 40px">
                <span>
                    <h4 class="d-inline pb-5">Order Status:</h4>
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
                </span>
                <h4 class="pr-5">Placed Time: &nbsp;&nbsp;&nbsp; &nbsp; <?= substr($order->time_placed, 0, 16) ?></h4>
            </div>

            <div class="row p-5">
                <div class="col-6 pr-5">
                    <?php if ($order->scheduled_time != null) : ?>
                        <h4 class="sctime-display py-3">
                            Scheduled Time: <span><?= substr($order->scheduled_time, 0, 16) ?></span>
                            <i class="fa fa-pencil-square-o edit-sctime-field"></i>
                        </h4>
                        <span class="sctime-field py-3">
                            <strong>Scheduled Time:</strong> <input type="datetime-local"
                                                                    value="<?= substr($order->scheduled_time, 0, 16) ?>">
                            <i class="fa fa-check-circle tick-icon tick-sctime-field"></i>
                            <i class="fa fa-circle-xmark cross-icon cross-sctime-field"></i>
                    </span>
                    <?php endif; ?>

                    <h4 class="request-display py-3">
                        Request: <span><?= $order->request ?></span>
                        <i class="fa fa-pencil-square-o edit-request-field"></i>
                    </h4>
                    <span class="request-field pt-3"><label for="request-field"><strong>Request:</strong></label>
                    <textarea></textarea>
                            <i class="fa fa-check-circle tick-icon tick-request-field"></i>
                            <i class="fa fa-circle-xmark cross-icon cross-request-field"></i>
                    </span>

                    <h4 class="type-display py-3" data-type="<?= $order->type ?>">Order Type:
                        <?php
                        if ($order->type == "dine-in")
                            echo "<img src='" . ASSETS . "/icons/table.png' alt='dine-in' width='30' height='30'> " . $order->table_id;
                        else if ($order->type == "takeaway")
                            echo "<img src='" . ASSETS . "/icons/fastcart.png' alt='take-away' width='30' height='30'>";
                        else if ($order->type == "bulk")
                            echo "<img src='" . ASSETS . "/icons/bulk.svg' alt='bulk' width='30' height='30'>";
                        ?></h4><br>
                    <span class="type-field">
                        <strong>Order Type:</strong>
                        <select class="p-1">
                            <option value="dine-in">dine-in</option>
                            <option value="takeaway">takeaway</option>
                        </select>
                    </span>

                    <h4 class="promo-display pt-3">
                        Promo Code:
                        <select class="promo-select p-1" disabled>
                            <option value="1" <?= ($order->promo === 1) ? 'selected' : '' ?>>none</option>
                            <?php foreach ($promo_list as $promo) : ?>
                                <option
                                    value="<?= $promo->promo_id ?>" <?= ($order->promo === $promo->promo_id) ? 'selected' : '' ?>>
                                    <?= $promo->title ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </h4>
                    <h4 class="pt-3">
                        Order Total: <?= (new models\Order())->calculateSubTotal($order->order_id) ?> LKR
                    </h4>

                </div>
                <div class="col-6 pl-5 mr-0">
                    <div id="order-details-table">
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
                                    <button class="save-dish p-1 m-1">Add</button>
                                </td>
                                <td>
                                    <button class="cancel-dish p-1">Cancel</button>
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
            </div>


        </div>
        <br>

        <div class="popup" id="complete-popup">
            <p>
                Are you sure this order is completed?
            </p>
            <div class="popup-button-div">
                <button class="btn btn-success" id="confirm-complete">Yes</button>
                <button class="btn btn-danger" id="cancel-complete">No</button>
            </div>
        </div>
        <div class="popup" id="reject-popup">
            <p>
                Are you sure you want to reject this order?
            </p>
            <div class="popup-button-div">
                <button class="btn btn-success" id="confirm-reject">Yes</button>
                <button class="btn btn-danger" id="cancel-reject">No</button>
            </div>
        </div>
        <div class="popup" id="delete-popup">
            <p>
                Are you sure you want to delete this order?
            </p>
            <div class="popup-button-div">
                <a href=<?= ROOT . "/admin/orders/delete/" . $order->order_id ?>>
                    <button class="btn btn-success" id="confirm-delete">Yes</button>
                </a>
                <button class="btn btn-danger" id="cancel-delete">No</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>

