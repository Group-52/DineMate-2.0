<!DOCTYPE html>
<html lang="en">
<head>
    <?php use components\MenuCard;

    include VIEWS . "/partials/home/head.partial.php" ?>
</head>
<body class="body-min-vh-100">
<div class="wrapper">
    <?php include VIEWS . "/partials/home/navbar.partial.php" ?>

    <?php if (isset($menu)) : ?>
        <div class="banner mb-3">
            <img class="banner-bg-img"
                 src="<?php echo ASSETS . "/images/menus/" . $menu->image_url ?? ASSETS . '/images/home/banner.jpg' ?>"
                 alt="banner">
            <div class="banner-bg-gradient"></div>
            <div class="banner-text">
                <h1><?= $menu->menu_name ?></h1>
                <p class="lead"><?= $menu->description ?></p>
            </div>
        </div>
    <?php endif ?>
    <div class="container py-5" style="margin-top: -90px">
        <div class='grid-lg-4 grid-md-2 grid-1 grid-gap-2'>
            <?php /**  @var $menu_items MenuCard[] */
            if (isset($menu_items) && sizeof($menu_items) > 0) : ?>
                <?php foreach ($menu_items as $menu_item) : ?>
                    <?php $menu_item->render(); ?>
                <?php endforeach; ?>
            <?php endif ?>
        </div>

    </div>
</div>
<?php include VIEWS . "/partials/home/footer.partial.php"; ?>
</body>
</html>