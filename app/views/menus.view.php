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

<table>
    <tr>
        <th> id</th>
        <th> name</th>
        <th> description</th>
        <th> start_time</th>
        <th> end_time</th>
        <th> image_url</th>
        <th> all_day</th>
    </tr>

    <?php

    if (isset($menulist)) {
        foreach ($menulist as $menu) {
            echo "<tr>";
            echo "<td>" . $menu->menu_id . "</td>";
            echo "<td>" . $menu->name . "</td>";
            echo "<td>" . $menu->description . "</td>";
            echo "<td>" . $menu->start_time . "</td>";
            echo "<td>" . $menu->end_time . "</td>";
            echo "<td>" . $menu->image_url . "</td>";
            echo "<td>" . $menu->all_day . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>
<br>
<br>

<a href="<?php echo ROOT; ?>">Index</a>
<a href="<?php echo ROOT; ?>/menus/addMenu">Add Menu</a>
</body>

</html>