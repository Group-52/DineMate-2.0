<!DOCTYPE html>
<html lang="en">
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
            <h1 class="display-5 mb-2"><a class="link" href="<?= ROOT ?>/admin/payments">Payments</a><i
                    class="fa-solid fa-chevron-right mx-2"></i>Details</h1>
        </div>
        <?php
        if (isset($order)) : ?>
            <h3 class="heading-3">Order ID: #<?= $order->order_id ?></h3>
            <h3 class="heading-4">Customer ID: # <?= $order->reg_customer_id ?? "G" . $order->guest_id ?></h3>
            <?php if (isset($order->first_name)) : ?><h3 class="heading-4">
                Customer Name: <?= $order->first_name . " " . $order->last_name ?></h3><?php endif ?>
            <?php if (isset($order->table_id)) : ?><h3>Table: <?= $order->table_id ?></h3><?php endif ?>
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
                    <h3 class="mb-2 heading-2">Payment</h3>
                    <div class="col justify-content-space-evenly fs-4">
                        <div class="row">
                            <div class="w-50 p-1 payment-input-label">Sub-total:</div>
                            <div
                                class="w-25 p-1 payment-input-value text-right"><?= (new models\Order())->calculateSubTotal($order->order_id); ?>
                                LKR
                            </div>
                        </div>
                        <div class="row">
                            <div class="w-50 p-1 payment-input-label">Promotion:</div>
                            <div class="w-25 p-1 payment-input-value text-right"><span id="promo">
                              <?= (new models\Promotion())->reducedCost($order->order_id, $order->promo); ?></span> LKR
                            </div>
                        </div>
                        <div class="row">
                            <div class="w-50 p-1 payment-input-label">Service Charge:</div>
                            <div class="w-25 p-1 payment-input-value text-right"><span
                                    id="sv-charge"><?= $sv_charge ?></span>
                                LKR
                            </div>
                        </div>
                        <div class="row">
                            <div class="w-50 p-1 payment-input-label">Net Total:</div>
                            <div id="net-total-value" class="w-25 p-1 payment-input-value fw-bold secondary text-right">
                                <span id="Net-total"><?= $net_total ?></span> LKR
                            </div>
                            &nbsp;&nbsp;
                            <i class="fas fa-pencil-alt"></i>
                            <div id="net-total-input" class="row w-25 p-1 payment-input-value mr-0 justify-content-end">
                                <input class="d-inline form-control p-0 m-0" style="width:70px; height:25px; font-size: small"
                                       type="number" min="0" oninput="validity.valid||(value='');" step="0.1"
                                       value="<?= $net_total ?>">
                                <i class="fas fa-circle-xmark" style="font-size: smaller"></i>
                                <i class="fa fa-check-circle tick-icon" style="font-size: smaller"></i>
                            </div>
                        </div>

                    </div>
                    <?php if ($order->paid == 0): ?>
                        <div class="row">
                            <div class="w-50 p-1 payment-input-label">Cash:</div>
                            <div class="w-25 p-1 payment-input-value text-right">
                                <input style="display:inline-block; width:80px; font-size: small" class="p-1 text-right form-control" id="cash" type="number" required> LKR
                            </div>
                        </div>
                        <div class="row">
                            <div class="w-50 p-1 payment-input-label">Balance:</div>
                            <div class="w-25 p-1 payment-input-value text-right"><span id="change">0</span> LKR</div>
                        </div>
                    <?php endif ?>
                </div>
                <div class="row w-100 justify-content-start">
                    <?php if ($order->paid == 0): ?>
                        <button class="btn btn-primary text-uppercase fw-bold" id="complete-payment-button"
                                type="submit">Complete
                            Payment
                        </button>
                    <?php else: ?>
                        <button class="btn btn-primary text-uppercase fw-bold" id="complete-collected-button"
                                type="submit">Order
                            Collected
                        </button>
                    <?php endif ?>
                </div>

            </form>
        </div>
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
    let netinput = document.querySelector("#net-total-input");
    let netvalue = document.querySelector("#net-total-value");
    let pencil = document.querySelector(".fa-pencil-alt");
    let tick = document.querySelector(".fa-check-circle");
    let cross = document.querySelector(".fa-circle-xmark");

    pencil.style.display = "none";
    netinput.style.display = "none";
    tick.style.display = "none";
    cross.style.display = "none";

    pencil.addEventListener('click', function (e) {
        e.preventDefault();
        netinput.style.display = "block";
        netvalue.style.display = "none";
        pencil.style.display = "none";
        tick.style.display = "inline";
        cross.style.display = "inline";
        paidbutton.disabled = true;
    });

    cross.addEventListener('click', function (e) {
        e.preventDefault();
        netinput.style.display = "none";
        netvalue.style.display = "block";
        pencil.style.display = "inline";
        tick.style.display = "none";
        cross.style.display = "none";
        paidbutton.disabled = false;
    });

    tick.addEventListener('click', function (e) {
        e.preventDefault();
        netinput.style.display = "none";
        netvalue.style.display = "block";
        pencil.style.display = "inline";
        tick.style.display = "none";
        cross.style.display = "none";
        paidbutton.disabled = false;
        if (netinput.querySelector("input").value == "") {
            netinput.querySelector("input").value = 0;
        }
        nettotal.innerHTML = netinput.querySelector("input").value;
    });

    if (<?=$order->paid?> != 1) {
        nettotal.innerHTML = parseFloat(subtotal) - parseFloat(promo.innerHTML) + parseFloat(servicecharge.innerHTML) + "";
        pencil.style.display = "inline";
    }

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
                        }, 1000);
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
                balancespan.innerHTML = balance + "";
            else balancespan.innerHTML = "0";
        });
        cash.addEventListener("keydown", function () {
            var balance = parseFloat(cash.value) - parseFloat(document.querySelector("#Net-total").innerHTML)
            if (balance >= 0)
                balancespan.innerHTML = balance + "";
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
                total_cost: parseFloat(document.querySelector("#Net-total").innerHTML),
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






