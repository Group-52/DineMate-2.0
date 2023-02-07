<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/user.css">
    <script src="<?= ASSETS ?>/js/admin/user.js"></script>
    <title>Users</title>
</head>

<body class="dashboard">
    <?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
    <div class="dashboard-container">
        <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
        <div class="w-100 h-100 p-5">
            <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-3">Users</h1>
            </div>
            <div id="user-tables">
                <div class="tab">
                    <button class="tablinks btn btn-success" onclick="openTab(event, 'guest')">Guest User</button>
                    <button class="tablinks btn btn-success" onclick="openTab(event, 'customer')">Customer</button>
                    <button class="tablinks btn btn-success" onclick="openTab(event, 'blocklist')">Blocklist User</button>
                </div>

                <div id="guest" class="tabcontent">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Guest ID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Contact</th>
                                <th scope="col">Email</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php if (isset($guest)) : ?>
                                <?php foreach ($guest as $g1) : ?>
                                    <tr>
                                        <td><?= $g1->guest_id ?></td>
                                        <td><?= $g1->first_name ?></td>
                                        <td><?= $g1->last_name ?></td>
                                        <td><?= $g1->contact_no ?></td>
                                        <td><?= $g1->email ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </div>
</body>

</html>