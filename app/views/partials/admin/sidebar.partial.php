<?php
    const sidebarList = [
        [
            "controller" => "home",
            "link" => "/home",
            "solid-icon" => "house",
            "text" => "Dashboard"
        ],
        [
            "controller" => "items",
            "link" => "/items",
            "solid-icon" => "sitemap",
            "text" => "Items"
        ],
        [
            "controller" => "inventory",
            "link" => "/inventory/dashboard",
            "solid-icon" => "box",
            "text" => "Inventory"
        ],
        [
            "controller" => "ingredients",
            "link" => "/ingredients",
            "solid-icon" => "carrot",
            "text" => "Ingredients"
        ],
        [
            "controller" => "menus",
            "link" => "/menus",
            "solid-icon" => "newspaper",
            "text" => "Menus"
        ],
        [
            "controller" => "purchases",
            "link" => "/purchases",
            "solid-icon" => "shopping-cart",
            "text" => "Purchases"
        ],
        [
            "controller" => "dishes",
            "link" => "/dishes",
            "solid-icon" => "bowl-rice",
            "text" => "Dishes"
        ],
        [
            "controller" => "promotions",
            "link" => "/promotions",
            "solid-icon" => "gift",
            "text" => "Promotion"
        ],
        [
            "controller" => "vendors",
            "link" => "/vendors",
            "solid-icon" => "truck",
            "text" => "Vendors"
        ],
        [
            "controller" => "feedback",
            "link" => "/feedback",
            "solid-icon" => "comment-dots",
            "text" => "Feedback"
        ],
        [
            "controller" => "orders",
            "link" => "/orders",
            "solid-icon" => "shopping-bag",
            "text" => "Orders"
        ],
        [
            "controller" => "users",
            "link" => "/users",
            "solid-icon" => "user",
            "text" => "Users"
        ],
        [
            "controller" => "employees",
            "link" => "/employees",
            "solid-icon" => "users-cog",
            "text" => "Employees",
        ],
        [
            "controller" => "payments",
            "link" => "/payments",
            "solid-icon" => "credit-card",
            "text" => "Payments"
        ],
        [
            "controller" => "logout",
            "link" => "/auth/logout",
            "solid-icon" => "sign-out",
            "text" => "Logout"
        ],
    ]
?>

<div id="sidebar" class="sidebar pb-5 pt-4 px-3">
    <?php foreach (sidebarList as $item): ?>
        <?php if (utils\RouteAuth::icon_visible($item["controller"])): ?>
            <a class="fw-bold d-block mb-4 fs-5<?php if (isset($controller) && $controller == $item["controller"]) echo " active" ?>"
               href="<?= ROOT ?>/admin<?= $item["link"] ?>">
                <i class="fa-solid fa-<?= $item["solid-icon"] ?> d-inline"></i><span class="sidebar-text">&nbsp;&nbsp;<?= $item["text"] ?></span>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>