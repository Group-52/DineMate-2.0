<div id="sidebar" class="sidebar p-5 pt-1">
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "home") echo " active" ?>"
       href="<?= ROOT ?>/admin">
        <i class="fa-solid fa-house d-inline"></i><span
                class="sidebar-text">&nbsp;&nbsp;Dashboard</span>
    </a>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && $controller == "items") echo " active" ?>"
       href="<?= ROOT ?>/admin/items">
        <i class="fa-solid fa-sitemap d-inline"></i><span
                class="sidebar-text">&nbsp;&nbsp;Items</span>
    </a>
    <a class="fw-bold d-block mb-4 fs-4<?php if (isset($controller) && ($controller == "inventory"||$controller=="inventory2")) echo " active" ?>"
       href="<?= ROOT ?>/admin/inventory">
        <i class="fa-solid fa-box d-inline"></i><span
                class="sidebar-text">&nbsp;&nbsp;Inventory</span>
</div>
