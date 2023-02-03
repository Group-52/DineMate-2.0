<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include VIEWS . "/partials/home/head.partial.php" ?>
    <link rel = "stylesheet" href = "<?= ROOT ?>/assets/css/admin/menus.css">
    <link rel = "stylesheet" href = "<?= ASSETS ?>/css/admin/tables.css">
    <script src="<?= ROOT ?>/assets/js/admin/menus.js"></script>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header">

                <h1 class="display-3 active">Menus</h1>
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
                                <h4><b><?= $m->menu_name ?></b></h4>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif ?>
            </div>

            <a href="" class="btn btn-primary" id="add-menu-button">Add Menu</a>
            <div id="menu-add-form">
            <form action="<?= ROOT ?>/admin/menus/add" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name"><b>Name</b></label><br>
                        <input class="form-control" type="text" name="name" placeholder="Name" required>
                    </div>

                    <div class="form-group">
                        <label for="description"><b>Description</b></label><br>
                        <input class="form-control" type="text" name="description" placeholder="Description" required>
                    </div>

                    <div class="form-group">
                        <label for="fromtime"><b>From Time</b></label><br>
                        <input class="form-control" type="time" name="fromtime" placeholder="From Time">
                    </div>

                    <div class="form-group">
                        <label for="totime"><b>To Time</b></label><br>
                        <input class="form-control" type="time" name="totime" placeholder="To Time">
                    </div>

                    <div class="form-group">

                        Select image to upload:
                        <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
                    </div>
                
                <button type="submit" name="submit" class="btn btn-primary" id="submit-button">Submit</button>
                <button type= "button" class="btn btn-primary" id="cancel-button">Cancel</button>
            </form>
</div>
        </div>
    </div>

</body>

</html>