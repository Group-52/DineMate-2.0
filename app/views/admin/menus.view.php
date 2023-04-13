<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include VIEWS . "/partials/home/head.partial.php" ?>
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
            <div class="dashboard-header">

                <h1 class="display-3 active">Menus</h1>
                <a class="btn btn-primary" id="add-menu-button" href="<?php echo ROOT ?>menus/addMenu">Add Menu</a>
            </div>
            <div class="card-container">

                <?php /**  @var $menu_items MenuCard[] */
                if (isset($menulist) && sizeof($menulist) > 0) : ?>
                    <?php foreach ($menulist as $m) : ?>

                        <div class="card" data-menu-id=<?= $m->menu_id ?>>
                            <a href="<?= ROOT ?>/admin/menus/id/<?= $m->menu_id ?>">
                                <img src="<?= ASSETS ?>/images/menus/<?= $m->image_url ?>" alt="<?= $m->menu_name ?>" style="width:100%">
                            </a>
                            <div class="container">
                                <h4><b><?= $m->menu_name ?><a class='cart-trash-icon' href='menus/delete/ <?= $m->menu_id ?> '><i class='fa-solid fa-trash cart-delete p-1 pointer'></i></i></a></b></h4>
                                
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif ?>
            </div>

            
            
            <div id="menu-add-form" class="overlay">
                <form action="<?= ROOT ?>/admin/menus/addMenu" method="post">
                    <div class="form-group">
                        <label for="name"><b>Name</b></label><br>
                        <input class="form-control" type="text" name="menu_name" placeholder="Name" id="menu_name" required>
                    </div>

                    <div class="form-group">
                        <label for="description"><b>Description</b></label><br>
                        <input class="form-control" type="text" name="description" placeholder="Description" id="description" required>
                    </div>

                    <div class="form-group">
                        <label for="start_time"><b>From Time</b></label><br>
                        <input class="form-control" type="time" name="start_time" placeholder="From Time" id="start_time">
                    </div>

                    <div class="form-group">
                        <label for="end_time"><b>To Time</b></label><br>
                        <input class="form-control" type="time" name="end_time" placeholder="To Time" id="end_time">
                    </div>

                    <div class="form-group">
                        Select image to upload:
                        <input class="form-control" type="file" name="image_url" id="fileToUpload" class="form-control">
                    </div>
                    
                    <button class="btn btn-success text-uppercase fw-bold" type="submit" name="save" id="submit-button">Save Menu</button>
                    <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>