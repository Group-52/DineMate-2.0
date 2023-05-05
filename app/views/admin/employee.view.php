<!DOCTYPE html>
<html lang="en">
<head>
    <?php include VIEWS . "/partials/home/head.partial.php" ?>
    <link rel="stylesheet" href="<?= ASSETS ?>/css/admin/common.css">
    <script src="<?= ASSETS ?>/js/admin/employees.js"></script>
</head>
<body class="dashboard">
<?php include VIEWS . "/partials/admin/navbar.partial.php" ?>
<div class="dashboard-container">
    <?php include VIEWS . "/partials/admin/sidebar.partial.php" ?>
    <div class="w-100 h-100 p-5">
        <div class="dashboard-header d-flex flex-row align-employees-center justify-content-space-between w-100">
            <h1 class="display-3">Employees</h1>
            <a class="btn btn-primary text-uppercase fw-bold" href="employees/addEmployee" id="add-employee-button">+
                New Employee</a>
        </div>
        <div>
            <form action="" method="GET">
                <div class="row">
                    <div class="form-search col-10">
                        <input type="text" class="form-control" id="myInput" onkeyup="myFunction()"
                               placeholder="Search for names.." title="Type in a name">
                        <button class="form-search-icon" type="submit"><i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <div class="pl-2 col-2">
                        <select class="form-control" name="role" id="myInput2" onchange="filter()">
                            <option value="0">Filter Role</option>
                            <option value="Chef">Chef</option>
                            <option value="General Manager">General Manager</option>
                            <option value="Cashier">Cashier</option>
                            <option value="Inventory Manager">Inventory Manager</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div id="employee-table">
            <table class="table">
                <thead>
                <tr>
                    <th>#Id</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Salary</th>
                    <th>Email</th>
                    <th>User Name</th>
                    <th>Contact No</th>
                    <th>NIC</th>
                </tr>
                </thead>

                <tbody>
                <?php if (isset($employee)) {
                    foreach ($employee as $e1) {
                        echo "<tr>";
                        echo "<td>" . $e1->emp_id . "</td>";
                        echo "<td>" . $e1->first_name . " " . $e1->last_name . "</td>";
                        echo "<td>" . $e1->role . "</td>";
                        echo "<td>" . $e1->salary . "</td>";
                        echo "<td>" . $e1->email . "</td>";
                        echo "<td>" . $e1->username . "</td>";
                        echo "<td>" . $e1->contact_no . "</td>";
                        echo "<td>" . $e1->NIC . "</td>";
                        echo "<td><a class='edit-icon-link' href='employees/edit/" . $e1->emp_id . "'><i class='fa fa-edit edit-icon' aria-hidden='true'></i></a></td>";
                        echo "<td><a class='cart-trash-icon' href='employees/delete/" . $e1->emp_id . "'><i class='fa-solid fa-trash cart-delete p-1 pointer'</i></a></td>";
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
        <div id="employee-form" class="overlay">
            <form action="<?= ROOT ?>/admin/employees/addEmployee" method="POST">
                <div class="form-group">
                    <label class="label" for="first_name">First Name</label>
                    <input class="form-control" type="text" name="first_name" id="first_name" required>
                </div>
                <div class="form-group">
                    <label class="label" for="last_name">Last Name</label>
                    <input class="form-control" type="text" name="last_name" id="last_name" required>
                </div>
                <div class="form-group">
                    <label class="label" for="role">Role</label>
                    <select class="form-control" name="role" id="role" required>
                        <option value="" disabled selected>----</option>
                        <option value="1">Chef</option>
                        <option value="2">General Manager</option>
                        <option value="3">Cashier</option>
                        <option value="4">Inventory Manager</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="label" for="salary">Salary</label>
                    <input class="form-control" type="number" name="salary" id="salary" required min="0">
                </div>
                <div class="form-group">
                    <label class="label" for="username">Username</label>
                    <input class="form-control" type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label class="label" for="contact_no">Contact No</label>
                    <input class="form-control" type="text" name="contact_no" id="contact_no" required>
                </div>
                <div class="form-group">
                    <label class="label" for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email">
                </div>
                <div class="form-group">
                    <label class="label" for="NIC">NIC</label>
                    <input class="form-control" type="text" name="NIC" id="NIC" required>
                </div>
                <button class="btn btn-success text-uppercase fw-bold" type="submit" name="save" id="submit-button">Save
                    Employee
                </button>
                <button type="button" class="btn btn-secondary" id="cancel-button">Cancel</button>
            </form>
        </div>

    </div>
</body>
<style>
    .align-employees-start {
        align-items: start;
    }

    .align-employees-end {
        align-items: end;
    }

    .align-employees-center {
        align-items: center;
    }

    .align-employees-baseline {
        align-items: baseline;
    }

    .align-employees-stretch {
        align-items: stretch;
    }
</style>
</html>

<script>
    //don't allow duplicate usernames or ones with spaces or special characters
    function validateUsername(username){
        let usernames = <?php echo json_encode($ulist); ?>;
        console.log(usernames);
        var regex = /^[a-zA-Z0-9]+$/;

        if(username.length < 5){
            alert("Username must be at least 5 characters long");
            return false;
        }
        if(!regex.test(username)){
            alert("Username must contain only letters and numbers");
            return false;
        }
        if(usernames.includes(username)){
            alert("Username already exists");
            return false;
        }
    }

    let usernameinput = document.getElementById("username");
    usernameinput.addEventListener("change", function(){
        if (validateUsername(usernameinput.value) == false){
            //disable submit button
            document.getElementById("submit-button").disabled = true;
        }else{
            //enable submit button
            document.getElementById("submit-button").disabled = false;
        }
    });
</script>