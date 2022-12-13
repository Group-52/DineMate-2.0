<?php include "partials/head.partial.php" ?>

<body style="background: #FF4546">
<div class="container vh-100 position-relative">
    <div class="row h-100 p-5">
        <div class="col-6 p-5 h-100 d-flex align-items-center">
            <form class="col-offset-xl-2 col-xl-8 col-12" action="" method="POST">
                <a href="<?= ROOT ?>/home">
                    <img class="img-logo" src="<?= ROOT ?>/assets/images/logos/logo_Logo Red.svg" alt="DineMate Logo">
                </a>
                <h1 class="display-3 mb-3">Login with DineMate</h1>
                <div class="form-group">
                    <label class="label text-uppercase fw-bold" for="username">Username</label>
                    <input class="form-control" type="text" name="username" id="username">
                </div>
                <div class="form-group">
                    <label class="label text-uppercase fw-bold" for="password">Password</label>
                    <input class="form-control" type="password" name="password" id="password">
                </div>
                <div class="fw-bold text-right">
                    Forgot <a class="link" href="#">Password</a>?
                </div>
                <button class="btn btn-primary btn-lg text-uppercase w-100 my-4" type="submit">Login as Inventory
                    Manager
                </button>
                <div class="fw-bold text-right">
                    Don't have an account? Sign up <a class="link" href="<?= ROOT ?>/admin/auth/register">here</a>
                </div>
            </form>
        </div>
        <div class="col-6 p-5 h-100">
            <img src="<?= ROOT ?>/assets/images/login/cover.jpg" alt="Login Cover" class="img-cover">
        </div>
    </div>

    <div class="login-bg"></div>
</div>
</body>