<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/ingredients.css">
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<!-- Show all the dishes in a list -->
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-3">Ingredients</h1>
        </div>
        <div class="mb-3">
            <div class="form-group" style="width: 300px">
                <label for="dish-select">Dish</label>
                <select id="dish-select" class="form-control">
                    <option value="" disabled selected>Select a dish</option>
                    <?php if (isset($dishes)): ?>
                        <?php foreach ($dishes as $dish) : ?>
                            <option value="<?= $dish->dish_id ?>" data-id="<?= $dish->dish_id ?>"
                                    data-imgurl="<?= $dish->image_url ?>">
                                <?= $dish->dish_name ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <h3 class="heading-3 mb-3">Dish details</h3>
                <div class="text-center">
                    <img id="dish-image" class="img-contain w-100" src="<?= ASSETS ?>/images/dishes/normaldish.jpg"
                         style="height: 300px">
                </div>
                <div class="dish-info">
                    <p class="dish-description"></p>
                </div>
                <!-- create a table for ingredients of dish -->
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col" class="edit-icons"></th>
                        <th scope="col">Ingredient</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Unit</th>
                        <th scope="col" class="trash-icons"></th>
                    </tr>
                    </thead>
                    <tbody id="ingredients-list" class="text-center">
                    </tbody>
                </table>

                <div class="text-center mt-3">
                    <button class="btn btn-primary" id="edit-button">Edit Ingredients</button>
                    <button class="btn btn-primary" id="finish-button" style="display: none">Finish Editing</button>
                </div>
            </div>


            <div class="col-md-4" id="ing-form">
                <h3 class="heading-3 mb-3">Add ingredient</h3>
                <form class="ingredient-form">
                    <div class="form-group">
                        <label for="ingredient">Ingredient</label>
                        <select id="ingredient" class="form-control" required>
                            <option value="" disabled selected>Select an ingredient</option>
                            <?php if (isset($ingredients)) : ?>
                                <?php foreach ($ingredients as $ingredient) : ?>
                                    <option value="<?= $ingredient->item_id ?>">
                                        <?= $ingredient->item_name ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" min="0.001" step=0.001 id="quantity" class="form-control" required oninput="validity.valid||(value='');">
                    </div>
                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <select id="unit" class="form-control" required>
                            <option value="" disabled selected>Select a unit</option>
                            <?php if (isset($units)) : ?>
                                <?php foreach ($units as $unit) : ?>
                                    <option value="<?= $unit->unit_id ?>">
                                        <?= $unit->unit_name ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary" id="add-button">Add ingredient</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= ASSETS ?>/js/admin/ingredients.js"></script>
</body>
</html>