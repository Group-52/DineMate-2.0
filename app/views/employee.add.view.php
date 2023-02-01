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
                <h1 class="display-4"><a class="link" href="<?= ROOT ?>/admin/employees">Employees</a> > New Employee</h1>
                <button class="btn btn-success text-uppercase fw-bold" type="submit">Save Employee</button>
            </div>
            <div class="form-group">
                <label class="label" for="name">Name</label>
                <input class="form-control" type="text" name="name" id="name">
            </div>
            <div class="form-group">
                <label class="label" for="role">Role</label>
                <input class="form-control" type="text" name="role" id="role">
            </div>
            <div class="form-group">
                <label class="label" for="salary">Salary</label>
                <input class="form-control" name="salary" id="salary">
            </div>
            <div class="form-group">
                <label class="label" for="DOB">Date of Birth</label>
                <input class="form-control" name="DOB" id="DOB">
            </div>
            <div class="form-group">
                <label class="label" for="contact_no">Contact No</label>
                <input class="form-control" name="contact_no" id="contact_no">
            </div>
            <div class="form-group">
                <label class="label" for="NIC">NIC</label>
                <input class="form-control" name="NIC" id="NIC">
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