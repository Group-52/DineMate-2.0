<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
</head>

<body class="body-min-vh-100">
<div class="wrapper">
    <?php include VIEWS . "/partials/home/navbar.partial.php"; ?>
    <div class="container my-5">
        <h1 class="display-4 mb-3">Order Details</h1>
        <?php if (isset($form)) : ?>
            <?php
            /** @var components\Form $form */
            $form->beginForm();
            ?>
            <div class="row">
                <div class="col-md-6 col-12">
                    <?php for ($i = 0; $i < (isGuest() ? 3 : 5); $i++) {
                        echo $form->htmlField($i);
                    } ?>
                    <?php if (isGuest()): ?>
                        <h2 class='display-5 mb-3'>Personal Info</h2>
                        <?php for ($i = 3; $i < $form->countFields(); $i++) {
                            echo $form->htmlField($i);
                        } ?>
                    <?php endif; ?>
                </div>
                <div class="col-offset-md-1 col-md-5 col-12">
                    <h2 class="display-5">Order Summary</h2>
                    <table id="cart-table" class="table cart">
                        <thead>
                        <tr>
                            <th scope="col">Item</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($cart) && isset($discount) && isset($total) && isset($subtotal)): ?>
                            <?php foreach ($cart as $item) : ?>
                                <tr>
                                    <td><?= $item->dish_name ?></td>
                                    <td><?= $item->quantity ?></td>
                                    <?php
                                    $price = (float)$item->selling_price * (float)$item->quantity;
                                    ?>
                                    <td><?= $price ?></td>
                                </tr>
                            <?php endforeach ?>
                            <tr class="secondary fs-5" id="cart-sub-total">
                                <td colspan="2" class="fw-bold">SUB TOTAL</td>
                                <td class="fw-bold"><?= $subtotal ?></td>
                            </tr>
                            <tr class="secondary fs-5">
                                <td colspan="2" class="fw-bold">DISCOUNT</td>
                                <td class="fw-bold"><?= $discount ?></td>
                            </tr>
                            <tr class="secondary fs-5">
                                <td colspan="2" class="fw-bold">SERVICE CHARGE</td>
                                <td class="fw-bold" id="service-charge">0</td>
                            </tr>
                            <tr class="secondary fs-4">
                                <td colspan="2" class="fw-bold">TOTAL</td>
                                <td class="fw-bold" id="total"><?= $total ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-5">
                <?= $form->htmlButton(false) ?>
            </div>
            <?php
            $form->endForm();
        endif; ?>
    </div>
</div>
<script src="<?= ASSETS ?>/js/checkout.js"></script>
<?php include VIEWS . "/partials/home/footer.partial.php"; ?>
</body>
</html>