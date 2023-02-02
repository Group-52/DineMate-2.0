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
        <form action="" method="POST">
            <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-4"><a class="link" href="<?= ROOT ?>/admin/vendors">Vendors</a> > New Vendor</h1>
                <button class="btn btn-success text-uppercase fw-bold" type="submit">Save Vendor</button>
            </div>
            <div class="form-group">
                <label class="label" for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name">
            </div>
            <div class="form-group">
                <label class="label" for="address">Address</label>
                <input class="form-control" type="text" name="address" id="address">
            </div>
            <div class="form-group">
                <label class="label" for="company">Company</label>
                <input class="form-control" name="company" id="company">
            </div>
            <div class="form-group">
                <label class="label" for="contact_no">Contact No</label>
                <input class="form-control" name="contact_no" id="contact_no">
            </div>
            <!-- <div class="form-group">
                <label class="label" for="unit">Unit</label>
                <select class="form-control" name="unit" id="unit">
                    <option value="">Select Unit</option>
                    <?php if (isset($units)) : ?>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?= $unit->unit_id ?>"><?= $unit->unit_name ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div> -->
            <!-- <div class="form-group">
                <label class="label" for="category">Category</label>
                <select class="form-control" name="category" id="category">
                    <option value="">Select Category</option>
                    <?php foreach ($data["categories"] as $category): ?>
                        <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div> -->
        </form>
    </div>
</div>
</body>
</html>