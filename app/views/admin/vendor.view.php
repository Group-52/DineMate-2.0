<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <script src="<?= ASSETS ?>/js/admin/vendors.js"></script>
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-vendors-center justify-content-space-between w-100">
            <h1 class="display-3">Vendors</h1>
            <a class="btn btn-primary text-uppercase fw-bold h-50" href="vendors/addVendor" id="add-vendor-button">+ New Vendors</a>
        </div>
        <div>
            <form action="" method="GET">
                <div class="row">
                    <div class="form-search col-10">
                        <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
                        <button class="form-search-icon" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div id="vendor-table">
        <table class=" table">
        <thead>
            <tr>
                <th>VendorID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Company</th>
                <th>Contact No</th>
            </tr>
            </thead>
    
    <tbody>
    
        <?php if (isset($Vendor)) {
            foreach ($Vendor as $v1) {
                echo "<tr>";
                echo "<td>" . $v1->vendor_id . "</td>";
                echo "<td>" . $v1->vendor_name. "</td>";
                echo "<td>" . $v1->address . "</td>";
                echo "<td>" . $v1->company . "</td>";
                echo "<td>" . $v1->contact_no . "</td>";
                echo "<td>" . $v1->email . "</td>";
                echo "<td><a class='edit-icon-link' href='vendors/edit/" . $v1->vendor_id . "'><i class='fa fa-edit edit-icon' aria-hidden='true'></i></a></td>";
                echo "<td><a class='cart-trash-icon' href='vendors/delete/" . $v1->vendor_id . "'><i class='fa-solid fa-trash cart-delete p-1 pointer'</i></a></td>";
            }
        }
        ?>
        </tbody>
        </table>
        </div>
        <div id="vendor-form" class="overlay">
        <form action="<?= ROOT ?>/admin/vendors/addVendor" method="POST">
            
            <div class="form-group">
                <label class="label" for="name">Name</label>
                <input class="form-control" type="text" name="vendor_name" id="vendor_name" required>
            </div>
            <div class="form-group">
                <label class="label" for="address">Address</label>
                <input class="form-control" type="text" name="address" id="address">
            </div>
            <div class="form-group">
                <label class="label" for="company">Company</label>
                <input class="form-control" type="text" name="company" id="company">
            </div>
            <div class="form-group">
                <label class="label" for="contact_no">Contact No</label>
                <input class="form-control" type="text" name="contact_no" id="contact_no" required>
            </div>
            <div class="form-group">
                <label class="label" for="email">Email</label>
                <input class="form-control" type="text" name="email" id="email">
            </div>
            <button class="btn btn-success text-uppercase fw-bold" type="submit" name="save" id="submit-button">Save Vendor</button>
            <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>
        </form>
    </div>
    </div>
</div>
</body>
</html>