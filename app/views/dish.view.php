<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
</head>
<body class="body-min-vh-100">
<div class="wrapper">
    <?php include VIEWS . "/partials/home/navbar.partial.php" ?>
    <?php if (isset($dish)) : ?>
        <div class="banner mb-3">
            <img class="banner-bg-img"
                 src="<?php echo ASSETS . "/images/dishes/" . $dish->image_url ?? ASSETS . '/images/home/banner.jpg' ?>"
                 alt="banner">
            <div class="banner-bg-gradient"></div>
            <h1 class="banner-text display-3">Dish Details</h1>
        </div>
        <div class="container my-5">
            <div class="row">
                <div class="col-offset-lg-1"></div>
                <div class="col-lg-4 col-md-5 col-12 text-center">
                    <img src="<?php echo ASSETS . "/images/dishes/" . $dish->image_url ?>" alt="<?= $dish->dish_name ?>"
                         class="img-fluid rounded-sm" style="max-height: 50vh; ">
                </div>
                <div class="col-offset-lg-1"></div>
                <div class="col-lg-5 col-md-7 col-12 d-flex flex-column justify-content-center p-3">
                    <h1><?= $dish->dish_name ?></h1>
                    <p class="lead"><?= $dish->description ?></p>
                    <div class="secondary display-5 fw-bold">LKR <?= $dish->selling_price ?></div>
                    <form action="<?= ROOT ?>/cart/add" method="post">
                        <input type="hidden" name="dish_id" value="<?= $dish->dish_id ?>">
                        <?php if (isset($cartQty)) : ?>
                            <input type="number" step="1" min="1" max="10" class="form-control text-center my-3"
                                   placeholder="Qty" name="quantity"
                                   value="<?php echo ($cartQty == 0) ? 1 : $cartQty ?>"
                                   style="width: auto" required
                                <?php echo ($cartQty == 0) ? "" : "readonly" ?>
                            >
                            <button type="submit"
                                    class="btn btn-primary text-uppercase"<?php echo ($cartQty == 0) ? "" : "disabled" ?>>
                                <?php echo ($cartQty == 0) ? " Add to Cart " : "Added to Cart" ?>
                            </button>
                        <?php endif ?>
                    </form>
                </div>
                <div class="col-offset-lg-1"></div>
            </div>
        </div>
    <?php endif ?>
</div>

<?php include VIEWS . "/partials/home/footer.partial.php"; ?>
</body>
</html>
