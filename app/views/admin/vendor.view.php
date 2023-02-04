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
            <a class="btn btn-primary text-uppercase fw-bold" href="vendors/addVendor" id="add-vendor-button">+ New Vendors</a>
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
                <th>Action</th>
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
                echo "<td><a class='edit-icon-link' href='vendors/edit/" . $v1->vendor_id . "'><i class='fa fa-edit edit-icon' aria-hidden='true'></i></a></td>";
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
            <button class="btn btn-success text-uppercase fw-bold" type="submit" name="save" id="submit-button">Save Vendor</button>
        </form>
    </div>
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