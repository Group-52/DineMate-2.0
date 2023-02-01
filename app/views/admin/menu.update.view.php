<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Update Menu</title>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <style>
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
        /* trash */
        .trash-icon {
            display: none;
        }
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
        #edit-menu-button {
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

            <div class='row'>
                <div class='col-6'>
                    <div id="menu-items">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Dish</th>
                                    <th>Selling Price</th>
                                    <th>Prep Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($menu_items as $item) : ?>
                                    <tr data-dish-id="<?= $item->dish_id ?>">
                                        <td><?= $item->dish_id ?></td>
                                        <td><?= $item->dish_name ?></td>
                                        <td><?= $item->selling_price ?></td>
                                        <td><?= $item->prep_time ?></td>
                                        <td><i class="fa fa-trash trash-icon" aria-hidden="true"></i></td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                        <div class='form-group'>
                            <label for="selected_dish">Select Dish</label>
                            <select name="selected_dish" class="form-control">
                                <?php foreach ($dishes as $dish) : ?>
                                    <option value="<?= $dish->dish_id ?>"><?= $dish->dish_name ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" id="add_dish_button" class="btn btn-primary">Add Dish</button>
                        </div>

                    </div>
                </div>
                <div class='col-6'>
                    <div id="menu-details">
                        <div class="card-container">
                            <div class="card">
                                <img src="<?= ASSETS ?>/images/menus/<?= $menu->image_url ?>" alt="menu image" width="300px" height="300px">
                                <div class="container">
                                    
                                    <h2> #<?= $menu->menu_id ?> <?= $menu->menu_name ?> </h2>
                                    <h3><?= $menu->description ?></h3>
                                    <?php if ($menu->start_time) : ?>
                                        <h3>Start-Time : <?= $menu->start_time ?></h3>
                                    <?php endif; ?>
                                    <?php if ($menu->end_time) : ?>
                                        <h3>End-Time : <?= $menu->end_time ?></h3>
                                    <?php endif; ?>     
                                    <h3>All Day: <input type="checkbox" name="all_day" value="1" <?php echo ($menu->all_day == 1 ? 'checked' : ''); ?> /></h3>
            
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
                <button type="button" id="edit-menu-button" class="btn btn-primary">Edit</button>


            </div>

        </div>
    </div>

</body>
</html>
