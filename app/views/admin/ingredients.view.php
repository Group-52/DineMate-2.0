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
            <h1 class="display-3 active">Ingredients</h1>
        </div>
        <div class="form-group" style="width: 300px">
            <label for="dish-select">Dish</label>
            <select id="dish-select" class="form-control">
                <option value="" disabled selected>Select a dish</option>
                <?php if (isset($dishes)): ?>
                    <?php foreach ($dishes as $dish) : ?>
                        <option value="<?= $dish->dish_id ?>"><?= $dish->dish_name ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
</div>
</body>
</html>