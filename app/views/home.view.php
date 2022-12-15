<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">

    <title>Home page</title>

    <style>
        input {
            padding: 15px;
            margin: 10px;
        }

        /* make cards float next to each other */
        .card {
            float: left;
            margin: 10px;
            width: 18rem;
            height: 18rem;
            border: 1px solid grey;
            border-radius: 5px;
            padding: 5px;
        }

        /* make all card images same size */
        .card-img-top {
            width: 100%;
            height: 10rem;
            object-fit: cover;
        }

        .dishrow,
        .menurow {
            display: block;
            clear: both;
        }
    </style>
</head>

<body>
<?php include "partials/navbar.home.partial.php"; ?>

<?php
// check if user is logged in
if (isset($_SESSION['user'])) {
    echo '<a href="' . ROOT . '/carts/viewcart/' . $_SESSION['user']->user_id . '">View Cart</a>';
}
?>

<div class="row py-5 justify-content-space-around">
    <div>
        <h2>Customer</h2>
        <a class="link d-block" href="<?= ROOT ?>/auth/login">Login</a>
        <a class="link d-block" href="<?= ROOT ?>/menus">View Menus</a>
        <a class="link d-block" href="<?= ROOT ?>/dishes">View Dishes</a>
    </div>
    <div>
        <h2>Inventory Manager</h2>
        <a class="link d-block" href="<?= ROOT ?>/admin/auth/login">Login</a>
        <a class="link d-block" href="<?= ROOT ?>/admin/items">View items</a>
    </div>
    <div>
        <h2>General Manager</h2>
        <a class="link d-block" href="<?= ROOT ?>/loginK/login">Login</a>
        <a class="link d-block" href="<?= ROOT ?>/vendors">View Vendors</a>
    </div>
    <div>
        <h2>Chef</h2>
        <a class="link d-block" href="<?= ROOT ?>/loginZ/signup">Login</a>
        <a class="link d-block" href="<?= ROOT ?>/orders">View Orders</a>
    </div>
</div>

<h1> HOME PAGE</h1>

<!-- generate all dishes -->

<div class="dishrow">
    <h3>Dishes</h3>
    <?php if (isset($dishes)) : ?>
        <?php foreach ($dishes as $dish) : ?>
            <div class="card" style="width: 18rem;">
                <img src="<?= ASSETS ?>/images/dishes/<?= $dish->image_url ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $dish->name ?></h5>
                    <p class="card-text"><?= $dish->description ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


<!-- generate all items for each menu -->
<?php
if (isset($menuitems) && isset($menus)) {
    foreach ($menuitems as $key => $menu) {
        echo '<div class="menurow">';
        echo '<h3>' . $menus[$key]->name . '</h3>';
        foreach ($menu as $item) {
            echo '<div class="card" style="width: 18rem;">
            <img src="' . ASSETS . '/images/dishes/' . $item->image_url . '" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title
                ">' . $item->name . '</h5> 
                <p class="card-text">' . $item->description . '</p>
            </div>
        </div>';
        }
        echo '</div>';
    }
}

?>

</body>
</html>