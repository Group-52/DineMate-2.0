<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        Feedback
    </title>

    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/common.css">
    <link rel="stylesheet" href="<?= ROOT ?>/assets/css/admin/feedback.css">
    <link rel = "stylesheet" href = "<?= ASSETS ?>/css/admin/tables.css">

    <?php include VIEWS . "/partials/home/head.partial.php" ?>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header">

                <h1 class="display-3 active">Feedback</h1>
            </div>

            <div id="feedback-table">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Rating</th>
                            <th>Description</th>
                            <th>Time Placed</th>
                            <th>Customer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($feedback_list as $f) : ?>
                            <tr data-id="<?= $f->feedback_id ?>">
                                <td><?= $f->order_id ?></td>
                                <td><?= $f->rating ?></td>
                                <td><?= $f->description ?></td>
                                <td><?= $f->time_placed ?></td>
                                <td><?= $f->first_name . " " . $f->last_name ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
            </div>

        </div>
    </div>
</body>

</html>