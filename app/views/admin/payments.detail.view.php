<!DOCTYPE html>

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <title>pay</title>
</head>


<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header">
            <h1 class="display-3 active">Payment Details</h1>
        </div>
        <?php
        if (isset($order)) : ?>
            <h3>Order ID: #<?= $order->order_id ?></h3>
            <h3>Customer ID: #<?= $order->reg_customer_id ?? $order->guest_id ?></h3>
            <?php if (isset($order->first_name)) : ?><h3>Customer
                Name: <?= $order->first_name . " " . $order->last_name ?></h3><?php endif ?>
            <?php if (isset($order->table_id)) : ?><h4>Table: <?= $order->table_id ?></h4><?php endif ?>
            <br><br>
        <?php endif ?>

        <div id="order-details-table">
            <table class="table">
                <thead>

                <tr>
                    <th>Dish</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total = 0;
                if (isset($dishes))
                    foreach ($dishes as $orderDish) {
                        echo '<tr>';
                        echo '<td>' . $orderDish->dish_name . '</td>';
                        echo '<td>' . $orderDish->quantity . '</td>';
                        echo '<td>' . $orderDish->selling_price . '</td>';
                        echo '<td>' . $orderDish->quantity * $orderDish->selling_price . '</td>';
                        $total += $orderDish->quantity * $orderDish->selling_price;
                        echo '</tr>';
                    }
                ?>

                </tbody>

            </table>

            <form>
                <div class="col-offset-6 p-5">
                    <h3 class="py-5 text-center">Cash Payment</h3>
                    <div class="row justify-content-space-evenly">
                        <div class="col">
                            Sub-total:<br>
                            Promotion:<br>
                            Net Total:<br>
                            <?php if ($order->paid == 0): ?>

                                Cash:<br>
                                <hr class="my-1">
                                Balance:<br>
                            <?php endif ?>

                        </div>
                        <div class="col pl-0">
                            <?= $total ?> LKR<br>
                            <span id="promo">0</span> LKR<br>
                            <span id="Net-total"></span> LKR<br>
                            <?php if ($order->paid == 0): ?>

                                <input type="number" required class="form-control d-inline w-50 h-25"> LKR<br>
                                <hr class="w-75 my-1">
                                <span id="change"></span>
                            <?php endif ?>


                        </div>
                    </div>
                    <div class="row w-100 justify-content-start">
                        <?php if ($order->paid == 0): ?>
                            <button class="m-5 ml-0 btn btn-primary" id="complete-payment-button" type="submit">Complete
                                Payment
                            </button>
                        <?php else: ?>
                            <button class="m-5 ml-0 btn btn-primary" id="complete-collected-button" type="submit">Order
                                Collected
                            </button>
                        <?php endif ?>
                    </div>

                </div>
            </form>
        </div>
    </div>
</body>
</html>

<script id="payment">
    let paidbutton = document.querySelector('#complete-payment-button');
    let collectedbutton = document.querySelector('#complete-collected-button');
    var subtotal = <?= $total ?>;
    let promo = document.querySelector("#promo");
    let nettotal = document.querySelector("#Net-total");
    nettotal.innerHTML = parseFloat(subtotal) - parseFloat(promo.innerHTML) + "";

    if (collectedbutton) {
        collectedbutton.addEventListener('click', function (e) {
            e.preventDefault();
            let data = {
                order_id: <?=$order->order_id ?>,
                collected: 1
            }
            fetch(`${ROOT}/api/orders/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(res => res.json()).then(res => {
                if (res.status) {
                    window.location.href = `${ROOT}/admin/payments/`;
                    // console.log(res.status)
                }
            })
        })
    }
    if (paidbutton) {
        let balancespan = document.querySelector("#change");
        let cash = document.querySelector(".col input[type=number]");
        cash.min = parseFloat(nettotal.innerHTML);
        cash.addEventListener("keyup", function () {
            var balance = parseFloat(cash.value) - parseFloat(nettotal.innerHTML)
            if (balance >= 0)
                balancespan.innerHTML = balance + " LKR";
        });
        cash.addEventListener("keydown", function () {
            var balance = parseFloat(cash.value) - parseFloat(nettotal.innerHTML)
            if (balance >= 0)
                balancespan.innerHTML = balance + " LKR";
        });
        paidbutton.addEventListener('click', function (e) {
            e.preventDefault();
            if ((cash.value == "") || (cash.value < parseFloat(nettotal.innerHTML))) {
                alert("Cash is not enough");
                return;
            }
            let data = {
                order_id: <?=$order->order_id ?>,
                paid: 1,
                total_cost: parseFloat(nettotal.innerHTML),
            }
            fetch(`${ROOT}/api/orders/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(res => res.json()).then(res => {
                if (res.status) {
                    window.location.href = `${ROOT}/admin/payments/id/<?=$order->order_id ?>`
                }
            })

        })
    }

</script>






