<!DOCTYPE html>
<html lang="en">
<?php include VIEWS . "/partials/admin/head.partial.php" ?>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <form action="" method="POST">
            <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-4"><a class="link" href="<?= ROOT ?>/admin/items">Items</a> > Create Item</h1>
                <button class="btn btn-success text-uppercase fw-bold" type="submit">Save Item</button>
            </div>
            <div class="form-group">
                <label class="label" for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name">
            </div>
            <div class="form-group">
                <label class="label" for="brand">Brand</label>
                <input class="form-control" type="text" name="brand" id="brand">
            </div>
            <div class="form-group">
                <label class="label" for="description">Description</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label class="label" for="unit">Unit</label>
                <select class="form-control" name="unit" id="unit">
                    <option value="">Select Unit</option>
                    <?php if (isset($units)) : ?>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?= $unit->unit_id ?>"><?= $unit->unit_name ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="label" for="category">Category</label>
                <select class="form-control" name="category" id="category">
                    <option value="">Select Category</option>
                    <?php foreach ($data["categories"] as $category): ?>
                        <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
</div>
</body>
</html>