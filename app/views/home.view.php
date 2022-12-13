<?php include "partials/head.partial.php" ?>

<body>

<div class="container">
    <h1 class="display-2">DineMate</h1>
    <h2 class="display-4">Home Page</h2>
    <?php if (isset($_SESSION['user'])): ?>
        <h3 class="display-5 mt-5">Welcome, <b><?= $_SESSION['user']->first_name ?></b></h3>
        <a class="link" href="<?= ROOT ?>/admin">Admin</a> <br>
        <a class="link" href="<?= ROOT ?>/auth/logout">Logout</a>
    <?php else: ?>
        Have an account?
        <br> Customer login <a class="link" href="<?= ROOT ?>/auth/login">here</a>
        <br> Employee login <a class="link" href="<?= ROOT ?>/admin/auth/login">here</a>
    <?php endif ?>
    <h2><a class="link" href="<?= ROOT ?>/dishes">View Dishes</a></h2>
</div>

</body>
