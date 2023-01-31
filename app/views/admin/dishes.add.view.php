<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css">
    <style>
        input {
            padding: 15px;
            margin: 10px;
            display: block;
        }

        form {
            margin: 50px;
            padding: 50px;
        }

        h1 {
            text-align: center;
            width: 100%;
        }
    </style>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <!-- Show all the dishes in a list -->
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <h1>
                Add a Dish
            </h1>

            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control">
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
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Save</button>
            </form>

        </div>
    </div>
</body>

</html>