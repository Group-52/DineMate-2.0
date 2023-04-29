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
            <h1 class="display-3 active">Dishes</h1>
            <div class="dashboard-buttons">
                <a class="btn btn-primary text-uppercase fw-bold" id="add-dish-button"
                   href="<?php echo ROOT ?>/admin/dishes/addDish">Add Dish</a>
            </div>

        </div>

        <div class="card-deck d-flex flex-wrap justify-content-start">
            <?php if (isset($dish_list) && count($dish_list) > 0) : ?>
                <?php foreach ($dish_list as $d) : ?>
                    <div class="card p-2" data-dish-id="<?= $d->dish_id ?>" data-name="<?= $d->dish_name ?>" data-description="<?= $d->description ?>" data-prep-time="<?= $d->prep_time ?>" data-net-price="<?= $d->net_price ?>" data-selling-price="<?= $d->selling_price ?>" data-image-url="<?= $d->image_url ?>">
                        <div class="card-header p-1 mb-2">
                            <?= $d->dish_name ?>
                        </div>
                        <div class="card-image pb-2">
                            <img src="<?= ASSETS ?>/images/dishes/<?= $d->image_url ?>" alt="dish image">
                        </div>
                        <div class="card-text pt-1 pl-2">
                            <p><span class="dish-details">Prep Time:</span>&nbsp &nbsp<?= $d->prep_time ?> minutes</p>
                            <p><span class="dish-details">Net Price:</span>&nbsp &nbsp<?= $d->net_price ?> LKR</p>
                            <p><span class="dish-details">Selling Price:</span>&nbsp &nbsp<?= $d->selling_price ?> LKR</p>
                            <p><span class="dish-details">Description:</span>&nbsp &nbsp<?=$d->description?></p>
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
                    <label for="fileToUpload">Select image to upload:</label>
                    <input type="file" name="fileToUpload" id="fileToUpload" class='form-control' required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary" id="submit-button">Save</button>
                <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>
            </form>
        </div>
        <div class="popup" id="delete-popup">
            <p>
                Are you sure you want to delete <span></span>? This would remove the dish from all menus, promotions, and recipes
            </p>
            <div class="popup-button-div">
                <button class="btn btn-primary btn-success" id="confirm">Yes</button>
                <button class="btn btn-primary btn-danger" id="cancel">No</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>