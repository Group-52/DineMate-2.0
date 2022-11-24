<html <!DOCTYPE html>
<html>

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
        // show(get_defined_vars());

        // show($dishlist);
        foreach($dishlist as $dish){
            echo "<tr>";
            echo "<td>".$dish->dish_id."</td>";
            echo "<td><div class='dishpic'> <img src=".$dish->image_url." ></div></td>";
            echo "<td>".$dish->name."</td>";
            echo "<td>".$dish->prepTime."</td>";
            echo "<td>".$dish->netPrice."</td>";
            echo "<td>".$dish->sellingPrice."</td>";
            echo "<td>".$dish->description."</td>";
            echo "</tr>";
        }

        ?>
    </table>
    <br>
    <br>

        <a href = "<?php echo ROOT; ?>">Index</a>
        <a href = "<?php echo ROOT; ?>/dishes/addDish">Add Dish</a>
</body>

</html>