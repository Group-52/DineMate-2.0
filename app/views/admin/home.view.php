<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/home.css">
    <script src="<?= ASSETS ?>/js/admin/home.js"></script>
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <div class="w-100 h-100 p-5 maindiv">
        <h1 class="display-3 text-center mb-3">Dashboard</h1>
        <div class="row justify-content-space-evenly h-100">
            <div class="col-4 justify-content-center text-center">
                <span class="display-4 type-header pb-3 mb-5">Kitchen</span>
                <br>
                <a href="<?= ROOT ?>/admin/items">
                    <div class="card">
                        <span class="d-inline-block fs-5">Stock Items</span>
                        <i class="fa-solid fa-sitemap d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/menus">
                    <div class="card">
                        <span class="d-inline-block fs-5">Menus</span>
                        <i class="fa-solid fa-newspaper d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/inventory/dashboard">
                    <div class="card">
                        <span class="d-inline-block fs-5">Inventory</span>
                        <i class="fa-solid fa-box d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/orders/history">
                    <div class="card">
                        <span class="d-inline-block fs-5">Orders</span>
                        <i class="fa-solid fa-shopping-cart d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/dishes">
                    <div class="card">
                        <span class="d-inline-block fs-5">Dishes</span>
                        <i class="fa-solid fa-bowl-rice d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/ingredients">
                    <div class="card">
                        <span class="d-inline-block fs-5">Recipes</span>
                        <i class="fa-solid fa-carrot d-inline"></i>
                    </div>
                </a>

            </div>
            <div class="col-4 justify-content-center text-center">
                <span class="display-4 type-header pb-3 mb-5">Admin</span>
                <br>
                <a href="<?= ROOT ?>/admin/employees">
                    <div class="card">
                        <span class="d-inline-block fs-5">Employee Details</span>
                        <i class="fa-solid fa-user d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/payments">
                    <div class="card">
                        <span class="d-inline-block fs-5">Payments</span>
                        <i class="fa-solid fa-credit-card d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/feedback">
                    <div class="card">
                        <span class="d-inline-block fs-5">Feedback</span>
                        <i class="fa-solid fa-comment-dots d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/users">
                    <div class="card">
                        <span class="d-inline-block fs-5">User Details</span>
                        <i class="fa-solid fa-users d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/vendors">
                    <div class="card">
                        <span class="d-inline-block fs-5">Vendors</span>
                        <i class="fa-solid fa-truck d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/promotions">
                    <div class="card">
                        <span class="d-inline-block fs-5">Promotions</span>
                        <i class="fa-solid fa-gift d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/purchases">
                    <div class="card">
                        <span class="d-inline-block fs-5">Stock Purchases</span>
                        <i class="fa-solid fa-shopping-cart d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/home/stats">
                    <div class="card">
                        <span class="d-inline-block fs-5">Analytics</span>
                        <i class="fa-solid fa-chart-pie d-inline"></i>
                    </div>
                </a>
                <a href="<?= ROOT ?>/admin/home/reports">
                    <div class="card">
                        <span class="d-inline-block fs-5">Reports</span>
                        <i class="fa-solid fa-download d-inline"></i>
                    </div>
                </a>

            </div>
        </div>
    </div>
</div>
</body>
</html>