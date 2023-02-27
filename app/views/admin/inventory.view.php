<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/inventory.css">
    <script src="<?= ASSETS ?>/js/admin/inventory.js"></script>
</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-3">Inventory</h1>
            <a class="btn btn-primary text-uppercase fw-bold" href="#" id="finish-button">Finish Editing</a>
            <a class="btn btn-primary text-uppercase fw-bold" href="#" id="edit-button">Edit</a>
            <a class="btn btn-primary text-uppercase fw-bold" href="<?= ROOT ?>/admin/inventory/info"
               id="switch-button">Detailed View</a>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Amount Remaining</th>
                <th>Last Updated</th>
                <th> Max Stock Level</th>
                <th> Buffer Stock Level</th>
                <th>Reorder Level</th>
                <th> Lead Time</th>

            </tr>
            </thead>
            <tbody>
            <?php if (isset($inventory)) : ?>
                <?php foreach ($inventory as $item) : ?>
                    <tr data-item-id="<?= $item->item_id ?>">
                        <td><?= $item->item_name ?></td>
                        <td><?= $item->amount_remaining ?> <?= $item->abbreviation ?></td>
                        <td><?= $item->last_updated ?></td>
                        <td data-field-name="max_stock_level"><?= $item->max_stock_level ?></td>
                        <td data-field-name="buffer_stock_level"><?= $item->buffer_stock_level ?></td>
                        <td data-field-name="reorder_level"><?= $item->reorder_level ?></td>
                        <td data-field-name="lead_time"><?= $item->lead_time ?></td>
                        <td><i class="fa fa-pencil-square-o edit-icon" aria-hidden="true"></i></td>
                        <td><i class="fa fa-check-circle tick-icon edit-options" aria-hidden="true"></i></td>
                        <td><i class="fa fa-times-circle cross-icon edit-options" aria-hidden="true"></i></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <!-- Pagination row -->

        <div class="d-flex justify-content-center pagination">
            <nav>
                <div>

                    <!--                    Previous button-->

                    <?php if ($currentPage != 1) : ?>
                        <span class="page-item">
                                <a class="page-link page-move" href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                        </span>
                    <?php endif; ?>
                    <!--                    Page numbers-->
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <span class="page-item <?php if ($currentPage == $i) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </span>
                    <?php endfor; ?>
                    <!--                    Next button-->
                    <?php if ($currentPage != $totalPages) : ?>
                        <span class="page-item">
                          <a class="page-link page-move" href="?page=<?php echo $currentPage + 1; ?>"> Next </a>
                        </span>
                    <?php endif; ?>

                </div>
            </nav>
        </div>
    </div>
</div>
</body>

</html>