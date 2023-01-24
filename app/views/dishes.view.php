<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>

    </title>
    <style>
        img {
            width: 200px;
            height: 200px;
        }
    </style>
</head>

<body>
    <h1>

        <a href="<?php echo ROOT; ?>">Index</a>
        <a href="<?php echo ROOT; ?>/admin/dishes/addDish">Add Dish</a>
    </h1>
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
            echo "<tr>";
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
<br>
<br>


</body>

</html>