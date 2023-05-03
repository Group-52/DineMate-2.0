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
                    <h3 class="py-5 ml-5 text-left">Payment</h3>
                    <div class="col justify-content-space-evenly">
                        <div class="row">
                            <div class="w-50 p-1 payment-input-label">Sub-total:</div>
                            <div
                                class="w-50 p-1 payment-input-value"><?= (new models\Order())->calculateSubTotal($order->order_id); ?>
                                LKR
                            </div>
                        </div>
                        <div class="row">
                            <div class="w-50 p-1 payment-input-label">Promotion:</div>
                            <div class="w-50 p-1 payment-input-value"><span id="promo">0</span> LKR</div>
                        </div>
                        <div class="row">
                            <div class="w-50 p-1 payment-input-label">Service Charge:</div>
                            <div class="w-50 p-1 payment-input-value"><span
                                    id="sv-charge"><?php if ($order->type == "dine-in") echo (new models\Order())->calculateSubTotal($order->order_id) * 0.05; else echo "0" ?></span>
                                LKR
                            </div>
                        </div>
                        <div class="row">
                            <div class="w-50 p-1 payment-input-label">Net Total:</div>
                            <div class="w-50 p-1 payment-input-value"><span id="Net-total">0</span> LKR</div>
                        </div>
                        <?php if ($order->paid == 0): ?>
                            <div class="row">
                                <div class="w-50 p-1 payment-input-label">Cash:</div>
                                <div class="w-50 p-1 payment-input-value"><input id="cash" type="number" class="w-25"
                                                                                 required> LKR
                                </div>
                            </div>
                            <div class="row">
                                <div class="w-50 p-1 payment-input-label">Balance:</div>
                                <div class="w-50 p-1 payment-input-value"><span id="change">0</span> LKR</div>
                            </div>
                        <?php endif ?>
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
<style>
</style>
<script id="payment">
    let paidbutton = document.querySelector('#complete-payment-button');
    let collectedbutton = document.querySelector('#complete-collected-button');
    var subtotal = <?= $total ?>;
    let promo = document.querySelector("#promo");
    let nettotal = document.querySelector("#Net-total");
    let servicecharge = document.querySelector("#sv-charge");
    let user_id = <?=$order->reg_customer_id ?? $order->guest_id ?>;
    let user_type = "<?= $order->reg_customer_id ? "registered" : "guest" ?>";

    nettotal.innerHTML = parseFloat(subtotal) - parseFloat(promo.innerHTML) + parseFloat(servicecharge.innerHTML) + "";

    if (collectedbutton) {
        collectedbutton.addEventListener('click', function (e) {
            e.preventDefault();
            let data = {
                order_id: <?=$order->order_id ?>,
                collected: 1
            };
            (new Socket()).send_data("collected_order", {
                user_id: user_id,
                user_type: user_type,
                order_id: <?=$order->order_id ?>
            });
        }

        fetch(`${ROOT}/api/orders/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        }).then(res => res.json()).then(res => {
            if (res.status) {
                //after 2 seconds
                setTimeout(function () {
                    window.location.href = `${ROOT}/admin/payments/`;
                }, 2000);
                // console.log(res.status)
            }
        })
    }
    )
    }
    if (paidbutton) {
        let balancespan = document.querySelector("#change");
        let cash = document.querySelector("#cash");
        cash.min = parseFloat(nettotal.innerHTML);
        cash.addEventListener("keyup", function () {
            var balance = parseFloat(cash.value) - parseFloat(nettotal.innerHTML)
            if (balance >= 0)
                balancespan.innerHTML = balance+"";
            else balancespan.innerHTML = "0";
        });
        cash.addEventListener("keydown", function () {
            var balance = parseFloat(cash.value) - parseFloat(nettotal.innerHTML)
            if (balance >= 0)
                balancespan.innerHTML = balance+"";
            else balancespan.innerHTML = "0";
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
                service_charge: parseFloat(servicecharge.innerHTML),
                total_cost: parseFloat(nettotal.innerHTML),
            };

            (new Socket()).send_data("paid_order", {
                user_id: user_id,
                user_type: user_type,
                order_id: <?=$order->order_id ?>
            });
            fetch(`${ROOT}/api/orders/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(res => res.json()).then(res => {
                if (res.status) {
                    //after 2 seconds
                    setTimeout(function () {
                        window.location.href = `${ROOT}/admin/payments/id/<?=$order->order_id ?>`
                    }, 2000);
                }
            })

        })
    }

</script>






