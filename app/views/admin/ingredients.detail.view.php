<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/ingredients.detail.css">
    <script src="<?= ASSETS ?>/js/admin/ingredients.detail.js"></script>
    <script src="<?= ASSETS ?>/js/admin/common.js"></script>
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<!-- Show all the dishes in a list -->
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-5 active">Ingredients</h1>
            <div class="dashboard-buttons">
                <div class="form-group d-inline-block pr-3" style="width:200px">
                    <select id="dish-select" class="form-control">
                        <option value="" disabled selected>Select a dish</option>
                        <?php if (isset($dishes)): ?>
                            <?php foreach ($dishes as $d) : ?>
                                <option value="<?= $d->dish_id ?>" data-id="<?= $d->dish_id ?>"
                                        data-imgurl="<?= $d->image_url ?>">
                                    <?= $d->dish_name ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <a class="btn btn-primary text-uppercase fw-bold" id="add-button">Add Ingredient</a>
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="edit-button">Edit</a>
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="finish-button">Finish Editing</a>
            </div>
        </div>
        <!--        div with two columns-->

        <div class="row">
            <div class="col-offset-lg-1"></div>
            <div class="col-lg-4 col-md-5 col-12 text-center">
                <img src="<?php echo ASSETS . "/images/dishes/" . $dish->image_url ?>" alt="<?= $dish->dish_name ?>"
                     class="img-fluid rounded-sm shadow" style="max-height: 50vh; ">
            </div>
            <div class="col-offset-lg-1"></div>
            <div class="col-lg-5 col-md-7 col-12 d-flex flex-column justify-content-center p-3">
                <h1><?= $dish->dish_name ?></h1>
                <p class="lead"><?= $dish->description ?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-offset-2"></div>
            <div class="col-8">
                <!-- create a table for ingredients of dish -->
                <table class="table table-striped" data-dish="<?= $dish->dish_id ?>">
                    <thead>
                    <tr>
                        <th>Ingredient</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    <?php if (isset($dishIngredients) && count($dishIngredients) > 0) : ?>
                    <?php foreach ($dishIngredients as $ingredient) : ?>
                        <tr data-ingredient="<?= $ingredient->item_id ?>" data-unit="<?= $ingredient->unit_id ?>"
                            data-quantity="<?= $ingredient->quantity ?>">
                            <td><?= $ingredient->item_name ?></td>
                            <td><?= $ingredient->quantity ?></td>
                            <td><?= $ingredient->unit_name ?></td>
                            <td><i class="fa fa-pencil-square-o edit-icon"></i></td>
                            <td><i class="fa fa-trash trash-icon edit-icon"></i></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No ingredients found</td>
                        </tr>
                    <?php endif; ?>

                    <tr class="input-row">
                        <td>
                            <select name="ingredient" class="form-control m-2 w-75">
                                <option value="" disabled selected>Ingredient</option>
                                <?php if (isset($ingredients)) : ?>
                                    <?php foreach ($ingredients as $ingredient) : ?>
                                        <option value="<?= $ingredient->item_id ?>">
                                            <?= $ingredient->item_name ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </td>
                        <td>
                            <input class="form-control m-2 w-75" type="number" placeholder="Quantity" name="quantity" min="0.001" step="0.001"
                                   oninput="validity.valid||(value='');" required>
                        </td>
                        <td>
                            <select name="unit" class="form-control m-2 w-75">
                                <option value="" disabled selected>Unit</option>
                                <?php if (isset($units)) : ?>
                                    <?php foreach ($units as $unit) : ?>
                                        <option value="<?= $unit->unit_id ?>">
                                            <?= $unit->unit_name ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </td>
                        <td><i class="fa fa-check-circle tick-icon edit-options"></i></td>
                        <td><i class="fa fa-times-circle cross-icon edit-options"></i></td>
                        <td>
                            <button class="add-new-row btn btn-primary m-2">Add</button>
                        </td>
                        <td><i class="fa-solid fa-circle-xmark m-3"></i></td>

                    </tr>
                    <tr class="dummy-row" data-ingredient="0" data-unit="0" data-quantity="0">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><i class="fa fa-pencil-square-o edit-icon"></i></td>
                        <td><i class="fa fa-trash trash-icon edit-icon"></i></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-offset-2"></div>
        </div>
    </div>

</div>
</body>
</html>