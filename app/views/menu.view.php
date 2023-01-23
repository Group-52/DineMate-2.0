<!DOCTYPE html>
<html lang="en">
<?php use components\MenuItem;

include VIEWS . "/partials/home/head.partial.php" ?>
<body>
<?php include VIEWS . "/partials/home/navbar.partial.php" ?>

<?php if (isset($menu)) : ?>
    <div class="welcome mb-3"
         style="background: linear-gradient(to right, rgba(255, 255, 255, 0.9) 30%, rgba(255, 255, 255, 0) 98.75%),
                 url(<?php echo ASSETS . "/images/menus/" . $menu->image_url ?? '<?= ASSETS ?>/images/home/banner.jpg' ?>) no-repeat center center;
                 background-size: cover;"
    >
        <h1 class="display-4"><?= $menu->menu_name ?></h1>
        <p><?= $menu->description ?></p>
    </div>
<?php endif ?>
<div class="container py-5">
    <div class='row flex-column flex-lg-row'>
        <?php /**  @var $menu_items MenuItem[] */
        if (isset($menu_items) && sizeof($menu_items) > 0) : ?>
            <?php foreach ($menu_items as $menu_item) : ?>
                <div class='col-12 col-lg-4'>
                    <?php $menu_item->render(); ?>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
    </div>

</div>

</body>
</html>