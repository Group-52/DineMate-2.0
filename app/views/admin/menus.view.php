<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include VIEWS . "/partials/home/head.partial.php" ?>
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

        #add-menu-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
    </style>
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

            <a href="<?= ROOT ?>/admin/menus/add" class="btn btn-primary" id="add-menu-button">Add Menu</a>
        </div>
    </div>

</body>

</html>