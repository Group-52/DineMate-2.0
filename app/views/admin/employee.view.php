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
            <h1 class="display-3">Employees</h1>
            <a class="btn btn-primary text-uppercase fw-bold" href="employees/addEmployee">+ New Employee</a>
        </div>
        <div>
        </div>
        <table class="table">
        <thead class="table-dark">
            <tr>
                <th scope="col">#Id</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Role</th>
                <th scope="col">Salary</th>
                <!-- <th scope="col">DOB</th> -->
                <th scope="col">Contact No</th>
                <th scope="col">NIC</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
    
    <tbody>
    
        <?php if (isset($employee)) {
            foreach ($employee as $e1) {
                echo "<tr>";
                echo "<td>" . $e1->emp_id . "</td>";
                echo "<td>" . $e1->first_name. "</td>";
                echo "<td>" . $e1->first_name . "</td>";
                echo "<td>" . $e1->role . "</td>";
                echo "<td>" . $e1->salary . "</td>";
                // echo "<td>" . $e1->DOB . "</td>";
                echo "<td>" . $e1->contact_no . "</td>";
                echo "<td>" . $e1->NIC . "</td>";
                echo "<td><a class='edit-icon-link' href='vendors/edit/" . $e1->emp_id . "'><i class='fa fa-edit edit-icon' aria-hidden='true'></i></a></td>";
            }
        }
        ?>
        </tbody>
        </table>
    </div>
</div>
</body>
</html>