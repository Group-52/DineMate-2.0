<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">
    <script src="https://kit.fontawesome.com/3cb91da810.js" crossorigin="anonymous"></script>

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

        .add-to-cart-btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }
    </style>
</head>

<body>
<?php include "partials/navbar.home.partial.php"; ?>

<?php
// check if user is logged in
if (isset($_SESSION['user'])) {
    echo '<a href="' . ROOT . '/carts/viewcart/">View Cart</a>';
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
        <h2>Admin</h2>
        <a class="link d-block" href="<?= ROOT ?>/admin/auth/login">Login</a>
        <a class="link d-block" href="<?= ROOT ?>/admin/items">View items</a>
        <a class="link d-block" href="<?= ROOT ?>/vendors">View Vendors</a>
        <a class="link d-block" href="<?= ROOT ?>/orders">View Orders</a>
        <a class="link d-block" href="<?= ROOT ?>/admin/inventory">View Inventory</a>
        <a class="link d-block" href="<?= ROOT ?>/admin/ingredients">View Ingredients</a>
        <a class="link d-block" href="<?= ROOT ?>/admin/purchases">View Purchases</a>
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
                    <h5 class="card-title"><?= $dish->dish_name ?></h5>
                    <p class="card-text"><?= $dish->description ?></p>
                    <a href="<?=ROOT?>/carts/addtocart/<?=$_SESSION['user']->user_id?>/<?= $dish->dish_id ?>" id=<?= $dish->dish_id ?> class="add-to-cart-btn">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to Cart
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


<!-- Generate all dishes for each menu -->
<?php
if (isset($menudishes) && isset($menus)) {
    foreach ($menudishes as $menu => $dishes) {
        echo '<div class="menurow">';
        echo '<h3>' . $menus[$menu]->menu_name . '</h3>';
        foreach ($dishes as $d) {
            echo '<div class="card" style="width: 18rem;">
            <img src="' . ASSETS . '/images/dishes/' . $d->image_url . '" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title
                ">' . $d->dish_name . '</h5> 
                <p class="card-text">' . $d->description . '</p>
            </div>
        </div>';
        }
        echo '</div>';
    }
}
?>


</body>
</html>