<nav class="nav px-3 position-sticky justify-content-space-between top-0">
    <div class="nav-brand">
        <div class="nav-items">
            <div class="nav-item">
                <i class="fa-solid fa-bars" id="sidebar-toggle"></i>
            </div>
            <div class="nav-item">
                <img src="<?= ROOT ?>/assets/images/logos/logo_Full Logo.svg" alt="Logo">
            </div>
        </div>
    </div>
    <div class="nav-items">
        <div class="nav-item">
            <?= $_SESSION["user"]->first_name ?>
        </div>
        <div class="nav-item">
            <a class="link text-uppercase fw-bold" href="<?= ROOT ?>/admin/auth/logout">Logout</a>
        </div>
    </div>
</nav>