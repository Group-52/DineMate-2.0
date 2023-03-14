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
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header">

                <h1 class="display-3 active">Dishes</h1>
            </div>

            <div id="dish-table">
                <table class="table">
                    <tr>
                        <th>Dish ID</th>
                        <th>Picture</th>
                        <th>Name</th>
                        <th>Preparation Time</th>
                        <th>Net Price</th>
                        <th>Selling Price</th>
                        <th>Description</th>
                    </tr>

                    <?php
                    if (isset($dish_list)) {
                        foreach ($dish_list as $dish) {
                            echo "<tr data-dish-id='" . $dish->dish_id . "'>";
                            echo "<td>" . $dish->dish_id . "</td>";
                            echo "<td><div class='dishpic'><img alt='" . $dish->dish_name . "'src='" . ASSETS . "/images/dishes/" . $dish->image_url . "'></div></td>";
                            echo "<td>" . $dish->dish_name . "</td>";
                            echo "<td>" . $dish->prep_time . "</td>";
                            echo "<td>" . $dish->net_price . "</td>";
                            echo "<td>" . $dish->selling_price . "</td>";
                            echo "<td>" . $dish->description . "</td>";
                            echo "<td><a class='cart-trash-icon' href='dishes/delete/" . $dish->dish_id . "'><i class='fa-solid fa-trash cart-delete p-1 pointer'></i></i></a></td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
            <a class="btn btn-primary" id="add-dish-button" href="<?php echo ROOT ?>/admin/dishes/addDish">Add Dish</a>
            <div id="dish-add-form" class="overlay">


                <form method="post" enctype="multipart/form-data" action="<?= ROOT ?>/admin/dishes/addDish">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="preptime">Preparation Time</label>
                        <input type="number" name="preptime" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="netprice">Net Price</label>
                        <input type="number" name="netprice" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="sellprice">Selling Price</label>
                        <input type="number" name="sellprice" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" name="description" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="fileToUpload">Select image to upload:</label>
                        <input type="file" name="fileToUpload" id="fileToUpload" class='form-control'>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary" id="submit-button">Save</button>
                    <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>