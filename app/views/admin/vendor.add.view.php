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
            <div class="dashboard-header d-flex flex-row align-vendors-center justify-content-space-between w-100">
                <h1 class="display-4"><a class="link" href="<?= ROOT ?>/admin/vendors">Vendors</a> > New Vendor</h1>
                <button class="btn btn-success text-uppercase fw-bold" type="submit" name="save" href="<?= ROOT ?>/admin/vendors">Save Vendor</button>
            </div>
            <div class="form-group">
                <label class="label" for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label class="label" for="address">Address</label>
                <input class="form-control" type="text" name="address" id="address" required>
            </div>
            <div class="form-group">
                <label class="label" for="company">Company</label>
                <input class="form-control" name="company" id="company" required>
            </div>
            <div class="form-group">
                <label class="label" for="contact_no">Contact No</label>
                <input class="form-control" type="number" name="contact_no" id="contact_no" required>
            </div>
        </form>
    </div>
</div>
</body>
<style>
.align-vendors-start {
  align-items: start;
}

.align-vendors-end {
  align-items: end;
}

.align-vendors-center {
  align-items: center;
}

.align-vendors-baseline {
  align-items: baseline;
}

.align-vendors-stretch {
  align-items: stretch;
}
</style>
</html>