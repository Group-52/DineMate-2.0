<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/inventory.css">
    <script src="<?= ASSETS ?>/js/admin/inventory.js"></script>
    <script src="<?= ASSETS ?>/js/admin/common.js"></script>
</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-5 mb-2">Inventory</h1>
            <div class="dashboard-buttons">
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="finish-button">Finish Editing</a>
                <a class="btn btn-primary text-uppercase fw-bold" href="#" id="edit-button">Edit</a>
                <a class="btn btn-primary text-uppercase fw-bold" href="<?= ROOT ?>/admin/inventory/info" id="switch-button">View Batches</a>
            </div>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Amount Remaining</th>
                <th>Last Updated</th>
                <th>Max Stock Level</th>
                <th>Buffer Stock Level</th>
                <th>Reorder Level</th>
                <th>Lead Time (Weeks)</th>

            </tr>
            </thead>
            <tbody>
            <?php if (isset($inventory)) : ?>
                <?php foreach ($inventory as $item) : ?>
                    <tr data-item-id="<?= $item->item_id ?>">
                        <td><?= $item->item_name ?></td>
                        <td><?= $item->amount_remaining ?> <?= $item->abbreviation ?></td>
                        <td><?= substr($item->last_updated, 0, 10) ?></td>
                        <td data-field-name="max_stock_level"><?= $item->max_stock_level ?></td>
                        <td data-field-name="buffer_stock_level"><?= $item->buffer_stock_level ?></td>
                        <td data-field-name="reorder_level"><?= $item->reorder_level ?></td>
                        <td data-field-name="lead_time"><?= $item->lead_time ?></td>
                        <td><i class="fa fa-pencil-square-o edit-icon" aria-hidden="true"></i></td>
                        <td><i class="fa fa-trash trash-icon" aria-hidden="true"></i></td>
                        <td><i class="fa fa-check-circle tick-icon edit-options" aria-hidden="true"></i></td>
                        <td><i class="fa fa-times-circle cross-icon edit-options" aria-hidden="true"></i></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <?php include VIEWS . "/partials/admin/paginationbar.partial.php" ?>
        <div class="popup" id="delete-popup">
            <p>
                Are you sure you want to delete this item from the inventory? New inventory entries will be created only upon purchase of new items
            </p>
            <div class="popup-button-div">
                <button class="btn btn-success" id="confirm">Yes</button>
                <button class="btn btn-danger" id="cancel">No</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>