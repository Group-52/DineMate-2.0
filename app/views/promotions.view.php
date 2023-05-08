<!DOCTYPE html>
<html lang="en">
<head>
    <?php use components\MenuCard;

    include VIEWS . "/partials/home/head.partial.php" ?>
</head>
<body class="body-min-vh-100">
<div class="wrapper">
    <?php include VIEWS . "/partials/home/navbar.partial.php" ?>
    <div class="banner mb-3">
        <img class="banner-bg-img" src="<?= ASSETS ?>/images/home/banner.jpg" alt="banner">
        <div class="banner-bg-gradient"></div>
        <div class="banner-text">
            <h1>Promotions</h1>
            <p class="lead">Get the best deals on your favorite food and drinks!</p>
        </div>
    </div>
    <div class="container py-5" style="margin-top: -90px">
        <div class='grid-lg-4 grid-md-2 grid-1 grid-gap-2'>
            <?php /**  @var $promotion_items MenuCard[] */
            if (isset($promotion_items) && sizeof($promotion_items) > 0) {
                foreach ($promotion_items as $promotion_item) {
                    $promotion_item->render();
                }
            }?>
        </div>

    </div>
</div>
<?php include VIEWS . "/partials/home/footer.partial.php"; ?>
</body>
</html>
