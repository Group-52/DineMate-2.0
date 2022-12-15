<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
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
            width: 18rem;
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

    <?php
    // check if user is logged in
    if (isset($_SESSION['user'])) {
        echo '<a href="' . ROOT . '/carts/viewcart/' . $_SESSION['user']->user_id . '">View Cart</a>';
    }
    ?>


    <h4>Hi, <?= $username ?></h4>
    <div>


        <a href="<?= ROOT ?>">Home</a>
        <a href="<?= ROOT ?>/auth/login">Login</a>
        <a href="<?= ROOT ?>/auth/logout">Logout</a>

    </div>

    <h1> HOME PAGE</h1>
    <h2>
        <a href="<?= ROOT ?>/dishes">View Dishes</a>
        <a href="<?= ROOT ?>/menus">View Menus</a>
        <a href="<?= ROOT ?>/admin/auth/login">Login Employee</a>
        <a href="<?= ROOT ?>/loginK/login">Login Keethapriya</a>
        <a href="<?= ROOT ?>/loginZ/signup">Login Zulfa</a>
        <a href="<?= ROOT ?>/admin/items">View items</a>
        <a href="<?= ROOT ?>/vendors">View Vendors</a>
        <a href="<?= ROOT ?>/orders">View Orders</a>
    </h2>


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
                        <a href="#" class="add-to-cart-btn">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to Cart
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>




    <!-- generate all items for each menu -->
    <?php
    if (isset($menuitems)) {
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