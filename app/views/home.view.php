<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
    </style>
</head>

<body>

<h4>Hi, <?= $username ?></h4>
<div>


    <a href="<?= ROOT ?>">Home</a>
    <a href="<?= ROOT ?>/auth/login">Login</a>
    <a href="<?= ROOT ?>/auth/logout">Logout</a>

</div>

<h1> HOME PAGE</h1>
<h2>
    <a href="<?= ROOT ?>/dishes">View Dishes</a>
</h2>


<!-- generate all dishes -->

<div class="dishrow">
    <h3>Dishes</h3>
    <?php foreach ($dishes as $dish) : ?>
        <div class="card" style="width: 18rem;">
            <img src="<?= ASSETS ?>/images/dishes/<?= $dish->image_url ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?= $dish->name ?></h5>
                <p class="card-text"><?= $dish->description ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>




<!-- generate all items for each menu -->
<?php
foreach ($menuitems as $key=>$menu) {
    echo '<div class="menurow">';
    echo '<h3>' . $menus[$key]->name. '</h3>';
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

?>

</body>
</html>