<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <script src="<?= ASSETS ?>/js/components/qrcode.min.js"></script>
    <script src="<?= ASSETS ?>/js/admin/payments.js"></script>
    <title>Payments</title>
</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div id="blur-container">
            <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-5 mb-2">Payments</h1>
                <div class="dashboard-buttons" style="width:400px;">
                    <select class="form-control d-inline mx-4" name="status" style="width:30%;">
                        <option value="all">All</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="accepted">Accepted</option>
                    </select>
                    <a class="btn btn-primary text-uppercase fw-bold d-inline-block"
                       href="<?php echo ROOT ?>/admin/payments/addOrder"
                       id="add-order-button">+ Create Order</a>

                </div>
            </div>
            <div class="w-100 p-2 d-flex justify-content-space-evenly" style="color: white">
                <span class="btn text-uppercase fw-bold" id="unpaid-header">Unpaid</span>
                <span class="btn text-uppercase fw-bold" id="tocollect-header">To Collect</span>
            </div>
            <div id="tobepaid-table" style="display: none;">
                <table class="table">
                    <thead>
                    <tr class="fs-6">
                        <th>O_ID</th>
                        <th>C_Id</th>
                        <th>Name</th>
                        <th>Time Placed</th>
                        <th>Type</th>
                        <th>Estimated Time</th>
                        <th>Total Cost (LKR)</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($tobepaid)) : ?>
                        <?php foreach ($tobepaid as $order) : ?>
                            <tr data-order-id="<?= $order->order_id ?>" data-order-type="<?= $order->type ?>"
                                data-order-status="<?= $order->status ?>">
                                <td class="order-id-field"><?= $order->order_id ?></td>
                                <td><?= $order->guest_id ? "G" : "" ?><?= $order->reg_customer_id ?? $order->guest_id ?></td>
                                <td>
                                    <?php if (isset($order->first_name) && isset($order->last_name) && $order->first_name != "" && $order->last_name != "")
                                        echo $order->first_name . " " . $order->last_name;
                                    else
                                        echo "Guest";
                                    ?>
                                </td>

                                <td>
                                    <?= date('M jS g:i A', strtotime($order->time_placed)) ?>

                                </td>

                                <td>
                                    <?php
                                    if ($order->type == "dine-in")
                                        echo "<img src='" . ASSETS . "/icons/table.png' alt='dine-in' width='30' height='30'> " . $order->table_id;
                                    else if ($order->type == "takeaway")
                                        echo "<img src='" . ASSETS . "/icons/fastcart.png' alt='take-away' width='30' height='30'>";
                                    else if ($order->type == "bulk")
                                        echo "<img src='" . ASSETS . "/icons/bulk.svg' alt='bulk' width='30' height='30'>";
                                    ?>

                                </td>
                                <td><?php
                                    if ($order->scheduled_time != null)
                                        echo "Scheduled for " . date('g:i A', strtotime($order->scheduled_time));
                                    else if ($order->status == "completed")
                                        echo "Completed";
                                    else if ($order->status == "rejected")
                                        echo "Rejected";
                                    else if ($order->status == "pending")
                                        echo "Pending";
                                    else {
                                        $x = (new models\Order())->getTimeRemaining($order->order_id);
                                        echo $x . " minutes";
                                    }
                                    ?>

                                </td>
                                <td> <?= (new models\Order())->calculateFullTotal($order->order_id) ?></td>
                                <td><a class='edit-icon-link text-danger'
                                       href='<?= ROOT ?>/admin/payments/id/<?= $order->order_id ?>'><i
                                            class='fa fa-credit-card'></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr class="text-center no-orders">
                            <td colspan="7">No Orders available</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>

                </table>
            </div>
            <div id="tobecollected-table" style="display: none;">
                <table class="table">
                    <thead>
                    <tr class="fs-6">
                        <th>O_ID</th>
                        <th>C_Id</th>
                        <th>Name</th>
                        <th>Time Placed</th>
                        <th>Type</th>
                        <th>Estimated Time</th>
                        <th>Total Cost (LKR)</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($tobecollected)) : ?>
                        <?php foreach ($tobecollected as $order) : ?>
                            <tr data-order-id="<?= $order->order_id ?>" data-order-type="<?= $order->type ?>"
                                data-order-status="<?= $order->status ?>">
                                <td class="order-id-field"><?= $order->order_id ?></td>
                                <td><?= $order->guest_id ? "G" : "" ?><?= $order->reg_customer_id ?? $order->guest_id ?></td>
                                <td>
                                    <?php if (isset($order->first_name))
                                        echo $order->first_name . " " . $order->last_name;
                                    else
                                        echo "Guest";
                                    ?>
                                </td>

                                <td>
                                    <?= date('M jS g:i A', strtotime($order->time_placed)) ?>
                                </td>

                                <td>
                                    <?php
                                    if ($order->type == "dine-in")
                                        echo "<img src='" . ASSETS . "/icons/table.png' alt='dine-in' width='30' height='30'> " . $order->table_id;
                                    else if ($order->type == "takeaway")
                                        echo "<img src='" . ASSETS . "/icons/fastcart.png' alt='take-away' width='30' height='30'>";
                                    else if ($order->type == "bulk")
                                        echo "<img src='" . ASSETS . "/icons/bulk.svg' alt='bulk' width='30' height='30'>";
                                    ?>

                                </td>
                                <td><?php
                                    if ($order->scheduled_time != null)
                                        echo "Scheduled for " . date('g:i A', strtotime($order->scheduled_time));
                                    else if ($order->status == "completed")
                                        echo "Completed";
                                    else if ($order->status == "rejected")
                                        echo "Rejected";
                                    else if ($order->status == "pending")
                                        echo "Pending";
                                    else {
                                        $x = (new models\Order())->getTimeRemaining($order->order_id);
                                        echo $x . " minutes";
                                    }
                                    ?>

                                </td>
                                <td> <?= $order->total_cost ?></td>
                                <td><a class='edit-icon-link text-danger'
                                       href='<?= ROOT ?>/admin/payments/id/<?= $order->order_id ?>'><i
                                            class='fa fa-credit-card'></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="text-center no-orders">
                            <td colspan="7">No Orders available</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>
        <div class="popup pt-1" id="customer-type-popup">
            <div class="popup-button-div pt-0">
                <span class="p-0 row justify-content-end"> <i id="close-icon" class="fa fa-times"></i></span>
                <br>
                <button class="btn btn-success" id="return-customer">Returning Customer</button>
                <button class="btn btn-danger" id="new-customer">New Customer</button>
                <br>
            </div>
        </div>

        <div class="popup pt-1 w-50" id="reg-email-popup">
            <span class="p-0 row justify-content-end"> <i id="close-icon2" class="fa fa-times"></i></span>
            <br>
            <input class="form-control" type="text" placeholder="Enter Email" id="reg-email">
            <br><br>
            <button class="btn btn-success" id="reg-email-submit">Submit</button>
        </div>

    </div>


</body>
</html>

<script>
    const userlist = <?= json_encode($userlist) ?>;
    const regsubmit = document.querySelector('#reg-email-submit')
    let emails = []
    userlist.forEach(user => {
        emails.push(user.email)
    })
    // console.log(emails)
    regsubmit.addEventListener('click', function () {
        let email = document.querySelector('#reg-email-popup').querySelector('#reg-email').value
        // console.log(email)
        if (emails.includes(email)) {
            //clear form
            document.querySelector('#reg-email-popup').querySelector('#reg-email').value = ""
            window.location.href = `${ROOT}/admin/payments/addOrder?utype=registered&email=${email}`;
        } else {
            new Toast("fa-solid fa-exclamation-circle", "red", "Error", "Email not found", false, 3000);
        }
    })

</script>
