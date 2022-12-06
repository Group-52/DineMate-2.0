<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">

    <title>Home page</title>

    <style>
        input {
            padding: 15px;
            margin: 10px;
        }
    </style>
</head>

<body>

<?php if (isset($username)) : ?>
<h4>Hi, <?= $username ?></h4>
<?php endif ?>
<div>
    <a href="<?= ROOT ?>">Home</a>
    <a href="<?= ROOT ?>/auth/login">Login</a>
    <a href="<?= ROOT ?>/auth/logout">Logout</a>
</div>

<h1>HOME PAGE</h1>
<h2><a href="<?= ROOT ?>/dishes">View Dishes</a></h2>
</body>

</html>