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
            <div class="circular">
                <div class="circular-content">
                    <?php if (isset($_SESSION["user"])) : ?>
                        <?= substr($_SESSION["user"]->first_name, 0, 1) . substr($_SESSION["user"]->last_name, 0, 1) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <?php if (isset($_SESSION["user"])) : ?>
                <?= $_SESSION["user"]->first_name . " " . $_SESSION["user"]->last_name ?>
            <?php endif; ?>
        </div>
    </div>
</nav>