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
            <h5 class="display-5 mb-2">Inventory Dashboard</h5>
            <div class="d-flex align-items-center w-50">
                <div id="search" class="form-search order-md-0 order-1 w-100 mr-2">
                    <input type="text" class="form-control" placeholder="Search inventory" id="search-field">
                    <button class="form-search-icon"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <a class="btn btn-primary text-uppercase fw-bold detailed-view-button d-block" href="<?= ROOT ?>/admin/inventory">Detailed View</a>
            </div>
        </div>

        <div class="row justify-content-space-evenly">
            <?php foreach ($invlist as $key => $category): ?>
                <div class="category w-100 pb-2 justify-content-start">
                    <div class="w-100 category-name display-6 pr-4 py-2 mt-3"><?= $key ?></div>
                    <div class="grid-xl-3 grid-lg-2 grid-1 grid-gap-3">
                    <?php if (isset($category) && count($category)):?>
                    <?php foreach ($category as $item) : ?>
                        <div class="card justify-content-space-between align-items-center align-content-center"
                             data-last-updated="<?= $item->last_updated ?>"
                             data-buffer-level="<?= $item->buffer_stock_level ?>"
                             data-reorder-level="<?= $item->reorder_level ?>" data-lead-time="<?= $item->lead_time ?>"
                             style="display: flex"
                        >
                            <div class="d-flex align-items-center">
                                <div class="card-image">
                                    <img src="<?= ASSETS ?>/images/items/<?= $item->image_url ?>"
                                         alt="<?= $item->item_name ?>">
                                </div>
                                <div>
                                    <span class="card-name"><?= $item->item_name ?></span><br>
                                    <span class="not-updated">not updated recently</span>
                                </div>
                            </div>
                            <div class="card-quantity col align-items-center">
                                <span>
                                    <span class="numerator"><?= $item->amount_remaining ?></span>
                                    <span class="denominator">/<?= $item->max_stock_level ?></span>
                                    <span><?= $item->abbreviation ?></span>
                                </span>
                                <div class="progress">
                                    <div class="progress-bar"></div>
                                </div>
                                <span class="batches-left">
                                    <?php if (isset($batchcounts[$item->item_id])) : ?>
                                        <?= $batchcounts[$item->item_id] ?> batches left
                                    <?php else : ?>
                                        0 batches left
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php else:?>
                        <div class="mt-2 w-100">No Purchases Made</div>
                    <?php endif;?>
                </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
</body>

</html>
