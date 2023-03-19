<!DOCTYPE html>
<html lang="en">

<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/inventory.dashboard.css">
    <script src="<?= ASSETS ?>/js/admin/inventory.dashboard.js"></script>
</head>

<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-3">Inventory Dashboard</h1>
        </div>
                <!--                divide invlist into two arrays-->
        <?php $invlist = array_chunk($invlist, ceil(count($invlist) / 2)); ?>
        <div class="row text-center">
            <div class="col-6">

                <?php foreach ($invlist[0] as $item) : ?>
                    <div class="card" data-last-updated="<?= $item->last_updated ?>"
                         data-buffer-level="<?= $item->buffer_stock_level ?>"
                         data-reorder-level="<?= $item->reorder_level ?>" data-lead-time="<?= $item->lead_time ?>">
                        <div class="card-image">
                            <img src="<?= ASSETS ?>./images/items/<?= $item->image_url ?>"
                                 alt="<?= $item->item_name ?>">
                        </div>
                        <div class="card-name">
                            <?= $item->item_name ?><br>
                            <span class="not-updated">not updated recently</span>
                        </div>
                        <div class="card-quantity">
                            <span>
                                <span class="numerator"><?= $item->amount_remaining ?></span>
                                <span class="denominator">/<?= $item->max_stock_level ?></span>
                            </span>
                            <div class="progress">
                                <div class="progress-bar"></div>
                            </div>
                            <span class="batches-left">
                                5 batches left
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="col-6">
                <?php foreach ($invlist[1] as $item) : ?>
                    <div class="card" data-last-updated="<?= $item->last_updated ?>"
                         data-buffer-level="<?= $item->buffer_stock_level ?>"
                         data-reorder-level="<?= $item->reorder_level ?>" data-lead-time="<?= $item->lead_time ?>">
                        <div class="card-image">
                            <img src="<?= ASSETS ?>./images/items/<?= $item->image_url ?>"
                                 alt="<?= $item->item_name ?>">
                        </div>
                        <div class="card-name">
                            <?= $item->item_name ?><br>
                            <span class="not-updated">not updated recently</span>
                        </div>
                        <div class="card-quantity">
                <span>
                    <span class="numerator"><?= $item->amount_remaining ?></span>
                    <span class="denominator">/<?= $item->max_stock_level ?></span>
                </span>
                            <div class="progress">
                                <div class="progress-bar"></div>
                            </div>
                            <span class="batches-left">
                                5 batches left
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>


    </div>
</div>
</body>

</html>