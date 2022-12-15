<nav class="nav px-3 position-sticky">
    <div class="nav-brand">
        <div class="nav-items">
            <div class="nav-item">
                <img src="<?= ROOT ?>/assets/images/logos/logo_Full Logo.svg" alt="Logo">
            </div>
        </div>
    </div>
    <div class="nav-items justify-content-end">
        <div class="nav-item">
            <?= (isset($user)) ? $user->first_name : "" ?>
        </div>
        <div class="nav-item">
            <?php if (isset($user)): ?>
                <a class="link text-uppercase fw-bold" href="<?= ROOT ?>/auth/logout">Logout</a>
            <?php else: ?>
            <a class="link text-uppercase fw-bold" href="<?= ROOT ?>/auth/login">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>