<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin</title>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/stats.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="<?= ASSETS ?>/js/admin/stats.js"></script>

</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-3">Statistics</h1>
            <div class="dashboard-buttons">
                <select id="time-select">
                    <option> Past Week</option>
                    <option> Past Month</option>
                    <option> Past Year</option>
                    <option disabled>Custom</option>
                </select>
                <input type="date" name="start-date" value= "<?= date('Y-m-d', strtotime('-1 week')) ?>">
                - <input type="date" name="end-date" value="<?= date('Y-m-d') ?>">

            </div>

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
                <h4>Takeaway</h4>&nbsp;&nbsp;&nbsp;&nbsp;
                <h4>Dine-in
                <br>
                <h4 class="takeaway-time">30 minutes</h4>&nbsp;&nbsp;&nbsp;&nbsp;
                <h4 class="dinein-time">20 minutes</h4>
            </div>
            <div class="card text-center" id="download">
                <h2 class="card-title">Generate Reports</h2>
                <img src="<?= ASSETS ?>/images/admin_dashboard/report.webp" style="max-width: 40%">
                <button id="dow">Download as csv</button>
                <button id="dow">Download as csv</button>
            </div>

        </div>
    </div>
</div>

</body>


</html>