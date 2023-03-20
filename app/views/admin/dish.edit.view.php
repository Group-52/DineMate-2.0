<!DOCTYPE html>
<html lang="en">
<head>
<?php include VIEWS . "/partials/admin/head.partial.php" ?>
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
    <?php if (isset($dish)): ?>
    <h2>Dish #<?= $dish->dish_id ?></h2>
        <form method="POST">
            <div class="dashboard-header d-flex flex-row align-vendors-center justify-content-space-between w-100">
                <h1 class="display-4"><a class="link" href="<?= ROOT ?>/admin/dishes">Dishes</a> > Edit Dishes</h1>
                <button class="btn btn-success text-uppercase fw-bold" type="submit" href="<?= ROOT ?>/admin/dishes">Update Dishes</button>
            </div>
            <div class="form-group">
                <label class="label" for="dish_id">Dish Id</label>
                <input class="form-control" type="text" name="dish_id" value="<?= $dish->dish_id ?>" readonly>
            </div>
            <div class="form-group">
                <label class="label" for="dish_name">Dish Name</label>
                <input class="form-control" type="text" name="dish_name" value="<?= $dish->dish_name ?>" readonly>
            </div>
            <div class="form-group">
                <label class="label" for="prep_time">Preparation Time</label>
                <input class="form-control" type="number" name="prep_time" value="<?= $dish->prep_time ?>">
            </div>
            <div class="form-group">
                <label class="label" for="net_price">Net Price</label>
                <input class="form-control" type="number" name="net_price" value="<?= $dish->net_price ?>">
            </div>
            <div class="form-group">
                <label class="label" for="sellprice">Selling Price</label>
                <input class="form-control" type="number" name="selling_price" value="<?= $dish->selling_price ?>">
            </div>
        </form>
    <?php else: ?>
    <h1>Dish not found</h1>
    <?php endif; ?>
    </div>
</div>
</body>

<style>
    .align-vendors-start {
    align-items: start;
    }

    .align-vendors-end {
    align-items: end;
    }

    .align-vendors-center {
    align-items: center;
    }

    .align-vendors-baseline {
    align-items: baseline;
    }

    .align-vendors-stretch {
    align-items: stretch;
    }
</style>
</html>