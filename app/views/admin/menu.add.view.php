<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Menu</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">

</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">


            <form action="" method="POST">
                    <div class="form-group">
                        <label for="name"><b>Name</b></label><br>
                        <input class="form-control" type="text" name="name" placeholder="Name" required>
                    </div>

                    <div class="form-group">
                        <label for="description"><b>Description</b></label><br>
                        <input class="form-control" type="text" name="description" placeholder="Description" required>
                    </div>

                    <div class="form-group">
                        <label for="fromtime"><b>From Time</b></label><br>
                        <input class="form-control" type="time" name="fromtime" placeholder="From Time">
                    </div>

                    <div class="form-group">
                        <label for="totime"><b>To Time</b></label><br>
                        <input class="form-control" type="time" name="totime" placeholder="To Time">
                    </div>

                    <div class="form-group">

                        Select image to upload:
                        <input class="form-control" type="file" name="fileToUpload" id="fileToUpload">
                    </div>

                <input type="submit" name="submit" value="Save">
            </form>

        </div>
    </div>
</body>

</html>