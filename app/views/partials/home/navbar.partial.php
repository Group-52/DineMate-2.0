<?php

use models\Cart;

?>
<nav class="nav nav-home px-3 position-sticky top-0 left-0">
    <div class="d-flex flex-wrap justify-content-space-between w-100">
        <div class="nav-brand">
            <div class="nav-items">
                <div class="nav-item">
                    <a href="<?= ROOT ?>/home"><img src="<?= ROOT ?>/assets/images/logos/logo_Full Logo.svg" alt="Logo"></a>
                </div>
            </div>
        </div>
        <div class="nav-items w-50">
            <div class="form-search">
                <input type="text" class="form-control" name="query" placeholder="Search items"
                       value="<?= $query ?? "" ?>">
                <button class="form-search-icon" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>
        <div class="nav-items">
            <?php if (isset($_SESSION['user'])): ?>
                <div class="nav-item">
                    <div class="nav-shopping-cart">
                        <a href="<?= ROOT ?>/cart">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="badge"
                                  id="cart-count"><?php echo (new Cart)->getNoOfItems($_SESSION['user']->user_id) ?? 0 ?></span>
                        </a>
                    </div>
                </div>
                <div class="nav-item">
                    <i class="fa-solid fa-bars" id="sidebar-open"></i>
                </div>
            <?php else: ?>
                <div class="nav-item">
                    <a class="link text-uppercase fw-bold" href="<?= ROOT ?>/auth/login">Login</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div id="sidebar" class="sidebar p-5 pt-1 shadow">
        <i class="fa-solid fa-x" id="sidebar-close"></i>
        <div class="sidebar-items mt-3">
            <div class="sidebar-user">
                <div class="display-4">
                    <?= (isset($user)) ? $user->first_name . " " . $user->last_name : "" ?>
                </div>
                <div class="secondary">
                    View Profile
                </div>
            </div>
            <div class="sidebar-item">
                <i class="fa-solid fa-burger"></i>
                <span class="sidebar-text">My Orders</span>
            </div>
            <div class="sidebar-item">
                <i class="fa-solid fa-tag"></i>
                <span class="sidebar-text">My Promotions</span>
            </div>
            <a class="sidebar-item">
                <a href="auth/logout">
                    <span class="secondary text-uppercase">Sign Out</span>
                </a>
        </div>
    </div>
    </div>
</nav>