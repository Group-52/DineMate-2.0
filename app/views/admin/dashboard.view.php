<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin</title>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/dashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="<?= ASSETS ?>/js/admin/common.js"></script>
    <script src="<?= ASSETS ?>/js/admin/dashboard.js"></script>

</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-3">Overview</h1>
            <div class="dashboard-buttons p-1">
                <select id="time-select" class="p-1">
                    <option> Past Week</option>
                    <option> Past Month</option>
                    <option> Past Year</option>
                    <option disabled>Custom</option>
                </select>
                <input type="date" class="m-1" name="start-date" value="<?= date('Y-m-d', strtotime('-1 week')) ?>">&nbsp
                - &nbsp <input type="date" class="m-1" name="end-date" value="<?= date('Y-m-d') ?>">
            </div>

        </div>
        <div class="d-flex flex-wrap justify-content-space-between">

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

            <div class="card text-center" id="takeaway">
                <img src="<?= ASSETS ?>/images/admin_dashboard/takeaway.jpg">
                <br><br>
                <h2 class="card-title">Takeaway Orders</h2>
                <h2>...</h2>
            </div>
            <div class="card text-center" id="bulk">
                <img src="<?= ASSETS ?>/images/admin_dashboard/bulk.png">
                <h2 class="card-title">Bulk Orders</h2>
                <h2>...</h2>

            </div>
            <div class="card text-center" id="dinein">
                <img src="<?= ASSETS ?>/images/admin_dashboard/dinein.png">
                <br><br>
                <h2 class="card-title">Dine-in Orders</h2>
                <h2>...</h2>
            </div>
            <div class="card text-center" id="cost">
                <img src="<?= ASSETS ?>/images/admin_dashboard/cost.png" style="max-width: 40%;">
                <h2 class="card-title">Food Cost</h2>
                <h2>...</h2>
            </div>
            <div class="card text-center" id="revenue">
                <img src="<?= ASSETS ?>/images/admin_dashboard/dollar.png" style="max-width:40%">
                <h2 class="card-title">Revenue</h2>
                <h2>...</h2>
            </div>
            <div class="card text-center" id="clock">
                <h2 class="card-title">Wait Times</h2>
                <img src="<?= ASSETS ?>/images/admin_dashboard/clock.jpeg" style="max-width: 40%">
                <br>
                <h4 class="d-inline">Takeaway</h4>&nbsp;&nbsp;&nbsp;&nbsp;
                <h4 class="d-inline">Dine-in
                    <br>
                    <span class="takeaway-time">30 minutes</span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="dinein-time">20 minutes</span>
            </div>

            <div class="card">
                <br>
                <h3 class="card-title">Refill Stock</h3>
                <!--                Two columns of unordered lists-->
                <div class="row">
                    <?php $n= count($data['lowstockitems'])?>
                    <div class="col-6 text-center">
                        <ul class="dashboard-ulist">
                            <?php for ($i = 0; $i < ceil($n/2); $i++) : ?>
                                <li><?= $data['lowstockitems'][$i]->item_name ?></li>
                            <?php endfor; ?>
                        </ul>
                    </div>

                    <div class="col-6 text-center">
                        <ul class="dashboard-ulist">
                            <?php for ($i = ceil($n/2); $i < $n; $i++) : ?>
                                <li><?= $data['lowstockitems'][$i]->item_name ?></li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card">
                <br>
                <h3 class="card-title">At risk of expiration</h3>
                <!--                Two columns of unordered lists-->
                <div class="row">
                            <?php $n= count($data['expiringitems'])?>
                    <div class="col-6 text-center">
                        <ul class="dashboard-ulist">
                            <?php for ($i = 0; $i < ceil($n/2); $i++) : ?>
                                <li><?= $data['expiringitems'][$i]->item_name ?></li>
                            <?php endfor; ?>
                        </ul>
                    </div>

                    <div class="col-6 text-center">
                        <ul class="dashboard-ulist">
                            <?php for ($i = ceil($n/2); $i < $n; $i++) : ?>
                                <li><?= $data['expiringitems'][$i]->item_name ?></li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>


</html>