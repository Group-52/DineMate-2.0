<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <script src="<?= ASSETS ?>/js/admin/common.js"></script>
    <script src="<?= ASSETS ?>/js/admin/reports.js"></script>
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-3 active">Reports</h1>
            <div>
            </div>
        </div>

        <div id="formdiv">
            <form>
                <fieldset class="w-50  py-5 row justify-content-center">
                    <div class="form-group w-75">
                        <label for="select-report">Choose Report</label>
                        <select class="form-control w-50" name="select-report">
                            <option value="stats">General Stats</option>
                            <option value="menu_statistics">Menu Sales</option>
                            <option value="orders">Orders</option>
                            <option value="order_dishes">Ordered Dishes</option>
                            <option value="purchases">Purchases</option>
                            <option value="feedback">Feedback</option>
                        </select>
                    </div>
                    <div class="form-group w-75">
                        <label for="start-date">From</label>
                        <input class="form-control w-50" type="date" name="start-date"
                               value="<?= date('Y-m-d', strtotime('-1 week')) ?>">
                    </div>
                    <div class="form-group w-75">
                        <label for="start-date">To</label>
                        <input class="form-control w-50" type="date" name="end-date" value="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="w-75">
                        <a id="generate-button" class="btn btn-primary">Download CSV file</a>
                    </div>
                </fieldset>
            </form>
        </div>

    </div>

</div>
</body>
</html>
