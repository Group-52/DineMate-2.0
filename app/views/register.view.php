<!DOCTYPE html>
<html lang="en">
<head>
    <?php use components\Form;

    include VIEWS . "/partials/home/head.partial.php" ?>
</head>

<body style="background: #FF4546">
<div class="vh-100 position-relative">
    <div class="row h-100 p-5">
        <div class="col-6 p-5 h-100 d-flex align-items-center">
            <div class="col-offset-xl-2 col-xl-8 col-12">
                <a href="<?= ROOT ?>/home">
                    <img class="img-logo" src="<?= ROOT ?>/assets/images/logos/logo_Logo Red.svg" alt="DineMate Logo">
                </a>
                <h1 class="display-3 mb-3">Register with DineMate</h1>

                <?php
                /** @var $form Form */
                if (isset($form)) $form->render(); ?>

                <div class="fw-bold text-right mt-3">
                    Have an account? Login <a class="link" href="<?= ROOT ?>/auth/login">here</a>
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