<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/admin/head.partial.php" ?>
    <script src="<?= ASSETS ?>/js/admin/common.js"></script>
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <?php if (isset($v1)): ?>
            <h2>Vendor #<?= $v1->vendor_id ?></h2>
            <form method="POST">
                <div class="dashboard-header d-flex flex-row align-content-center justify-content-space-between w-100">
                    <h1 class="display-4"><a class="link" href="<?= ROOT ?>/admin/vendors">Vendors</a> > Edit Vendor
                    </h1>
                    <button class="btn btn-success text-uppercase h-50 fw-bold" type="submit"
                            href="<?= ROOT ?>/admin/vendors">Update Vendor
                    </button>
                </div>
                <div class="w-50">
                    <div class="form-group">
                        <label class="label" for="vendor_id">Vendor Id</label>
                        <input class="form-control" type="text" name="vendor_id" value="<?= $v1->vendor_id ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label class="label" for="vendor_name">Vendor Name</label>
                        <input class="form-control" type="text" name="vendor_name" value="<?= $v1->vendor_name ?>">
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
                    <div class="form-group">
                        <label class="label" for="email">Email</label>
                        <input class="form-control" type="text" name="email" value="<?= $v1->email ?>">
                    </div>
                </div>
            </form>
        <?php else: ?>
            <h1>Vendor not found</h1>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

<script>
    //if contact no and vendor name is empty, disable submit button and view error
    const vendor_name = document.querySelector('input[name="vendor_name"]');
    const contact_no = document.querySelector('input[name="contact_no"]');
    const submit = document.querySelector('button[type="submit"]');

    vendor_name.addEventListener('input', () => {
        if (vendor_name.value == "") {
            submit.disabled = true;
            displayError("Vendor name is required", vendor_name.getBoundingClientRect().top);
        } else {
            submit.disabled = false;
        }
    });
    contact_no.addEventListener('input', () => {
        if (contact_no.value == "") {
            submit.disabled = true;
            displayError("Contact number is required", contact_no.getBoundingClientRect().top);
        } else {
            submit.disabled = false;
        }
    });

</script>