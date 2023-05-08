<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/ingredients.css">
    <script src="<?= ASSETS ?>/js/admin/ingredients.js"></script>
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<!-- Show all the dishes in a list -->
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-5 mb-2">Recipes</h1>
        </div>

        <div class="card-deck">
            <?php if (isset($dishes)) : ?>
                <?php foreach ($dishes as $d) : ?>
            <div class="card" data-dish-id="<?= $d->dish_id ?>">
                <div class="card-header">
                    <?= $d->dish_name ?>
                </div>
                <div class="card-body">
                    <img src="<?= ASSETS ?>/images/dishes/<?= $d->image_url ?>" alt="dish image" class="img-fluid">
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>