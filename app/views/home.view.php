<!DOCTYPE html>
<html lang="en">

<head>
    <?php use components\Menu;

    include VIEWS . "/partials/home/head.partial.php" ?>
</head>
<body class="body-min-vh-100">
<div class="wrapper">
    <?php include VIEWS . "/partials/home/navbar.partial.php"; ?>

    <?php if (isset($item)) $item->render() ?>
    <div class="banner mb-3">
        <img class="banner-bg-img" src="<?= ASSETS ?>/images/home/banner.jpg" alt="banner">
        <img class="banner-bg-img banner-hidden" id="bg-change" src="" alt="banner">
        <div class="banner-bg-gradient"></div>
        <h1 class="banner-text">Good
            <?php
            $hour = date('G');
            if ($hour >= 5 && $hour < 12) {
                echo "Morning";
            } elseif ($hour >= 12 && $hour < 17) {
                echo "Afternoon";
            } else {
                echo "Evening";
            }
            ?>, <?= $user->first_name ?? "User" ?></h1>
    </div>
    <div class="container py-5" style="margin-top: -90px">
        <div class='menu mb-4'>
            <div class='grid-lg-4 grid-md-2 grid-1 grid-gap-2'>
                <?php if (isset($promotion_items)) {
                    foreach ($promotion_items as $promotion_item) {
                        $promotion_item->render();
                    }
                }
                ?>
            </div>
            <div class='text-center my-4'><a href='promotion' class='btn btn-primary text-uppercase'>View More Promotions</a></div>
        </div>
        <?php
        /** @var $menus Menu[] */
        if (isset($menus)) foreach ($menus as $menu) if ($menu->count() > 0) $menu->render(); ?>
    </div>
</div>
<?php include VIEWS . "/partials/home/footer.partial.php"; ?>
<script src="<?php echo ASSETS . "/js/promotion.js" ?>"></script>
</body>
</html>