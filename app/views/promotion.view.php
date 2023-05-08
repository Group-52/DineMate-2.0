<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
</head>
<body class="body-min-vh-100">
<div class="wrapper">
    <?php include VIEWS . "/partials/home/navbar.partial.php" ?>
    <?php if (isset($promotion)) : ?>
        <div class="banner mb-3">
            <img class="banner-bg-img"
                 src="<?php echo ASSETS . "/images/promotions/" . $promotion->image_url ?? ASSETS . '/images/home/banner.jpg' ?>"
                 alt="banner">
            <div class="banner-bg-gradient"></div>
            <h1 class="banner-text">Promotions</h1>
        </div>
        <div class="container py-5">
            <div class="row">
                <div class="col-offset-lg-1"></div>
                <div class="col-lg-4 col-md-5 col-12 text-center">
                    <img src="<?php echo ASSETS . "/images/promotions/" . $promotion->image_url ?>" alt="<?= $promotion->title ?>"
                         class="img-fluid rounded-sm shadow" style="max-height: 50vh; ">
                </div>
                <div class="col-offset-lg-1"></div>
                <div class="col-lg-5 col-md-7 col-12 d-flex flex-column justify-content-center p-3">
                    <h1 class="secondary text-uppercase"><?= $promotion->promo_type ?></h1>
                    <h2><?= $promotion->title ?></h2>
                    <p class="lead"><?= $promotion->description ?></p>
                    <div class="display-6 my-3">
                    <?php if (isset($dish)) : ?>
                        <div><a class="link" href="<?= ROOT ?>/dish/id/<?= $dish->dish_id?>"><?= $dish->dish_name ?></a></div>
                    <?php endif ?>
                    <?php if (isset($dish1)) : ?>
                        <?php if (isset($dish2)) : ?>
                            <?php if ($dish1->dish_id == $dish2->dish_id) : ?>
                                <div><a class="link" href="<?= ROOT ?>/dish/id/<?= $dish1->dish_id?>">2 &times; <?= $dish1->dish_name ?></a></div>
                            <?php else : ?>
                                <div><a class="link" href="<?= ROOT ?>/dish/id/<?= $dish1->dish_id?>"><?= $dish1->dish_name ?></a></div>
                                <div><a class="link" href="<?= ROOT ?>/dish/id/<?= $dish2->dish_id?>"><?= $dish2->dish_name ?></a></div>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endif ?>
                    </div>
                    <div class="secondary display-5 fw-bold mb-2">LKR <?= $promotion->price ?></div>
                    <form action="" method="post">
                        <input type="hidden" name="promo_id" value="<?= $promotion->promo_id ?>">
                        <?php if (isset($is_promo)) : ?>
                            <input type="hidden" name="action" value="<?= ($is_promo) ? "remove" : "apply" ?>">
                            <button class="btn <?= (!$is_promo) ? "btn-primary" : "btn-secondary" ?> text-uppercase fw-bold"><?= ($is_promo) ? "Remove" : "Apply" ?></button>
                        <?php endif ?>
                    </form>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>
<?php include VIEWS . "/partials/home/footer.partial.php"; ?>
<script src="<?php echo ASSETS . "/js/promotion.js" ?>"></script>
</body>
</html>
