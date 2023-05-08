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
    <?php if (isset($e1)): ?>
        <form method="POST">
            <div class="dashboard-header d-flex flex-row align-employees-center justify-content-space-between w-100">
                <h1 class="display-4"><a class="link" href="<?= ROOT ?>/admin/employees">Employees</a> <i class="fa-solid fa-chevron-right mx-2"></i> Edit Employee</h1>
                <button class="btn btn-success text-uppercase fw-bold" id="update-button" type="submit">Update Employee</button>
            </div>
            <div class="form-group">
                <label class="label" for="emp_id">Employee ID</label>
                <input class="form-control" type="text" name="emp_id" value="<?= $e1->emp_id ?>" readonly>
            </div>
            <div class="form-group">
                <label class="label" for="first_name">First Name</label>
                <input class="form-control" type="text" name="first_name" value="<?= $e1->first_name ?>" required>
            </div>
            <div class="form-group">
                <label class="label" for="last_name">Last Name</label>
                <input class="form-control" type="text" name="last_name" value="<?= $e1->last_name ?>" required>
            </div>
            <div class="form-group">
                <label class="label" for="role">Role</label>
                <select class="form-control" name="role" required>
                <?php if (($e1->role) == "Chef") {
                    echo '<option value="1" selected hidden>Chef</option >';
                }
                else if (($e1->role) == 'General Manager'){
                    echo '<option value="2" selected hidden>General Manager</option >';
                }
                else if (($e1->role) == 'Cashier'){
                    echo '<option value="3" selected hidden>Cashier</option >';
                }
                else if (($e1->role) == 'Inventory Manager'){
                    echo '<option value="4" selected hidden>Inventory Manager</option >';
                }?>

                        <option value="1">Chef</option>
                        <option value="2">General Manager</option>
                        <option value="3">Cashier</option>
                        <option value="4">Inventory Manager</option>
                </select>
            </div>
            <div class="form-group">
                <label class="label" for="salary">Salary</label>
                <input class="form-control" type="number" min="0" name="salary" value="<?= $e1->salary ?>" required>
            </div>
            <!-- <div class="form-group">
                <label class="label" for="DOB">Date of Birth</label>
                <input class="form-control" name="DOB" value="<?= $e1->DOB ?>" readonly>
            </div> -->
            <div class="form-group">
                <label class="label" for="contact_no">Contact No</label>
                <input class="form-control" type="number" name="contact_no" value="<?= $e1->contact_no ?>" required>
            </div>
            <div class="form-group">
                <label class="label" for="email">Email</label>
                <input class="form-control" name="email" value="<?= $e1->email ?>">
            </div>
            <div class="form-group">
                <label class="label" for="NIC">NIC</label>
                <input class="form-control" name="NIC" value="<?= $e1->NIC ?>" required>
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

<script>

    const submitButton = document.querySelector('#update-button');

    function validateEmail(email) {
        if (email == "") {
            return true;
        }
        let re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    //validate email
    const email = document.querySelector('input[name="email"]');
    email.addEventListener('change', () => {
        if (!validateEmail(email.value)) {
            submitButton.disabled = true;
            new Toast("fa-solid fa-exclamation-circle", "red", "Error", "Email is not valid", false, 3000);
        } else {
            submitButton.disabled = false;
        }
    });

    const contact_no = document.querySelector('input[name="contact_no"]');
    contact_no.addEventListener('change', () => {
        if (contact_no.value == "") {
            submitButton.disabled = true;
            new Toast("fa-solid fa-exclamation-circle", "red", "Error", "Contact no is required", false, 3000);
        } else if (contact_no.value.length != 10) {
            submitButton.disabled = true;
            new Toast("fa-solid fa-exclamation-circle", "red", "Error", "Contact no must be 10 digits", false, 3000);
        } else {
            submitButton.disabled = false;
        }
    });
</script>