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
            <div class="display-5 fw-bold mr-4"><a href="<?= ROOT ?>/orders/active" class="headings">Active Orders</a></div>
            <div class="display-5 fw-bold secondary">Previous Orders</div>
        </div>
        <?php if (isset($orders) && isset($orderDishes) && sizeof($orderDishes) > 0) : ?>
            <div class="orders">
                <?php foreach ($orders as $order): ?>
                    <div class="order px-4 py-3 rounded-sm shadow-sm mb-3">
                        <div class="d-flex flex-row fw-bold fs-4 align-items-center mb-3">
                            <div class="col-md-6">
                                <div>Order ID: #<?= $order->order_id ?></div>
                                <div class="fs-6"><?= $order->time_placed ?></div>
                            </div>
                            <div class="col-md-6 d-flex flex-row justify-content-end align-items-center">
                                <?php if (isRegistered()) : ?>
                                <div class="d-flex flex-column justify-content-end text-right align-items-center add-feedback pointer
                                    <?php if (!empty($order->rating)) echo " d-none" ?>" data-order="<?= $order->order_id ?>">
                                    <i class="fa-solid fa-comment fs-2"></i>
                                    <span class="fs-6">Feedback</span>
                                </div>
                                <div class="stars <?php if (empty($order->rating)) echo " d-none" ?>" data-order="<?= $order->order_id ?>">
                                    <?php for ($i = 0; $i < $order->rating; $i++): ?>
                                        <i class="fa-solid fa-star fs-2 star" data-stars="<?= $i + 1 ?>"></i>
                                    <?php endfor; ?>
                                    <?php for ($i = $order->rating; $i < 5; $i++): ?>
                                        <i class="fa-solid fa-star fs-2" data-stars="<?= $i + 1 ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <?php endif ?>
                                <div class="ml-2">
                                    <i class="fa-solid fa-chevron-down chevron"></i>
                                </div>
                            </div>
                        </div>
                        <?php if (isRegistered()) : ?>
                        <div class="text-right fs-6 h-0 secondary edit-feedback pointer
                        <?php if (empty($order->rating)) echo "d-none" ?>
                        " data-order="<?= $order->order_id ?>">
                            Edit Feedback
                        </div>
                        <?php endif ?>
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
                            <tr>
                                <td></td>
                                <td>Sub-Total</td>
                                <td></td>
                                <td class="fw-bold fs-4">LKR <?= $order->sub_total?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Discount</td>
                                <td></td>
                                <td class="fw-bold fs-4">LKR <?= $order->discount?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Service Charge</td>
                                <td></td>
                                <td class="fw-bold fs-4">LKR <?= $order->service_charge?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="fw-bold secondary fs-3">Total</td>
                                <td></td>
                                <td class="fw-bold fs-4 px-2 single-line">LKR <?= $order->total?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (isset($pagination)) {
                $pagination->render();
            } ?>
        <?php else : ?>
            <div class="lead w-100 text-center">No Active Orders</div>
        <?php endif ?>
    </div>
</div>
<div class="modal-wrapper">
    <div class="modal shadow-sm rounded-sm p-4">
        <i class="fa-solid fa-times close modal-close fs-3"></i>
        <h1 class="heading-4">Feedback</h1>
        <input type="hidden" id="order-id">
        <input type="hidden" id="feedback-id">
        <input type="hidden" id="rating">
        <div class="form-group">
            <label for="rating" class="label text-uppercase fw-bold">Rating</label>
            <div>
                <div class="stars stars-editable">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <i class="fa-solid fa-star fs-2" data-stars="<?= $i + 1 ?>"></i>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="label text-uppercase fw-bold">Description</label>
            <textarea name="feedback" id="description" cols="30" rows="10" class="form-control"></textarea>
        </div>
        <div class="text-right">
            <button class="btn btn-primary text-uppercase" id="submit-feedback">Submit</button>
        </div>
    </div>
</div>
<?php include VIEWS . "/partials/home/footer.partial.php"; ?>
<script src="<?php echo ASSETS . "/js/orders.js" ?>"></script>
</body>

</html>
