<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin</title>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="<?= ASSETS ?>/js/admin/dashboard.js"></script>

</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header text-center">

            <h1 class="display-3 active">DINEMATE</h1>
        </div>
        <div class="card-container">
            <div class="card">
                <h3 class="card-title">Popular Times</h3>
                <canvas id="myBarChart" width="1600" height="900"></canvas>
            </div>
            <div class="card">
                <h3 class="card-title">Customers</h3>
                <canvas id="myLineChart" width="1600" height="900"></canvas>
            </div>
            <div class="card">
                <h3 class="card-title">Menu Sales</h3>
                <canvas id="myPieChart" width="1600" height="900"></canvas>
            </div>

            <div class="card">
                <h3 class="card-title">Finances</h3>
                <canvas id="myStackedLineChart" width="1600" height="900"></canvas>
            </div>

            <div class="card">
                <h3 class="card-title">Expiry Risk</h3>
                <div class="table-in-card">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Amount</th>
                            <th>Expiry Date</th>
                        </tr>
                        </thead>
                        <tbody id="expiry-risk-items">
                        <?php foreach ($data['expiringitems'] as $item) : ?>
                            <tr>
                                <td><?= $item->item_name ?></td>
                                <td><?= $item->amount_remaining ?> <?= $item->abbreviation ?></td>
                                <td><?= $item->expiry_date ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card" style="height: fit-content">
                <h3 class="card-title">Low Stock</h3>
                <div class="table-in-card">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody id="low-stock-items">
                        <?php foreach ($data['lowstockitems'] as $item) : ?>
                            <tr>
                                <td><?= $item->item_name ?></td>
                                <td><?= $item->amount_remaining ?> <?= $item->abbreviation ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <h3 class="card-title">Order submit</h3>
                <form id="f2" style="padding: 10px; margin: 10px">
                    <input type="number" name="order_id" placeholder="Order ID">
                    <input type="text" name="status" value="pending" disabled>
                    <input type="text" name="time_placed" value="2020-12-12 12:12:12" disabled>
                    <input type="text" name="request" placeholder="Request">
                    <input type="number" name="reg_customer_id" placeholder="Customer ID" value=<?= rand() ?> disabled>
                    <select name="type">
                        <option value="takeaway">Takeaway</option>
                        <option value="bulk">Bulk</option>
                        <option value="dine-in">Dine-in</option>
                    </select>


                    <input type="submit" value="Submit">
                </form>
            </div>


        </div>
    </div>
</div>


</body>


</html>