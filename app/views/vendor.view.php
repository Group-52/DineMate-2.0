<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-items-center justify-content-space-between w-100">
            <h1 class="display-3">Vendors</h1>
            <a class="btn btn-primary text-uppercase fw-bold" href="vendors/addVendor">+ New Vendors</a>
        </div>
        
        <table class="table">
            <tr>
                <th scope="col">VendorID</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Company</th>
                <th scope="col">Contact No</th>
            </tr>
    
        <?php if (isset($Vendor)) {
            foreach ($Vendor as $v1) {
                echo "<tr>";
                echo "<td>" . $v1->vendor_id . "</td>";
                echo "<td>" . $v1->vendor_name. "</td>";
                echo "<td>" . $v1->address . "</td>";
                echo "<td>" . $v1->company . "</td>";
                echo "<td>" . $v1->contact_no . "</td>";
                echo "</tr>";
            }
        }
        ?>
        </table>
    </div>
</div>
</body>
</html>