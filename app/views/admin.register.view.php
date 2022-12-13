<?php include "partials/head.partial.php" ?>

<body style="background: #FF4546">
<div class="container vh-100 position-relative">
    <div class="row h-100 p-5">
        <div class="col-6 p-5 h-100 d-flex align-items-center">
            <form class="col-offset-xl-2 col-xl-8 col-12" action="" method="POST">
                <a href="<?= ROOT ?>/home">
                    <img class="img-logo" src="<?= ROOT ?>/assets/images/logos/logo_Logo Red.svg" alt="DineMate Logo">
                </a>
                <h1 class="display-3 mb-3">Register with DineMate</h1>

                <div class="row">
                    <div class="form-group col-6 pr-2">
                        <label class="label text-uppercase fw-bold" for="first_name">First Name</label>
                        <input class="form-control" type="text" name="first_name" id="first_name">
                    </div>
                    <div class="form-group col-6">
                        <label class="label text-uppercase fw-bold" for="last_name">Last Name</label>
                        <input class="form-control" type="text" name="last_name" id="last_name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="label text-uppercase fw-bold" for="username">Username</label>
                    <input class="form-control" type="text" name="username" id="username">
                </div>

                <div class="form-group">
                    <label class="label text-uppercase fw-bold" for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email">
                </div>

                <div class="row">
                    <div class="form-group col-6 pr-2">
                        <label class="label text-uppercase fw-bold" for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password">
                    </div>
                    <div class="form-group col-6">
                        <label class="label text-uppercase fw-bold" for="password_confirm">Confirm Password</label>
                        <input class="form-control" type="password" name="password_confirm" id="password_confirm">
                    </div>
                </div>

                <button class="btn btn-primary btn-lg text-uppercase w-100 my-4" type="submit">Register as Inventory
                    Manager
                </button>
                <div class="fw-bold text-right">
                    Have an account? Login <a class="link" href="<?= ROOT ?>/admin/auth/login">here</a>
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