<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Update Menu</title>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <script src="<?=ASSETS?>/js/admin/common.js"></script>
    <style>
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            width: 200px;
            height: 150px;
            margin: 10px;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .container {
            padding: 2px 16px;
        }

        .card img {
            object-fit: cover;
            width: 100%;
            height: 200px;
            border-radius: 10px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: left;
            max-width: 1200px;
        }
    </style>

</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex justify-content-space-between">
            <h1 class="display-5 mb-2"><a class="link" href="<?= ROOT ?>/admin/menus">Menus</a><i class="fa-solid fa-chevron-right mx-2"></i>Update</h1>
        </div>
        <div class="row">
            <div class="col-offset-lg-1"></div>
            <div class="col-lg-4 col-md-5 col-12 text-center">
                <img src="<?php echo ASSETS . "/images/menus/" . $menu->image_url ?>" alt="<?= $menu->menu_name ?>"
                     class="img-fluid rounded-sm shadow" style="max-height: 50vh; ">
            </div>
            <div class="col-offset-lg-1"></div>
            <div class="col-lg-5 col-md-7 col-12 d-flex flex-column justify-content-center p-3">
                <h1><?= $menu->menu_name ?></h1>
                <p class="lead"><?= $menu->description ?></p>
                <?php if ($menu->start_time) : ?>
                    <h3>Start-Time : <?= $menu->start_time ?></h3>
                <?php endif; ?>
                <?php if ($menu->end_time) : ?>
                    <h3>End-Time : <?= $menu->end_time ?></h3>
                <?php endif; ?>
                <h3>All Day: <input type="checkbox" name="all_day" disabled <?php echo ($menu->all_day == 1 ? 'checked' : ''); ?> /></h3>
            </div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Dish</th>
                    <th>Selling Price</th>
                    <th>Prep Time</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($menu_items) && count($menu_items)): ?>
                <?php foreach ($menu_items as $item) : ?>
                    <tr data-dish-id="<?= $item->dish_id ?>">
                        <td><?= $item->dish_id ?></td>
                        <td><?= $item->dish_name ?></td>
                        <td><?= $item->selling_price ?></td>
                        <td><?= $item->prep_time ?></td>
                        <td><a class='cart-trash-icon' href='<?= ROOT ?>/admin/menus/deleteDish/<?=$menu->menu_id.'/'. $item->dish_id ?>'><i class='fa-solid fa-trash cart-delete p-1 pointer'></i></i></a></td>
                    </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No Dishes in this menu</td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
            <form action="<?= ROOT ?>/admin/menus/addDish/<?= $menu->menu_id ?>" method = "POST">
                <div class='form-group pt-3 d-flex'>
                    <select name="selected_dish" class="form-control w-50 m-2">
                        <?php foreach ($dishes as $dish) : ?>
                            <option value="<?= $dish->dish_id ?>"><?= $dish->dish_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" id="add_dish_button" class="btn btn-primary m-2" name="save">Add Dish</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

<script>
    // before submitting the form, check if the dish is already added to the menu
    let addDishButton = document.getElementById('add_dish_button');
    let selectedDish = document.getElementsByName('selected_dish')[0];
    //get all data-dish-id attributes from the table
    let dishIds = document.querySelectorAll('[data-dish-id]');
    let dishIdsArray = [];
    dishIds.forEach(dishId => {
        dishIdsArray.push(dishId.getAttribute('data-dish-id'));
    });
    addDishButton.addEventListener('click', (e) => {
        if (dishIdsArray.includes(selectedDish.value)) {
            e.preventDefault();
            displayError('Dish already added to the menu',addDishButton.getBoundingClientRect().top);
        }
    });
</script>