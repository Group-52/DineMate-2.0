<?php

use models\Cart;

?>
<nav class="nav nav-home px-3 left-0">
    <div class="d-flex justify-content-space-between w-100">
        <div class="nav-brand">
            <div class="nav-items">
                <div class="nav-item not-mobile">
                    <a href="<?= ROOT ?>/home"><img src="<?= ROOT ?>/assets/images/logos/logo_Full Logo.svg" alt="Logo"></a>
                </div>
                <div class="nav-item only-mobile">
                    <a href="<?= ROOT ?>/home"><img src="<?= ROOT ?>/assets/images/logos/logo_Logo Red.svg" alt="Logo"></a>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column nav-items w-100">
            <div id="home-search" class="form-search order-md-0 order-1">
                <input type="text" class="form-control" name="query"
                       placeholder="Search" id="home-search-field">
                <button class="form-search-icon" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
            <div id="home-search-modal" class="search-modal order-md-1 order-0">
                <i class="fa-solid fa-x modal-close" id="home-modal-close"></i>
                <div class="search-modal-container container">
                    <div class="search-modal-filter d-flex" id="search-modal-filter">
                        <div class="form-group">
                            <label for="price-range" class="label text-uppercase fw-bold">Max Price</label>
                            <input type="range" class="form-control" min="1" max="1000" id="price-range">
                            <span class="range-min"></span>
                            <span class="range-max"></span>
                        </div>
                        <div class="form-group ml-5">
                            <label for="preference" class="label text-uppercase fw-bold">Preference</label>
                            <select id="preference" class="form-control">
                                <option value="2">All</option>
                                <option value="1">Veg</option>
                                <option value="0">Non-Veg</option>
                            </select>
                        </div>
                    </div>
                    <div id="home-search-results" class="grid-lg-4 grid-md-2 grid-1 grid-gap-2"></div>
                </div>
            </div>
        </div>
        <div class="nav-items">
            <?php if (isLoggedIn()) : ?>
                <div class="nav-item">
                    <div class="nav-shopping-cart">
                        <a href="<?= ROOT ?>/cart">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="badge"
                                  id="cart-count"><?php echo (new Cart)->getNoOfItems(userId(), isGuest()) ?? 0 ?></span>
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
    <div id="sidebar" class="sidebar">
        <div class="sidebar-items px-5 pt-5 pb-3 bg-grey">
            <div class="sidebar-user">
                <div class="display-4">
                    <?= (isRegistered()) ? $_SESSION["user"]->first_name . " " . $_SESSION["user"]->last_name : "Guest" ?>
                </div>
                <?php if (isRegistered()) : ?>
                    <div class="secondary">
                        <a class="link" href="<?= ROOT ?>/profile">View Profile</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="sidebar-items px-5">
            <div class="sidebar-item">
                <i class="fa-solid fa-burger"></i>
                <span class="sidebar-text"><a class="link" href="<?= ROOT ?>/orders">My Orders</a></span>
            </div>
            <div class="sidebar-item">
                <i class="fa-solid fa-tag"></i>
                    <span class="sidebar-text"><a class="link" href="<?= ROOT ?>/promotion">My Promotions</a></span>
            </div>
            <a class="sidebar-item">
                <?php if (isRegistered()):  ?>
                <a href="<?= ROOT ?>/auth/logout">
                    <span class="secondary text-uppercase">Sign Out</span>
                </a>
                <?php else: ?>
                <a href="<?= ROOT ?>/auth/login">
                    <span class="secondary text-uppercase">Sign In</span>
                </a>
                <?php endif ?>
        </div>
    </div>
</nav>