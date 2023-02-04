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
    <?php if (isset($v1)): ?>
    <h2>Vendor #<?= $v1->vendor_id ?></h2>
        <form action="" method="POST">
            <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
                <h1 class="display-4"><a class="link" href="<?= ROOT ?>/admin/vendors">Vendors</a> > Edit Vendor</h1>
                <button class="btn btn-success text-uppercase fw-bold" type="submit" name="save" href="<?= ROOT ?>/admin/vendors">Update Vendor</button>
            </div>
            <div class="form-group">
                <label class="label" for="vendor_id">Vendor Id</label>
                <input class="form-control" type="text" name="vendor_id" value="<?= $v1->vendor_id ?>">
            </div>
            <div class="form-group">
                <label class="label" for="name">Name</label>
                <input class="form-control" type="text" name="name" value="<?= $v1->name ?>">
            </div>
            <div class="form-group">
                <label class="label" for="address">Address</label>
                <input class="form-control" type="text" name="address" value="<?= $v1->address ?>">
            </div>
            <div class="form-group">
                <label class="label" for="company">Company</label>
                <input class="form-control" type="text" name="company" value="<?= $v1->company ?>">
            </div>
            <div class="form-group">
                <label class="label" for="contact_no">Contact No</label>
                <input class="form-control" type="text" name="contact_no" value="<?= $v1->contact_no ?>">
            </div>
        </form>
    <?php else: ?>
    <h1>Vendor not found</h1>
    <?php endif; ?>
    </div>
</div>
</body>
</html>