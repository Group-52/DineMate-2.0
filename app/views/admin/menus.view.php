<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    use components\MenuCard;

    include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/menus.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/tables.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <script src="<?= ROOT ?>/assets/js/admin/menus.js"></script>
</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex justify-content-space-between">
            <h1 class="display-5 mb-2">Menus</h1>
            <a class="btn btn-primary h-50 text-uppercase" id="add-menu-button" href="<?php echo ROOT ?>menus/addMenu">+ Add Menu</a>
        </div>
        <div class="card-container row p-0">

            <?php /**  @var $menu_items MenuCard[] */
            if (isset($menulist) && sizeof($menulist) > 0) : ?>
                <?php foreach ($menulist as $m) : ?>

                    <div class="card" data-menu-id=<?= $m->menu_id ?>>
                        <a href="<?= ROOT ?>/admin/menus/id/<?= $m->menu_id ?>">
                            <img src="<?= ASSETS ?>/images/menus/<?= $m->image_url ?>" alt="<?= $m->menu_name ?>" style="width:100%">
                        </a>
                        <div class="d-flex justify-content-space-between align-items-center">
                            <div class="lead"><?= $m->menu_name ?></div>
                            <div>
                                <a class='edit-icon-link' href='menus/edit/ <?= $m->menu_id ?> '><i class='fa fa-edit edit-icon' aria-hidden='true'></i></a>
                                <a class='cart-trash-icon' href='menus/delete/ <?= $m->menu_id ?> '><i class='fa-solid fa-trash cart-delete p-1 pointer'></i></i></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif ?>
        </div>

        <div id="menu-add-form" class="overlay">
            <form action="<?= ROOT ?>/admin/menus/addMenu" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="menu_name"><b>Name</b></label><br>
                    <input class="form-control" type="text" name="menu_name" placeholder="Name" id="menu_name" required>
                </div>

                <div class="form-group">
                    <label for="description"><b>Description</b></label><br>
                    <input class="form-control" type="text" name="description" placeholder="Description" id="description" required>
                </div>

                <div class="form-group">
                    Select image to upload:
                    <input class="form-control" type="file" name="image_url" id="image_url" required>
                </div>

                <div class="d-flex justify-content-space-between">
                    <button type="button" class="btn btn-secondary text-uppercase fw-bold" id="cancel-button">Cancel</button>
                    <button class="btn btn-primary text-uppercase fw-bold" type="submit" name="save" id="submit-button">Save Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>

</html>