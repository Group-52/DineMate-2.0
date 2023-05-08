<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Dishes
    </title>

    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/common.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/dishes.css">
    <script src="<?= ROOT ?>/assets/js/admin/dishes.js"></script>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-5 mb-2">Dishes</h1>
            <div id="search" class="form-search order-md-0 order-1 w-50">
                <input type="text" class="form-control" placeholder="Search dishes" id="search-field">
                <button class="form-search-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
            <div class="dashboard-buttons">
                <a class="btn btn-primary text-uppercase fw-bold" id="add-dish-button"
                   href="<?php echo ROOT ?>/admin/dishes/addDish">+ Add Dish</a>
            </div>
        </div>

        <div class="card-deck grid-xl-5 grid-lg-3 grid-md-2 grid-1 grid-gap-2">
            <?php if (isset($dish_list) && count($dish_list) > 0) : ?>
                <?php foreach ($dish_list as $d) : ?>
                    <div class="card p-2" data-dish-id="<?= $d->dish_id ?>" data-name="<?= $d->dish_name ?>" data-description="<?= $d->description ?>" data-prep-time="<?= $d->prep_time ?>" data-net-price="<?= $d->net_price ?>" data-selling-price="<?= $d->selling_price ?>" data-image-url="<?= $d->image_url ?>" data-veg="<?=$d->veg?>">
                        <div class="card-header p-1 mb-2">
                            <?= $d->dish_name ?> &nbsp; <?php if ($d->veg==1): ?><i style="color: green;" class="fa-solid fa-leaf"></i> <?php endif; ?>
                        </div>
                        <div class="card-image pb-2">
                            <img src="<?= ASSETS ?>/images/dishes/<?= $d->image_url ?>" alt="dish image">
                        </div>
                        <div class="card-text pt-1 pl-2">
                            <div class="grid-2">
                                <div class="dish-details">Prep Time:</div><div class="text-right"><?= $d->prep_time ?> minutes</div>
                                <div class="dish-details">Net Price:</div><div class="text-right"><?= $d->net_price ?> LKR</div>
                                <div class="dish-details">Selling Price:</div><div class="text-right"><?= $d->selling_price ?> LKR</div>
                            </div>
                            <div class="dish-details">Description:</div><div><?=$d->description?></div>
                        </div>
                        <span class="d-flex justify-content-space-between pt-2">
                            <span class="p-1 mr-2">
                            <a href="<?=ROOT?>/admin/ingredients/?d=<?=$d->dish_id?>"><i class="fa-solid fa-plus primary"></i></a>
                            </span>
                            <span class="d-flex justify-content-end">
                            <i class="fa fa-pencil-square-o px-1 pt-2"></i>
                            <i class="fa fa-trash d-inline px-1 pt-2"></i>
                            </span>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
        <div id="dish-add-formdiv" class="overlay">
            <h1 class="display-6 mb-2">Edit Dish</h1>
            <form method="post" enctype="multipart/form-data" action="<?= ROOT ?>/admin/dishes/addDish">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="preptime">Preparation Time</label>
                    <span class="d-block">
                    <input type="number" name="preptime" class="form-control w-75 mr-2 d-inline" required min="0">
                        Minutes
                    </span>
                </div>
                <div class="form-group">
                    <label for="netprice">Net Price</label>
                    <span class="d-block"><input type="number" name="netprice" class="form-control d-inline w-75 mr-2"
                                                 required min="0"> LKR
                        </span>
                </div>
                <div class="form-group">
                    <label for="sellprice">Selling Price</label>
                    <span class="d-block"><input type="number" name="sellprice" class="form-control d-inline w-75 mr-2"
                                                 required min="0"> LKR
                        </span>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" class="form-control">
                </div>
                <div class="form-group">
                    <label for="veg">Vegetarian</label>
                    <input type="checkbox" name="veg" class="form-control d-inline w-75 mr-2">
                </div>
                <div class="form-group">
                    <label for="fileToUpload">Upload Image</label>
                    <input type="file" name="fileToUpload" id="fileToUpload" class='form-control' required>
                </div>
                <div class="d-flex justify-content-space-between w-100">
                    <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary" id="submit-button">Save</button>
                </div>
            </form>
        </div>
        <div class="popup" id="delete-popup">
            <p>
                Are you sure you want to delete <span></span>? This would remove the dish from all menus, promotions, and recipes
            </p>
            <div class="popup-button-div d-flex justify-content-space-between w-100">
                <button class="btn btn-primary btn-secondary" id="cancel">No</button>
                <button class="btn btn-primary btn-success" id="confirm">Yes</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>