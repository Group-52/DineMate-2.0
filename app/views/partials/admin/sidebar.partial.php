<div id="sidebar" class="sidebar p-5 pt-1">

    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "home") echo " active" ?>"
       href="<?= ROOT ?>/admin/home">
        <i class="fa-solid fa-house d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;Dashboard</span>
    </a>
    <?php if (utils\RouteAuth::icon_visible('items')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "items") echo " active" ?>"
       href="<?= ROOT ?>/admin/items">
        <i class="fa-solid fa-sitemap d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;Items</span>
    </a>
    <?php endif; ?>
    <?php if (utils\RouteAuth::icon_visible('inventory')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && ($controller == "inventory")) echo " active" ?>"
       href="<?= ROOT ?>/admin/inventory">
        <i class="fa-solid fa-box d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;Inventory</span>
    </a>
    <?php endif; ?>
    <?php if (utils\RouteAuth::icon_visible('ingredients')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "ingredients") echo " active" ?>"
       href="<?= ROOT ?>/admin/ingredients">
        <i class="fa-solid fa-carrot"></i><span class="sidebar-text">&nbsp;Ingredients</span>
    </a>
    <?php endif; ?>
    <?php if (utils\RouteAuth::icon_visible('menus')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "menus") echo " active" ?>"
       href="<?= ROOT ?>/admin/menus">
        <i class="fa-solid fa-utensils"></i><span class="sidebar-text">&nbsp;&nbsp;Menus</span>
    </a>
    <?php endif; ?>
    <?php if (utils\RouteAuth::icon_visible('purchases')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "purchases") echo " active" ?>"
       href="<?= ROOT ?>/admin/purchases">
        <i class="fa-solid fa-shopping-cart d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;Purchases</span>
    </a>
    <?php endif; ?>
    <?php if (utils\RouteAuth::icon_visible('dishes')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "dishes") echo " active" ?>"
       href="<?= ROOT ?>/admin/dishes">
        <i class="fa-solid fa-bowl-rice d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;Dishes</span>
    </a>
    <?php endif; ?>
    <?php if (utils\RouteAuth::icon_visible('promotions')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "promotions") echo " active" ?>"
       href="<?= ROOT ?>/admin/promotions">
        <i class="fa-solid fa-percent d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;Promotions</span>
    </a>
    <?php endif; ?>
    <?php if (utils\RouteAuth::icon_visible('vendors')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "vendors") echo " active" ?>"
       href="<?= ROOT ?>/admin/vendors">
        <i class="fa-solid fa-store d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;Vendors</span>
    </a>
    <?php endif; ?>
    <?php if (utils\RouteAuth::icon_visible('feedback')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "feedback") echo " active" ?>"
       href="<?= ROOT ?>/admin/feedback">
        <i class="fa-solid fa-comment-dots d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;Feedback</span>
    </a>
    <?php endif; ?>
    <?php if (utils\RouteAuth::icon_visible('orders')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "orders") echo " active" ?>"
       href="<?= ROOT ?>/admin/orders">
        <i class="fa-solid fa-shopping-bag d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;Orders</span>
    </a>
    <?php endif; ?>
    <?php if (utils\RouteAuth::icon_visible('users')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "users") echo " active" ?>"
       href="<?= ROOT ?>/admin/users">
        <i class="fa-solid fa-users d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;Users</span>
    </a>
    <?php endif; ?>
    <?php if (utils\RouteAuth::icon_visible('employees')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "employees") echo " active" ?>"
       href="<?= ROOT ?>/admin/employees">
        <i class="fas fa-users-cog d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;Employees</span>
    </a>
    <?php endif; ?>
    <?php if (utils\RouteAuth::icon_visible('payments')): ?>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "payments") echo " active" ?>"
       href="<?= ROOT ?>/admin/payments">
        <i class="fa-solid fa-credit-card d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;Payments</span>
    </a>
    <?php endif; ?>


</div>