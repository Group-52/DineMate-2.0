<!DOCTYPE html>
<html lang="en">

<?php include VIEWS . "/partials/home/head.partial.php" ?>

<body style="background: #FF4546">
<div class="vh-100 position-relative">
    <div class="row h-100 p-5">
        <div class="col-6 p-5 h-100 d-flex align-items-center">
            <div class="col-offset-xl-2 col-xl-8 col-12">
                <a href="<?= ROOT ?>/home">
                    <img class="img-logo" src="<?= ROOT ?>/assets/images/logos/logo_Logo Red.svg" alt="DineMate Logo">
                </a>
                <h1 class="display-3 mb-1">Login with DineMate</h1>
                <h2 class="mb-3">Admin</h2>
                <?php if (isset($form)) : ?>
                    <?php $form->render(); ?>
                <?php endif; ?>
                <div class="fw-bold text-right">
                    Forgot <a class="link" href="#">Password</a>?
                </div>
            </div>
        </div>
        <div class="col-6 p-5 h-100">
            <img src="<?= ROOT ?>/assets/images/login/cover.jpg" alt="Login Cover" class="img-cover">
        </div>
    </div>

    <div class="login-bg"></div>
</div>
</body>
</html>
