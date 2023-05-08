<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/menus.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/tables.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <?php if (isset($m)): ?>
            <form method="POST">
                <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
<!--                    chevron right-->
                    <h1 class="display-5 mb-2"><a class="link" href="<?= ROOT ?>/admin/menus">Menus</a><i class="fa-solid fa-chevron-right mx-2"></i>Edit</h1>
                    <button class="btn btn-success text-uppercase fw-bold" type="submit" href="<?= ROOT ?>/admin/menus">
                        Update Menu
                    </button>
                </div>
                <div class="w-50">
                    <div class="form-group">
                        <label class="label" for="menu_id">Menu ID</label>
                        <input class="form-control" type="text" name="menu_id" value="<?= $m->menu_id ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label class="label" for="name">Name</label>
                        <input class="form-control" type="text" name="menu_name" value="<?= $m->menu_name ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="label" for="description">Description</label>
                        <input class="form-control" type="text" name="description" value="<?= $m->description ?>"
                               required>
                    </div>

                </div>
            </form>
        <?php else: ?>
            <h1>Menu not found</h1>
        <?php endif; ?>
    </div>
</div>
</body>

</html>
