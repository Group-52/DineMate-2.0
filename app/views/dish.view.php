<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
</head>
<body class="body-min-vh-100">
<div class="wrapper">
    <?php include VIEWS . "/partials/home/navbar.partial.php" ?>
    <div class="container my-5">
        <?php if (isset($dish)) : ?>
            <h1 class="display-4 mb-3">Dish Details</h1>
            <div class="row">
                <div class="col-lg-5 col-12">
                    <img src="<?php echo ASSETS . "/images/dishes/" . $dish->image_url ?>" alt="<?= $dish->dish_name ?>"
                         class="img-fluid">
                </div>
                <div class="col-lg-7 col-12 d-flex flex-column justify-content-center">
                    <h1><?= $dish->dish_name ?></h1>
                    <p class="lead"><?= $dish->description ?></p>
                    <div class="secondary display-5 fw-bold">LKR <?= $dish->selling_price ?></div>
                    <form action="<?= ROOT ?>/cart/add" method="post">
                        <input type="hidden" name="dish_id" value="<?= $dish->dish_id ?>">
                        <input type="number" step="1" min="1" max="10" class="form-control text-center my-3"
                               placeholder="Qty" name="quantity"
                               value="1" style="width: auto">
                        <button type="submit" class="btn btn-primary text-uppercase">Add to Cart</button>
                </div>
            </div>
        <?php endif ?>
    </div>
</div>

<?php include VIEWS . "/partials/home/footer.partial.php"; ?>
</body>
</html>
