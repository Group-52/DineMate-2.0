<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>

    </title>
    <style>
        img {
            width: 100px;
            height: 100px;
            border-radius: 5px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            color: #588c7e;
            font-family: monospace;
            font-size: 25px;
            text-align: left;
        }

        th {
            background-color: #588c7e;
            color: white;
            padding: 10px;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        td {
            padding: 10px;
            text-align: center;
        }

        #add-dish-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
    </style>
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/common.css">
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


            <table>
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
                        echo "</tr>";
                    }
                }
                ?>
            </table>
            <a class="btn btn-primary" id="add-dish-button" href="<?php echo ROOT ?>/admin/dishes/addDish">Add Dish</a>

        </div>
    </div>
</body>

</html>