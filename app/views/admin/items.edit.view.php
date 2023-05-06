<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row justify-content-space-between w-100">
            <h1 class="display-5 mb-2"><a class="link" href="<?= ROOT ?>/admin/items">Items</a><i
                    class="fa-solid fa-chevron-right mx-2"></i>Edit Item</h1>
        <form action="" method="POST">
            <button class="btn btn-success text-uppercase fw-bold" type="submit">Update Item</button>
        </div>
        <?php if (isset($item)): ?>
            <div class="form-group">
                <label class="label required" for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name" value="<?= $itemx->item_name ?>" required>
            </div>
            <div class="form-group">
                <label class="label" for="description">Description</label>
                <textarea class="form-control" name="description" id="description" cols="30"
                          rows="5"><?= $itemx->description ?></textarea>
            </div>
            <div class="form-group">
                <label class="label required" for="unit">Unit</label>
                <select class="form-control" name="unit" id="unit" required>
                    <option value="">Select Unit</option>
                    <?php if (isset($units)) : ?>
                        <?php foreach ($units as $unit) : ?>
                            <option value="<?= $unit->unit_id ?>" <?= ($itemx->unit == $unit->unit_id) ? "selected" : "" ?>><?= $unit->unit_name ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="label required" for="category">Category</label>
                <select class="form-control" name="category" id="category" required>
                    <option value="">Select Category</option>
                    <?php if (isset($categories)) : ?>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category->category_id ?>" <?= ($itemx->category == $category->category_id) ? "selected" : "" ?>><?= $category->category_name ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

        </form>

        <?php else: ?>
            <h1>Item not found</h1>
        <?php endif; ?>
    </div>
</div>
</body>

</html>


<form action="<?= ROOT ?>/admin/items/create" method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label class="label required" for="name">Name</label>
        <input class="form-control" type="text" name="name" id="name" required>
    </div>
    <div class="form-group">
        <label class="label" for="description">Description</label>
        <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
    </div>
    <div class="form-group">
        <label class="label required" for="unit">Unit</label>
        <select class="form-control" name="unit" id="unit" required>
            <option value="">Select Unit</option>
            <?php if (isset($units)) : ?>
                <?php foreach ($units as $unit) : ?>
                    <option value="<?= $unit->unit_id ?>"><?= $unit->unit_name ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
    <div class="form-group">
        <label class="label required" for="category">Category</label>
        <select class="form-control" name="category" id="category" required>
            <option value="">Select Category</option>
            <?php if (isset($categories)) : ?>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                <?php endforeach; ?>
            <?php endif ?>
        </select>
    </div>
    <div class="form-group">
        <label for="item-image" class="label required">Upload Image</label>
        <input type="file" name="item-image" id="item-image" class="form-control" required>
    </div>
    <div class="d-flex justify-content-space-between">
        <button type="button" class="btn btn-secondary text-uppercase fw-bold" id="cancel-button">Cancel</button>
        <button class="btn btn-primary text-uppercase fw-bold" type="submit" id="submit-button">Save Item</button>
    </div>
</form>
