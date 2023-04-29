<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    use models\Order;
    use models\OrderDishes;
    include VIEWS . "/partials/home/head.partial.php" ?>
</head>

<body class="body-min-vh-100">
<div class="wrapper">
    <?php include VIEWS . "/partials/home/navbar.partial.php"; ?>
    <div class="container my-5">
        <h1 class="display-4">Orders</h1>
        <div class="mb-5 d-flex flex-row">
            <div class="display-5 fw-bold secondary mr-4">Active Orders</div>
            <div class="display-5 fw-bold">Previous Orders</div>
        </div>
        <?php if (isset($orders) && isset($orderDishes)) : ?>
        <div class="orders">
            <?php foreach ($orders as $order): ?>
            <div class="order px-4 py-3 rounded-sm shadow-sm mb-3">
               <div class="d-flex flex-row fw-bold fs-4 align-items-center mb-3">
                   <div class="col-md-4">
                        Order ID: #<?= $order->order_id ?>
                   </div>
                   <div class="col-md-4 text-center">
                       <span class="<?= $order->status ?>"><?= ucwords($order->status) ?></span>
                   </div>
                   <div class="col-md-4 d-flex flex-row justify-content-end align-items-center">
                       <div class="d-flex flex-column justify-content-end text-right align-items-center">
                           <i class="fa-solid fa-comment fs-2"></i>
                           <span class="fs-6">Feedback</span>
                       </div>
                       <div class="ml-2">
                           <i class="fa-solid fa-chevron-down chevron"></i>
                       </div>
                   </div>
               </div>
                <?php $orderDish = $orderDishes[$order->order_id] ?>
                <table class="table order">
                    <tbody>
                        <?php foreach ($orderDish as $dish): ?>
                        <tr>
                            <td class="td-img">
                                <img src="<?= ASSETS . "/images/dishes/" . $dish->image_url ?>" alt="Ginger Beer">
                            </td>
                            <td><?= $dish->dish_name ?></td>
                            <td class="fit px-3"><?= $dish->quantity ?> pcs.</td>
                            <td class="fw-bold fit fs-4 px-3">LKR <?= $dish->net_price ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif ?>
    </div>
</div>
<script src="<?php echo ASSETS . "/js/orders.js" ?>"></script>
</body>

</html>