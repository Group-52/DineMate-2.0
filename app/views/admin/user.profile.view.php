<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-5 mb-2"><a class="link" href="<?= ROOT ?>/admin/users">Customers</a><i class="fa-solid fa-chevron-right mx-2"></i>Profile</h1>

            <div class="dashboard-buttons">
                <?php if ($user->blacklisted) : ?>
                    <a href="<?= ROOT ?>/admin/users/blacklist?bl_id=<?=$user->user_id?>&bl=0" class="btn btn-primary">Unblock User</a>
                <?php else : ?>
                <a href="<?= ROOT ?>/admin/users/blacklist?bl_id=<?=$user->user_id?>&bl=1" class="btn btn-primary">Block User</a>
                <?php endif; ?>

            </div>
        </div>

        <div class="row justify-content-space-evenly p-5">
            <div class="w-25">
                <h2>Customer Information</h2>
                <p>Customer ID: <?= $user->user_id ?></p>
                <p>Name: <?= $user->first_name ?>  <?= $user->last_name ?></p>
                <p>Email: <?= $user->email ?></p>
                <p>Contact Number: <?= $user->contact_no ?></p>
                <p>Last Seen: <?= date("Y-m-d H:i:s", strtotime($user->last_login)) ?></p>
            </div>
            <div class="w-25">
                <h2>Order Statistics</h2>
                <p>Average Order Value: <?= $average_value ?> LKR</p>
                <p>Orders Placed: <?= count($prev_orders) ?></p>
            </div>
        </div>


        <h2>Order History</h2>
        <br>
        <div id="order-history">
            <table class="table pt-3">
                <thead class="mb-3">
                <tr>
                    <th>Order ID</th>
                    <th>Time Placed</th>
                    <th>Type</th>
                    <th>Time Completed</th>
                    <th>Paid</th>
                    <th>Total Cost (LKR)</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($prev_orders) && count($prev_orders) > 0) : ?>
                    <?php foreach ($prev_orders as $order) : ?>
                        <tr data-order-id="<?= $order->order_id ?>" data-order-type="<?= $order->type ?>"
                            data-order-status="<?= $order->status ?>">
                            <td class="order-id-field"><?= $order->order_id ?></td>
                            <td>
                                <?= $order->time_placed ?>
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
                            <td>
                                <?= $order->time_completed ?>
                            </td>
                            <td>
                                <?php
                                if ($order->paid == 1)
                                    echo "<i class='fas fa-check-circle' style='color: green;'></i>";
                                else
                                    echo "<i class='fas fa-times-circle' style='color: red;'></i>";
                                ?>
                            </td>
                            <td> <?= $order->total_cost ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">No orders found</td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>
</body>

</html>
<style>
    #order-history {
        height: 75vh;
        overflow-y: scroll;
    }

    thead {
        position: sticky;
        top: 0;
        background-color: grey;
    }
    .order-id-field:hover {
        cursor: pointer;
    }
</style>
<script>
    //when clicked on td order id
    //redirect to order details page
    document.querySelector("#order-history").addEventListener("click", (e) => {
        if (e.target.classList.contains("order-id-field")) {
            const orderId = e.target.innerText;
            window.location.href = `${ROOT}/admin/orders/id/${orderId}`;
        }
    })
</script>