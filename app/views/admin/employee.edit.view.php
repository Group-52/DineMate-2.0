<!DOCTYPE html>
<html lang="en">
<head>
<?php include VIEWS . "/partials/admin/head.partial.php" ?>
</head>
<body class="dashboard">
<!-- <?php include VIEWS . "/partials/admin/navbar.partial.php" ?> -->
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
    <?php if (isset($e1)): ?>
    <h2>Employee #<?= $e1->emp_id ?></h2>
        <form method="POST">
            <div class="dashboard-header d-flex flex-row align-employees-center justify-content-space-between w-100">
                <h1 class="display-4"><a class="link" href="<?= ROOT ?>/admin/employees">Employees</a> > Edit Employee</h1>
                <button class="btn btn-success text-uppercase fw-bold" type="submit" href="<?= ROOT ?>/admin/employees">Update Employee</button>
            </div>
            <div class="form-group">
                <label class="label" for="emp_id">Employee ID</label>
                <input class="form-control" type="text" name="emp_id" value="<?= $e1->emp_id ?>" readonly>
            </div>
            <div class="form-group">
                <label class="label" for="first_name">First Name</label>
                <input class="form-control" type="text" name="first_name" value="<?= $e1->first_name ?>" readonly>
            </div>
            <div class="form-group">
                <label class="label" for="last_name">Last Name</label>
                <input class="form-control" type="text" name="last_name" value="<?= $e1->last_name ?>" readonly>
            </div>
            <div class="form-group">
                <label class="label" for="role">Role</label>
                <select class="form-control" name="role" value="<?= $e1->role ?>" readonly>
                        <option value="0">----</option>
                        <option value="1">Chef</option>
                        <option value="2">General Manager</option>
                        <option value="3">Cashier</option>
                        <option value="4">Inventory Manager</option>
                </select>
            </div>
            <div class="form-group">
                <label class="label" for="salary">Salary</label>
                <input class="form-control" name="salary" value="<?= $e1->salary ?>">
            </div>
            <!-- <div class="form-group">
                <label class="label" for="DOB">Date of Birth</label>
                <input class="form-control" name="DOB" value="<?= $e1->DOB ?>" readonly>
            </div> -->
            <div class="form-group">
                <label class="label" for="contact_no">Contact No</label>
                <input class="form-control" name="contact_no" value="<?= $e1->contact_no ?>">
            </div>
            <div class="form-group">
                <label class="label" for="NIC">NIC</label>
                <input class="form-control" name="NIC" value="<?= $e1->NIC ?>" readonly>
            </div>
        </form>
    <?php else: ?>
    <h1>Vendor not found</h1>
    <?php endif; ?>
    </div>
</div>
</body>

<style>
    .align-employees-center {
    align-items: center;
    }
</style>
</html>